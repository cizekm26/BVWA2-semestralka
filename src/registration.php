<?php
require "db/db_connect.php";
require "user.php";


session_start();
$msg = null;
$user_msg = null;

$connection = databaseConnection();
// Po odeslání formuláře se provádí následující kód
if (isset($_POST["register"]) && isset($_FILES["photo"])) {
    $first_name =       $_POST["first_name"];
    $last_name =        $_POST["last_name"];
    $phone_number =     $_POST["phone_prefix"] . $_POST["phone_number"]; // Spojení předvolby a čísla
    $email =            $_POST["email"];
    $gender =           $_POST["gender"];
    $login =            $_POST["login"];
    $password = password_hash($_POST["password_first"], PASSWORD_DEFAULT);

    //$err = anyProblemWithPhoto(photo($conn, $login));   
    $existing_user = doesThisUserExists($connection, $login);

    // Pokud se uživatel může registrovat, proběhne nahrání jeho údajů do databáze
    if (!$existing_user) {
        if (!isset($_POST["photo"])) {
        }
        $photo = photo($connection, $login);

        //if (!$err === "OK") {
        // Získání ID uživatele a zároveň nahrání jeho údajů do databáze
        $id = createUser($connection, $first_name, $last_name, $phone_number, $email, $gender, $login, $password, $photo);
        if (!empty($id)) {
            // Zabránění fixation attack
            // Dojde k regenerování session id, o kterém my budeme vědět, ale útočník ne
            session_regenerate_id(true);

            // Určí, že jde o přihlášeného uživatele
            $_SESSION["is_logged"] = true;
            // Uloží si ID tohoto uživatele (pro práci na dalších stránkách)
            $_SESSION["logged_user"] = $id;

            $userData = getUserData($connection, $id);
            $_SESSION["user_name"] = $userData;

            // Přesměrování
            header('Location: profile.php');
            exit();
        } else if ($id === "error") {
            $err = "Uživatele se nepodařilo přidat!";
        } else if ($id === "login") {
            $err = "Uživatel s tímto loginem již existuje!";
        } else {
            $err = "Nečekaná chyba!";
        }
        $msg = null;
        $user_msg = null;
    } else {
        $msg = null;
        $user_msg = $existing_user;
        echo '<script>alert("uživatel se stejným jménem již existuje")</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrace do systému</title>
    <script src="./js/script.js"></script>
    <link href="../dist/output.css" rel="stylesheet">
</head>

<body class="bg-white">
    <?php include "templates/header.php" ?>
    <div class="px-6 py-8 sm:px-24 md:px-32 lg:px-40 xl:px-48 2xl:px-64">
        <section class="flex flex-col xl:flex-row rounded-xl">
            <div class="flex flex-col justify-between w-full h-auto text-center text-white rounded-t-lg rounded-bl-none bg-blue-600 xl:w-1/3 px-7 pt-7 xl:pb-0 pb-7 xl:rounded-l-xl xl:rounded-tr-none">
                <div class="flex flex-col">
                    <h2 class="mb-4 text-2xl font-bold">Nejste zde poprvé?</h2>
                    <span class="text-slate-200">Pokud jste si již váš uživatelský účet vytvořil/a a chcete se přihlásit...</span>
                    <a href="login.php" class="mt-2 font-semibold underline duration-300 ease-out text-blue-white hover:text-slate-200 active:text-white">Přihlašte se!</a>
                </div>
                <img class="hidden xl:block" src="../public/imgs/image.png">
            </div>
            <form action="registration.php" method="post" enctype="multipart/form-data" class="flex flex-col w-full gap-3 px-12 pt-6 pb-4 rounded-b-lg xl:w-2/3 bg-zinc-100 xl:rounded-r-xl xl:rounded-bl-none">
                <h1 class="text-3xl font-extrabold">Registrační formulář</h1>
                <span class="pt-2 font-semibold">Základní údaje</span>
                <div class="flex flex-col gap-3 lg:flex-row">
                    <input type="text" name="first_name" placeholder="Zadejte jméno" required class="w-full px-2 pt-1 pb-2 border rounded-md border-slate-300 border-spacing-0 h-9 focus:outline-none focus:border focus:border-blue-950">
                    <input type="text" name="last_name" placeholder="Zadejte příjmení" required class="w-full px-2 pt-1 pb-2 border rounded-md border-slate-300 border-spacing-0 h-9 focus:outline-none focus:border focus:border-blue-950">
                </div>
                <div class="flex flex-row gap-3">
                    <select name="phone_prefix" required class="px-2 pt-1 pb-2 border rounded-md border-slate-300 border-spacing-0 h-9 w-min focus:outline-none focus:border focus:border-blue-950">
                        <option>+420</option>
                        <option>+421</option>
                    </select>
                    <input type="tel" name="phone_number" placeholder="Zadejte telefonní číslo" required class="phone-input w-full px-2 pt-1 pb-2 border rounded-md border-slate-300 border-spacing-0 h-9 focus:outline-none focus:border focus:border-blue-950">
                </div>
                <span class="text-xs font-semibold phone-info hidden"></span>
                <input type="email" name="email" placeholder="Zadejte emailovou adresu" required class="w-full px-2 pt-1 pb-2 border rounded-md border-slate-300 border-spacing-0 h-9 focus:outline-none focus:border focus:border-blue-950">
                <div class="flex flex-col gap-3 mt-2 lg:flex-row">
                    <div class="w-full">
                        <span class="font-semibold">Vyberte pohlaví</span>
                        <fieldset class="flex flex-row gap-8 mt-4">
                            <div>
                                <input type="radio" id="male" value="muz" name="gender" checked>
                                <label for="male">
                                    Muž
                                </label>
                            </div>
                            <div>
                                <input type="radio" id="female" value="zena" name="gender">
                                <label for="female">
                                    Žena
                                </label>
                            </div>
                        </fieldset>
                    </div>
                    <div class="w-full mt-1 lg:mt-0">
                        <span class="font-semibold">Vyberte profilový obrázek</span>
                        <input type="file" name="photo" required class="w-full pt-1 pb-2 pl-1 pr-2 mt-2 text-gray-400 bg-white border rounded-md input-photo border-slate-300 border-spacing-0 h-9 file:border-0 file:h-max file:cursor-pointer file:rounded-md file:bg-gray-200">
                        <span class="text-xs font-semibold text-red-600 output-photo">
                            <?php echo $msg; ?>
                        </span>
                    </div>
                </div>
                <span class="pt-2 font-semibold">Uživatelské údaje</span>
                <input type="text" name="login" placeholder="Zadejte přihlašovací jméno" required class="w-full px-2 pt-1 pb-2 border rounded-md input-login border-slate-300 border-spacing-0 h-9 focus:outline-none focus:border focus:border-blue-950">
                <span class="text-xs font-semibold text-red-600 output-login hidden">
                    <?php echo $user_msg; ?>
                </span>
                <div class="flex flex-col gap-3 lg:flex-row">
                    <input type="password" name="password_first" placeholder="Zadejte heslo" required class="w-full px-2 pt-1 pb-2 border rounded-md password-first border-slate-300 border-spacing-0 h-9 focus:outline-none focus:border focus:border-blue-950">
                    <input type="password" name="password_second" placeholder="Zadejte heslo znovu" required class="w-full px-2 pb-2 border rounded-md pt-1 password-second border-slate-300 border-spacing-0 h-9 focus:outline-none focus:border focus:border-blue-950">
                </div>
                <span class="text-xs font-semibold info hidden"></span>
                <input type="submit" name="register" value="Zaregistrovat" class="w-1/3 mx-auto my-4 font-semibold text-white duration-300 ease-out rounded-md cursor-pointer submit-button submit-w-40 submit button register-button regiser-button bg-blue-500 h-9 hover:scale-105 hover:bg-sky-900 hover:shadow-md active:scale-95 active:bg-sky-700">
            </form>
        </section>
    </div>
    <!-- Javascript ... -->
    <script src="./js/password-check.js"></script>
    <script src="./js/input-info-hide.js"></script>
</body>

</html>