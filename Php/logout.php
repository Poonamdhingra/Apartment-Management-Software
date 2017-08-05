<?php
// Starts the session
session_start();

// Destroys the session
session_destroy();

// Kicks the user home
header('Location: index.html');
?>
