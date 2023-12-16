<?php
    // Funkce pro připojení do databáze
    function databaseConnection() {
        // Údaje k databázi
        $db_host = "localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "semestralni_prace";

        $connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

        if (mysqli_connect_error()) {
            echo mysqli_connect_error();
            exit;
        }

        return $connection;
    }
?>