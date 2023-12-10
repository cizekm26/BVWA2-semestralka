<?php
session_start(); 
include 'db/db_connect.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ziskani dat od uzivatele
    $username = $_POST['login'];
    $password = $_POST['heslo'];

    // overeni uzivatelev databazi
    $sql = "SELECT * FROM zamestnanci WHERE login = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        $hashedPassword = $userData['heslo'];

        // porovnani hesel a nasledne presmerovani
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $userData['id'];
            $_SESSION['user_name'] = $userData['jmeno'] . ' ' . $userData['prijmeni'];
            header("Location: profile.php");
            exit();
        } else {
           echo "Neplatné heslo";
        }
    } else {
        echo "Neplatné jméno";
    }
}
?>