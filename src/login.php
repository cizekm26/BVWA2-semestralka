<?php
require "db/db_connect.php";
require "user.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $login = $_POST["login"];
    $password = $_POST["heslo"];

    $connection = databaseConnection();

    if (authenticate($connection, $login, $password)) {
        $id = getUserID($connection, $login);

        // Dojde k regenerování session id, o kterém my budeme vědět, ale útočník ne
        session_regenerate_id(true);
        // Určí, že jde o přihlášeného uživatele
        $_SESSION["is_logged"] = true;
        // Uloží si ID tohoto uživatele (pro práci na dalších stránkách)
        $_SESSION["logged_user"] = $id;

        //uložení dat uživatele do proměnné pro další použití
        $userData = getUserData($connection, $id);
        $_SESSION["user_name"] = $userData;

        // Přesměrování
        header("Location: profile.php");
        exit();


    } else {
        $error_msg = "Některý z vyplněných údajů není správný!";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení do systému</title>
    <script src="./js/script.js"></script>
    <link href="../dist/output.css" rel="stylesheet">
</head>
<body class="bg-white">
<?php include "templates/header.php" ?>  
<div class="px-6 py-8 sm:px-24 md:px-32 lg:px-40 xl:px-48 2xl:px-64">  
<section class="flex flex-col xl:flex-row rounded-xl">
        <form
            action="login.php"
            method="post"
            class="flex flex-col w-full gap-3 px-12 pt-6 pb-4 rounded-t-lg xl:w-2/3 bg-zinc-100 xl:rounded-l-xl xl:rounded-tr-none">
            <h1 class="text-3xl font-extrabold">Přihlašovací formulář</h1>
            <span class="pt-2 font-semibold">Vyplňte následující pole svými údaji</span>
            <input
                type="text"
                name="login"
                placeholder="Zadejte přihlašovací jméno"
                required
                class="w-full px-2 pt-1 pb-2 border rounded-md border-slate-300 border-spacing-0 h-9 focus:outline-none focus:border focus:border-blue-950">
            <input
                type="password"
                name="heslo"
                placeholder="Zadejte heslo"
                required
                class="w-full px-2 pt-1 pb-2 border rounded-md border-slate-300 border-spacing-0 h-9 focus:outline-none focus:border focus:border-blue-950">
            <input 
                type="submit" 
                name="register"
                value="Přihlásit"
                class="w-40 mx-auto my-4 font-semibold text-white duration-300 ease-out rounded-md cursor-pointer bg-blue-500 h-9 hover:scale-105 hover:bg-sky-900 hover:shadow-md active:scale-95 active:bg-sky-700">
            <?php
                // Vypsání errorové zprávy
                if (!empty($error_msg)) {
                    echo "<span class='pt-2 text-xs font-semibold text-red-600'>$error_msg</span>";
                }
            ?>
        </form>
        <div class="flex flex-col justify-between w-full h-auto text-center text-white rounded-b-lg bg-blue-500 xl:w-1/3 px-7 pt-7 xl:pb-0 pb-7 xl:rounded-r-xl xl:rounded-bl-none">
            <div class="flex flex-col">
                <h2 class="mb-4 text-2xl font-bold">Jste zde poprvé?</h2>
                <span class="text-slate-200">Ještě u nás nemáte vytvořený žádný uživatelský účet a máte zájem?</span>
                <a 
                    href="registration.php"
                    class="mt-2 font-semibold underline duration-300 ease-out text-blue-white hover:text-slate-200 active:text-white">Zaregistrujte se!
                </a>
            </div>
            <img class="hidden xl:block" src="../public/imgs/image.png"> 
        </div>
            </section>
            </div>
</body>
</html>