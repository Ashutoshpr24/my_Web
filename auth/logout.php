<?php
session_start();

// destroying all session data
session_unset();
session_destroy();

// redirecting to login page
header("Location: login.php");
exit;
