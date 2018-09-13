<?php
session_start();
unset($_SESSION['access_token']);
session_unset();
session_destroy();
$redirect_uri = str_replace('logout.php', '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
?>