<?php
// Redirect to the Auth0 handler to perform the logout.
// The handler will clear the session and redirect to Auth0's logout endpoint.
header('Location: auth0_handler.php?action=logout');
exit;
?>