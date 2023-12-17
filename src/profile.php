<?php 
session_start(); // Start the session
require 'db/db_connect.php';

$connection = databaseConnection();


if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    if (!is_numeric($user_id)) {
        //ID není číslo
        header("Location: index.php");
        exit();
    } 
} else if(isset($_SESSION['logged_user'])) {
    $user_id = $_SESSION['logged_user'];;
}else{
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM zamestnanci WHERE id = $user_id";

$result = $connection->query($sql);

if ($result !== false && $result->num_rows > 0) {
    //uživatel v databázi existuje
    $userData = $result->fetch_assoc();
} else {
    // uživatel nenalezen v databázi
    header("Location: index.php");
    exit();
}

$connection->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../dist/output.css" rel="stylesheet">
    <title>Profil</title>
    <script src="js/script.js"></script>
</head>


<body class="bg-white">
    <?php include 'templates/header.php'; ?>

    <div class="md:mx-20 max-w-md mx-auto mt-5 sm:max-w-xl lg:max-w-full lg:px-5">
        <div class="px-4 sm:px-0">
            <h1 class="text-3xl font-extrabold">Osobní údaje</h1>
        </div>
        <div class="bg-gray-100 rounded-md mt-5 grid lg:grid-cols-2 shadow">
            <div>
                <div class="bg-blue-500 p-5 lg:hidden rounded-t-md">
                    <img class="rounded-lg shadow-xl w-40 mx-auto" src="resources/<?php echo $userData['login']; ?>/<?php echo $userData['photo']; ?>">
                </div>
                <div class="mt-4 border-gray-100 md:m-5 sm:mx-auto">
                    <dl class="divide-y divide-blue-500">
                        <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-md font-medium">Jméno a příjmení</dt>
                            <dd class="mt-1 text-md sm:col-span-2 sm:mt-0">
                                <?php echo "{$userData['jmeno']} {$userData['prijmeni']}"; ?>
                            </dd>
                        </div>
                        <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-md font-medium">Email</dt>
                            <dd class="mt-1 text-md sm:col-span-2 sm:mt-0">
                                <?php echo "{$userData['email']}"; ?>
                            </dd>
                        </div>
                        <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-md font-medium">Telefon</dt>
                            <dd class="mt-1 text-md sm:col-span-2 sm:mt-0"><?php echo "{$userData['telefon']}"; ?></dd>
                        </div>
                        <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-md font-medium">Pohlaví</dt>
                            <dd class="mt-1 text-md sm:col-span-2 sm:mt-0">
                                <?php echo "{$userData['pohlavi']}"; ?>
                            </dd>
                        </div>
                        <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-md font-medium">Login</dt>
                            <dd class="mt-1 text-md sm:col-span-2 sm:mt-0">
                                <?php echo "{$userData['login']}"; ?>
                            </dd>
                        </div>
                        <div class="p-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                            <dt class="text-md font-medium">Role</dt>
                            <dd class="mt-1 text-md sm:col-span-2 sm:mt-0">
                                <?php echo "{$userData['role']}"; ?>
                            </dd>
                        </div>
                    </dl>
                    <div class="p-5">
                        <?php
                        // zpřístupění tlačítek, podle toho, jestli je uživatel admin
                        if ($_SESSION['user_name']['role'] == 'admin' || ($_SESSION['logged_user'] == $user_id)) {
                            echo '<a class="rounded-lg shadow-lg text-sm text-white bg-blue-500 px-4 py-3 uppercase font-semibold" href="edit.php?id=' . $userData['id'] . '">Upravit</a>';
                        } 
                        ?>
                    </div>
                </div>
            </div>
            <div class="hidden relative lg:block bg-blue-500 p-5 w-full h-full rounded-r-md">
                <img class="rounded-lg shadow-xl w-40"
                    src="resources/<?php echo $userData['login']; ?>/<?php echo $userData['photo']; ?>">
            </div>
        </div>
</body>

</html>