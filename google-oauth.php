<?php
// Start session at the very beginning
session_start();

// Include the Google API Client Library
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Google OAuth Configuration
$google_oauth_client_id = $_ENV['GOOGLE_CLIENT_ID'];
$google_oauth_client_secret = $_ENV['GOOGLE_CLIENT_SECRET'];
// Make sure this matches EXACTLY with what's in Google Cloud Console
$google_oauth_redirect_uri = 'http://localhost/php_ai_writer/google-oauth.php';

// Initialize Google Client
$client = new Google\Client();
$client->setClientId($google_oauth_client_id);
$client->setClientSecret($google_oauth_client_secret);
$client->setRedirectUri($google_oauth_redirect_uri);
$client->addScope("email");
$client->addScope("profile");

// Handle the OAuth flow
if (isset($_GET['code'])) {
    try {
        // Exchange authorization code for access token
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($token);

        // Get user information
        $oauth2 = new Google\Service\Oauth2($client);
        $user_info = $oauth2->userinfo->get();

        // Secure session handling
        session_unset();
        session_regenerate_id(true);

        // Store user data in session
        $_SESSION['google_loggedin'] = true;
        $_SESSION['google_email'] = $user_info->email;
        $_SESSION['google_name'] = $user_info->name;
        $_SESSION['google_picture'] = $user_info->picture;

        // Verify session
        if(!isset($_SESSION['google_loggedin'])) {
            throw new Exception("Session initialization failed");
        }

        // Redirect to profile page
        header('Location: profile.php');
        exit;

    } catch (Exception $e) {
        error_log('Authentication error: ' . $e->getMessage());
        header('Location: error.php?msg=Authentication failed');
        exit;
    }
} else {
    // Generate and redirect to Google's OAuth URL
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit;
}

// Utility functions
function checkSession() {
    return session_status() !== PHP_SESSION_NONE;
}

function debugSessionSettings() {
    echo "<pre>";
    echo "Session Settings:\n";
    echo "session.save_handler: " . ini_get('session.save_handler') . "\n";
    echo "session.save_path: " . ini_get('session.save_path') . "\n";
    echo "session.use_cookies: " . ini_get('session.use_cookies') . "\n";
    echo "session.name: " . session_name() . "\n";
    echo "session_id: " . session_id() . "\n";
    echo "</pre>";
}
?>
