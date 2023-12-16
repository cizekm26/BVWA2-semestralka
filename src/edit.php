<?php
session_start(); // Start the session
require 'db/db_connect.php';
require 'user.php';

$connection = databaseConnection();

//ziskani dat uzivatele
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
} else if (!isset($_SESSION['logged_user'])) {
    $userId = $_SESSION['logged_user'];
} else {
    header('Location: index.php');
    exit();
}

// zjištění jestli je uživatel admin, nebo si edituje vlastní profil
if ($_SESSION['user_name']['role'] != 'admin' && $_SESSION['user_name']['id'] != $_GET['id']) {
    header("Location: employee-list.php");
    exit();
}


$sql = "SELECT * FROM zamestnanci WHERE id = $userId";
$result = $connection->query($sql);

if ($result && $result->num_rows > 0) {

    $userData = $result->fetch_assoc();
} else {
    echo "Uživatel nenalezen";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../dist/output.css" rel="stylesheet">
    <script src="./js/script.js"></script>
    <title>Upravit profil</title>
</head>

<body class="bg-white">
    <?php include './templates/header.php'; ?>
    <div class="md:mx-20 mx-auto max-w-lg mt-5 sm:max-w-xl lg:max-w-full lg:px-5 flex items-center flex-col">
        <div class="px-4 sm:px-0">
            <h1 class="text-3xl font-extrabold">Upravit profil</h1>
        </div>
        <form method="post" enctype="multipart/form-data" class="bg-gray-100 mt-5 w-full max-w-lg shadow-md p-5 rounded mb-5" onsubmit="return validatePasswords();">
            <fieldset>
                <legend class="text-xl font-bold mb-4 border-b-2 border-blue-500">Základní údaje</legend>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="name">
                            Jméno
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500" name="jmeno" id="name" type="text" required autocomplete="name" value="<?php echo "{$userData['jmeno']}"; ?>" />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="last-name">
                            Příjmení
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500" id="last-name" name="prijmeni" type="text" required value="<?php echo "{$userData['prijmeni']}"; ?>" />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="gender" required>
                            Pohlaví
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500" id="gender" name="pohlavi" required>
                            <option value="muž" <?php echo ($userData['pohlavi'] == 'muž') ? 'selected' : ''; ?>>muž
                            </option>
                            <option value="žena" <?php echo ($userData['pohlavi'] == 'žena') ? 'selected' : ''; ?>>
                                žena</option>
                        </select>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="email">
                            Email
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500" id="email" type="email" name="email" required value="<?php echo "{$userData['email']}"; ?>">
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="telefon">
                            Telefon
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500" id="telefon" type="tel" name="telefon" required value="<?php echo "{$userData['telefon']}"; ?>">
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="photo">
                            Profilová fotka
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="photo" name="photo" value="<?php echo "{$userData['photo']}"; ?>" type="file" />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="login">
                            Login
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500" id="login" type="text" name="login" required value="<?php echo "{$userData['login']}"; ?>" />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="role">
                            Role
                        </label>
                    </div>
                    <div class="md:w-2/3">
                    <select class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="role" name="role" required>
                            <?php if ($_SESSION['user_name']['role'] === 'admin') { ?>
                                <option value="admin" <?php echo ($userData['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <?php } ?>
                            <option value="user" <?php echo ($userData['role'] == 'user') ? 'selected' : ''; ?>>User
                            </option>
                        </select>
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend class="text-xl font-bold mb-4 border-b-2 border-blue-500 ">Změna hesla</legend>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-2/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="password-checkbox">
                            Přejete si změnit heslo?
                        </label>
                    </div>
                    <div class="md:w-1/3">
                        <input onclick="enablePasswordChange()" type="checkbox" class="w-5 h-5 text-xl bg-white border-2 border-grey-900 rounded py-2 px-4 focus:outline-none focus:border-blue-500" id="password-checkbox" type="password-checkbox" />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="password">
                            Nové heslo
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500" id="password" type="password" minlength="8" disabled />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="password-repeat">
                            Heslo znovu
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500" id="password-repeat" type="password" name="heslo" minlength="8" disabled />
                    </div>
                </div>
            </fieldset>
            <div class="flex items-center mb-6">
                <button class="w-1/2 mr-5 rounded-lg shadow-lg text-sm text-white bg-blue-500 px-4 py-3 uppercase font-semibold">
                    Uložit
                </button>
        </form>
        <form method="post" class="w-1/2">
            <input type="hidden" name="login" value="<?php echo $userData['login']; ?>">
            <button name="delete_profile" class="w-full rounded-lg shadow-lg text-sm bg-red-500 text-white px-4 py-3 uppercase font-semibold" type="submit">
                Smazat profil
            </button>
        </form>


    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST["delete_profile"])) {
            //odebirani uzivatele
    
            $sql = "DELETE FROM zamestnanci WHERE id = $userId";

            if ($connection->query($sql) === TRUE) {
                $folder_path = "./resources/" . $_POST['login'];

                echo '<meta http-equiv="refresh" content="0;url=employee-list.php">';
                //kontrola jestli neodbirame prihlaseneho uzivatele
                if (isset($_SESSION['user_name']['id']) && $_SESSION['user_name']['id'] == $userId) {
                    unset($_SESSION['logged_user']);
                    session_destroy();
                    header("Location: login.php");
                    exit();
                }
                
                if (file_exists($folder_path) && is_dir($folder_path)) {
                    // Smazani vsech souboru ve slozce
                    $files = glob($folder_path . '/*');
                    foreach ($files as $file) {
                        if (is_file($file)) {
                            unlink($file);
                        }
                    }

                    // Smazani prazdne slozky
                    rmdir($folder_path);
                    
                } else {
                    echo "složka nenalezena";
                }
            } else {
                echo "Chyba při odebírání záznamu " . $conn->error;
            }
        } else {
            //ziskani dat z inputu
            $name = isset($_POST['jmeno']) ? $_POST['jmeno'] : '';
            $lastName = isset($_POST['prijmeni']) ? $_POST['prijmeni'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $telephone = isset($_POST['telefon']) ? $_POST['telefon'] : '';
            $gender = isset($_POST['pohlavi']) ? $_POST['pohlavi'] : '';
            $login = isset($_POST['login']) ? $_POST['login'] : '';
            $role = isset($_POST['role']) ? $_POST['role'] : '';


            //kontrola jestli se photo načetlo správně
            if (isset($_FILES['photo'])) {
                $photo = photo($connection, $login);
            } else {
                $photo = '';
            }

            if(isset($_POST['heslo'])){
                $password = isset($_POST['heslo']);
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            }else{
                $hashedPassword = $userData['heslo'];
            }

            //vlozeni dat do databaze
            $stmt = $connection->prepare("UPDATE zamestnanci 
                              SET jmeno = ?, prijmeni = ?, pohlavi = ?, email = ?, telefon = ?,login = ?, role = ?, heslo = ?, photo = ?
                              WHERE id = ?");
            $stmt->bind_param("sssssssssi", $name, $lastName, $gender, $email, $telephone, $login, $role, $hashedPassword, $photo, $userId);
            $stmt->execute();


            $connection->query($sql);
        }
        echo '<script>window.location.href = "profile.php?id=' . $userId . '";</script>';
    }

    $connection->close();
    ?>

    </div>
</body>

<script>
    // po zaskrtnutí políčka se aktivují pole pro psaní hesel
    function enablePasswordChange() {
        var checkbox = document.getElementById("password-checkbox");
        var password = document.getElementById("password");
        var passwordRepeat = document.getElementById("password-repeat");
        if (checkbox.checked) {
            password.disabled = false;
            passwordRepeat.disabled = false;
        } else {
            password.disabled = true;
            passwordRepeat.disabled = true;
        }
    }

    function validatePasswords() {
        var password = document.getElementById("password").value;
        var passwordRepeat = document.getElementById("password-repeat").value;

        if (password !== passwordRepeat) {
            alert("Hesla se neshodují. Zadejte prosím stejná hesla.");
            return false;
        }

        return true;
    }
</script>

</html>