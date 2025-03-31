<?php
declare(strict_types=1);
if (session_status() === PHP_SESSION_NONE) {
    // Consider adding session cookie parameters for security
    // session_set_cookie_params(['lifetime' => 7200, 'path' => '/', 'domain' => $_SERVER['HTTP_HOST'], 'secure' => true, 'httponly' => true, 'samesite' => 'Lax']);
    session_start();
}
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

// Centralized session start - THIS IS THE ONLY PLACE IT SHOULD BE CALLED


// Function definitions (handleLogin, getUser, isAuthenticated, redirectToLoginWithError remain largely the same)

function handleLogin(Auth0 $auth0): void
{
    $auth0->clear();
    // Store the intended destination if the user was trying to access a specific page
    // Note: This assumes the login redirect originates from a page check.
    // If login starts ONLY from login.php, this won't capture the original page.
    // A more robust way might involve passing a 'redirect_to' param through the login process.
    if (isset($_SESSION['redirect_url_pending'])) {
         $_SESSION['redirect_url'] = $_SESSION['redirect_url_pending'];
         unset($_SESSION['redirect_url_pending']);
    }
    header("Location: " . $auth0->login());
    exit;
}


function handleCallback(Auth0 $auth0, ?PDO $pdo): void
{
    if (!$pdo) {
         error_log("PDO connection not available in Auth0 callback. Cannot link user.");
         redirectToLoginWithError('Database service unavailable during login.');
         return;
    }

    try {
        $auth0->exchange();
        $user = $auth0->getUser();

        if ($user === null) {
            error_log('Auth0 callback did not return a user.');
            redirectToLoginWithError('Authentication failed. Please try again.');
            return;
        }

        $auth0UserId = $user['sub']; // The unique Auth0 user ID (string)
        $email = $user['email'] ?? null;
        $name = $user['name'] ?? $user['nickname'] ?? 'Auth0 User';
        $picture = $user['picture'] ?? null;
        $emailVerified = $user['email_verified'] ?? false;

        // --- Database Linking/Creation ---
        $internalUserId = null;
        $isNewUser = false;

        try {
            // Check if user exists by Auth0 ID
            // Ensure 'auth0_user_id' column exists in your 'users' table!
            $stmt = $pdo->prepare("SELECT id FROM users WHERE auth0_user_id = :auth0_id LIMIT 1");
            $stmt->execute([':auth0_id' => $auth0UserId]);
            $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingUser) {
                // User exists, get internal ID
                $internalUserId = (int) $existingUser['id']; // Cast to int

                // Optional: Update user details if they changed in Auth0
                $updateStmt = $pdo->prepare(
                    "UPDATE users SET name = :name, email = :email, email_verified_at = :email_verified, data = JSON_SET(COALESCE(data, '{}'), '$.picture', :picture), updated_at = NOW()
                     WHERE id = :id"
                );
                $updateStmt->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':email_verified' => $emailVerified ? date('Y-m-d H:i:s') : null,
                    ':picture' => $picture,
                    ':id' => $internalUserId
                ]);

            } else {
                // User does not exist, create a new one
                $insertStmt = $pdo->prepare(
                    "INSERT INTO users (auth0_user_id, name, email, email_verified_at, status, data, created_at, updated_at)
                     VALUES (:auth0_id, :name, :email, :email_verified, :status, :data, NOW(), NOW())"
                );
                // Note: Removed password insert, assuming it's nullable or has a default

                $insertStmt->execute([
                    ':auth0_id' => $auth0UserId,
                    ':name' => $name,
                    ':email' => $email,
                    ':email_verified' => $emailVerified ? date('Y-m-d H:i:s') : null,
                    ':status' => 'active', // Or your default status
                    ':data' => json_encode(['picture' => $picture]) // Store picture or other data
                ]);

                $internalUserId = (int) $pdo->lastInsertId(); // Cast to int
                $isNewUser = true;
                // Potential actions for new users: assign default plan, trigger welcome email, etc.
            }

        } catch (PDOException $e) {
            error_log("Database error during Auth0 callback user linking: " . $e->getMessage());
            // If it's a unique constraint violation on email but not auth0_id, handle linking?
            // For now, redirect with a generic error.
            redirectToLoginWithError('A database error occurred while processing your account.');
            return; // Stop execution
        }
        // --- End Database Linking ---

        // Regenerate session ID upon successful login for security
        session_regenerate_id(true);

        // Store essential info in session
        $_SESSION['auth0_user'] = $user; // Keep Auth0 profile if needed elsewhere
       /* $_SESSION['auth0_loggedin'] = true;*/
        /*$_SESSION['user_id'] = $internalUserId; // Store YOUR internal user ID (INT)*/
        /*$_SESSION['user_email'] = $email; // Store email*/
        /*$_SESSION['user_name'] = $name;   // Store name*/
        /*$_SESSION['user_picture'] = $picture; // Store picture*/

        // --- Redirect Logic ---
        $redirectTarget = 'dashboard.php'; // Default redirect
        if (isset($_SESSION['redirect_url']) && !empty($_SESSION['redirect_url'])) {
            // Basic validation: ensure it's a relative path within your site
            if (parse_url($_SESSION['redirect_url'], PHP_URL_HOST) === null && substr($_SESSION['redirect_url'], 0, 1) === '/') {
                 $redirectTarget = $_SESSION['redirect_url'];
            }
             unset($_SESSION['redirect_url']); // Clean up session
        }

        header('Location: ' . $redirectTarget);
        exit;

    } catch (\Auth0\SDK\Exception\StateException $e) {
        error_log('Auth0 StateException: ' . $e->getMessage());
        redirectToLoginWithError('Invalid state preventing login. Please try logging in again.');
    } catch (\Auth0\SDK\Exception\ConfigurationException $e) {
        error_log('Auth0 ConfigurationException: ' . $e->getMessage());
        redirectToLoginWithError('Authentication service configuration error.');
    } catch (\Auth0\SDK\Exception\NetworkException $e) {
        error_log('Auth0 NetworkException: ' . $e->getMessage());
        redirectToLoginWithError('Cannot connect to authentication service. Please try again later.');
    } catch (\Exception $e) {
        error_log('Auth0 Callback General Error: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
        redirectToLoginWithError('An unexpected error occurred during login. Please try again.');
    }
}

function handleLogout(Auth0 $auth0): void
{
    // Redirect to Auth0 logout endpoint.
    // It will clear Auth0 session cookies and then redirect back to the URL specified here.
    $logoutUrl = $auth0->logout($_ENV['AUTH0_BASE_URL'] . '/login.php?loggedout=true'); // Added param for feedback

    // Clear local session data before redirecting
    $_SESSION = array(); // Clear all session variables
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy(); // Destroy the session

    header('Location: ' . $logoutUrl);
    exit;
}


function getUser(): ?array // Keep this if you need the full Auth0 profile elsewhere
{
    return $_SESSION['auth0_user'] ?? null;
}

function isAuthenticated(): bool
{
    // Check for both Auth0 flag AND your internal user ID
    return isset($_SESSION['auth0_loggedin']) && $_SESSION['auth0_loggedin'] === true && isset($_SESSION['user_id']) && is_int($_SESSION['user_id']);
}

function redirectToLoginWithError(string $message): void
{
    // Clear any partial login state before redirecting
    if (isset($_SESSION)) { // Check if session exists before trying to modify it
        unset($_SESSION['auth0_loggedin'], $_SESSION['auth0_user'], $_SESSION['user_id']);
        $_SESSION['login_error'] = $message;
    }
    header('Location: login.php'); // Redirect to login page
    exit;
}

// --- End of Function Definitions ---

// Note: Removed routing logic from here. It belongs in specific entry points like auth_action.php or auth0_callback.php.

?>
