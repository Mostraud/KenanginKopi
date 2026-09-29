<?php
session_start();

session_unset();

session_destroy();

if (isset($_COOKIE['user_session'])) {
    setcookie('user_session', '', time() - 3600, '/');
}

header("Location: login.php");
exit();
?>