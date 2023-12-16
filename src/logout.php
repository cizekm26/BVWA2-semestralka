<?php
// Oficiální kód z php.net pro zničení session https://www.php.net/manual/en/function.session-destroy.php

session_start();

// Nastaví session na prázdné pole - zničí všechny sessiony
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, // Nastaví session_name na prázdno a time zničí
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"] // Zničení dalších informací, které se session ID jsou spojené
    );
}

// Zničení všech session
session_destroy();
header("Location: login.php");
exit();
?>