<?php
session_start(); // Start the session
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/script.js"></script>
    <link href="../dist/output.css" rel="stylesheet">
    <title>Přihlášení</title>
</head>

<body>
    <?php require 'templates/header.php'; ?>

    <?php
    // overeni uzivatele
    if (!isset($_SESSION['user_id'])) {
        echo "Uživatel neověřen!";
        header("Location: login.php");
        exit();
    }
    ?>
</body>

</html>