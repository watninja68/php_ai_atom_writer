<?php
// This file acts solely as the entry point for the Auth0 redirect.
// All logic is handled within auth0_handler.php.

require_once __DIR__ . '/auth0_handler.php';

// The routing logic within auth0_handler.php checks for '?action=callback'
// which is implicitly handled because this file is the redirect target.
// If you didn't use '?action=callback' in the handler's routing,
// you would explicitly call handleCallback() here.

?>