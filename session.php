<?php
session_start();
echo "<pre>";
echo "Testing Session Functionality\n\n";

// Try to set a session variable
$_SESSION['test'] = 'Hello World';

// Verify it was set
if(isset($_SESSION['test'])) {
    echo "Session variable was set successfully\n";
    echo "Value: " . $_SESSION['test'] . "\n";
} else {
    echo "Failed to set session variable\n";
}

// Display all session data
echo "\nAll Session Data:\n";
print_r($_SESSION);

// Display session info
echo "\nSession Info:\n";
echo "Session ID: " . session_id() . "\n";
echo "Session Name: " . session_name() . "\n";
echo "Session Status: " . session_status() . "\n";
echo "</pre>";
?>
