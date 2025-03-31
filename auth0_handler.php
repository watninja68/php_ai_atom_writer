<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/db_init.php'; // Include DB config if needed later for user linking

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;
use Dotenv\Dotenv;

// Load environment variables
try {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
    $dotenv->required(['AUTH0_DOMAIN', 'AUTH0_CLIENT_ID', 'AUTH0_CLIENT_SECRET', 'AUTH0_COOKIE_SECRET', 'AUTH0_BASE_URL']);
} catch (Exception $e) {
    error_log("Error loading .env file: " . $e->getMessage());
    die('Required environment variables are missing. Check your .env file and logs.');
}

// Configure Auth0 SDK
$configuration = new SdkConfiguration(
    domain: $_ENV['AUTH0_DOMAIN'],
    clientId: $_ENV['AUTH0_CLIENT_ID'],
    clientSecret: $_ENV['AUTH0_CLIENT_SECRET'],
    cookieSecret: $_ENV['AUTH0_COOKIE_SECRET'],
    redirectUri: $_ENV['AUTH0_BASE_URL'] . '/auth0_callback.php', // Must match URL in Auth0 dashboard
);

$auth0 = new Auth0($configuration);

// Centralized session start
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Initiates the login process by redirecting to Auth0 Universal Login.
 */
function handleLogin(Auth0 $auth0): void
{
    // Clear any previous session state to avoid conflicts
    $auth0->clear();
    // Redirect to Auth0 login page
    header("Location: " . $auth0->login());
    exit;
}

/**
 * Handles the callback from Auth0 after authentication.
 */
function handleCallback(Auth0 $auth0, ?PDO $pdo): void
{
    try {
        // Attempt to exchange the authorization code for tokens and user profile
        $auth0->exchange();
        $user = $auth0->getUser();

        if ($user === null) {
            // ... error handling ...
            return;
        }
        
        $auth0UserId = $user['sub']; // The unique Auth0 user ID
        $email = $user['email'] ?? null;
        $name = $user['name'] ?? $user['nickname'] ?? 'Auth0 User';
        $picture = $user['picture'] ?? null;
        $emailVerified = $user['email_verified'] ?? false;
        
        // --- Database Linking/Creation ---
        $internalUserId = null;
        $isNewUser = false;
        
        if ($pdo) { // Check if PDO connection was successful
            try {
                // Check if user exists by Auth0 ID
                $stmt = $pdo->prepare("SELECT id FROM users WHERE auth0_user_id = :auth0_id LIMIT 1");
                $stmt->execute([':auth0_id' => $auth0UserId]);
                $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($existingUser) {
                    // User exists, get internal ID
                    $internalUserId = $existingUser['id'];
        
                    // Optional: Update user details if they changed in Auth0
                    $updateStmt = $pdo->prepare("UPDATE users SET name = :name, email = :email, data = JSON_SET(COALESCE(data, '{}'), '$.picture', :picture) WHERE id = :id");
                    $updateStmt->execute([
                        ':name' => $name,
                        ':email' => $email,
                        ':picture' => $picture,
                        ':id' => $internalUserId
                    ]);
        
                } else {
                    // User does not exist, create a new one
                    $insertStmt = $pdo->prepare(
                        "INSERT INTO users (auth0_user_id, name, email, email_verified_at, password, status, data, created_at, updated_at)
                         VALUES (:auth0_id, :name, :email, :email_verified, :password, :status, :data, NOW(), NOW())"
                    );
        
                    // Generate a secure random password (user won't use it directly)
                    $randomPassword = password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT);
        
                    $insertStmt->execute([
                        ':auth0_id' => $auth0UserId,
                        ':name' => $name,
                        ':email' => $email,
                        ':email_verified' => $emailVerified ? date('Y-m-d H:i:s') : null,
                        ':password' => $randomPassword, // Required by schema, but unused for Auth0 login
                        ':status' => 'active', // Or your default status
                        ':data' => json_encode(['picture' => $picture]) // Store picture or other data
                    ]);
        
                    $internalUserId = $pdo->lastInsertId();
                    $isNewUser = true;
                }
        
            } catch (PDOException $e) {
                error_log("Database error during Auth0 callback: " . $e->getMessage());
                // Decide how to proceed. Maybe log error and continue without internal ID?
                // Or redirect with a generic error.
                redirectToLoginWithError('A database error occurred during login.');
                return; // Stop execution if DB link fails
            }
        } else {
             error_log("PDO connection not available in Auth0 callback. Cannot link user.");
             // Handle case where DB connection failed earlier - maybe allow login without linking?
        }
        // --- End Database Linking ---
        
        
        // Store Auth0 info AND internal user ID (if available)
        $_SESSION['auth0_user'] = $user;
        $_SESSION['auth0_loggedin'] = true;
        $_SESSION['user_id'] = $internalUserId; // Store your internal user ID
        $_SESSION['user_email'] = $email;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_picture'] = $picture;
        
        // Redirect to dashboard
        header('Location: dashboard.php');
        exit;

    } catch (\Auth0\SDK\Exception\StateException $e) {
        error_log('Auth0 StateException: ' . $e->getMessage());
        redirectToLoginWithError('Invalid state. Please try logging in again.');
    } catch (\Auth0\SDK\Exception\ConfigurationException $e) {
        error_log('Auth0 ConfigurationException: ' . $e->getMessage());
        redirectToLoginWithError('Authentication service configuration error.');
    } catch (\Auth0\SDK\Exception\NetworkException $e) {
        error_log('Auth0 NetworkException: ' . $e->getMessage());
        redirectToLoginWithError('Cannot connect to authentication service. Please try again later.');
    } catch (\Exception $e) {
        error_log('Auth0 Callback General Error: ' . $e->getMessage());
        // Log the full error for debugging, but show a generic message to the user
        redirectToLoginWithError('An unexpected error occurred during login. Please try again.');
    }
}

/**
 * Logs the user out from both the application and Auth0.
 */
function handleLogout(Auth0 $auth0): void
{
    // The logout URL must be configured in your Auth0 Application settings -> Allowed Logout URLs
    $logoutUrl = $auth0->logout($_ENV['AUTH0_BASE_URL'] . '/login.php');
    header('Location: ' . $logoutUrl);
    exit;
}

/**
 * Retrieves the authenticated user's profile from the session.
 */
function getUser(): ?array
{
    return $_SESSION['auth0_user'] ?? null;
}

/**
 * Checks if the user is authenticated.
 */
function isAuthenticated(): bool
{
    return isset($_SESSION['auth0_loggedin']) && $_SESSION['auth0_loggedin'] === true && isset($_SESSION['auth0_user']);
}

/**
 * Redirects to the login page with an error message.
 */
function redirectToLoginWithError(string $message): void
{
    $_SESSION['login_error'] = $message;
    header('Location: login.php');
    exit;
}

// --- Routing Logic (Example using GET parameter) ---
// In a real app, you might use a more robust router.
// --- Routing Logic ---
$action = $_GET['action'] ?? null;
// Get the filename of the script that is actually being executed by the web server
$currentScript = basename($_SERVER['SCRIPT_FILENAME']); // More reliable than PHP_SELF

// Establish PDO connection (if not already done - ensure $pdo is available)
$pdo = null;
try {
    // Make sure $dsn, $dbUser, $dbPass are defined from db_init.php which should be included above
    $pdo = new PDO($dsn, $dbUser, $dbPass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    error_log("Database connection failed in auth0_handler routing: " . $e->getMessage());
    // Handle error appropriately, maybe redirect to login with error
    redirectToLoginWithError('Database connection error during authentication.');
    // Ensure script stops if DB connection fails here
}

if ($action === 'login') {
    handleLogin($auth0);
}
// Check if the current script being run *is* the callback script
elseif ($currentScript === 'auth0_callback.php') {
    // If this handler is included by auth0_callback.php, we *know* it's the callback phase
    handleCallback($auth0, $pdo); // Pass $pdo if doing DB linking
}
elseif ($action === 'logout') {
    handleLogout($auth0);
}
else {
    // Only display the error if it's not the callback script and not a known action
    if ($currentScript !== 'auth0_callback.php') {
        echo "Invalid Auth Action.";
        // Optional: Redirect to login page as a fallback?
        // header('Location: login.php');
        exit;
    }
    // If it *is* the callback script but somehow failed before handleCallback,
    // you might already be redirected by error handling within handleCallback.
    // If not, you could add more specific error logging here.
}

// Ensure the handleCallback function itself has the redirect:
// Inside the handleCallback function, make sure this line exists and is reached on success:
// header('Location: dashboard.php');
// exit;
?>