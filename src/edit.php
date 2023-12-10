<?php
include 'db/db_connect.php';

//ziskani dat uzivatele
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $sql = "SELECT * FROM zamestnanci WHERE id = $userId";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {

        $userData = $result->fetch_assoc();
    } else {
        echo "Uživatel nenalezen";
    }
} else {
    echo "Neznámé ID uživatele";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="output.css" rel="stylesheet">
    <script src="./js/script.js"></script>
    <title>Upravit profil</title>
</head>

<body class="bg-white">
    <?php include './templates/header.php'; ?>
    <div class="md:mx-20 mx-auto max-w-lg mt-5 sm:max-w-xl lg:max-w-full lg:px-5 flex items-center flex-col">
        <div class="px-4 sm:px-0">
            <h1 class="text-3xl font-semibold">Upravit profil</h1>
        </div>
        <form method="post" class="bg-gray-100 mt-5 w-full max-w-lg shadow-md p-5 rounded mb-5"
            onsubmit="return validatePasswords();">
            <fieldset>
                <legend class="text-xl font-bold mb-4 border-b-2 border-blue-500">Základní údaje</legend>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="name">
                            Jméno
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            name="jmeno" id="name" type="text" required autocomplete="name"
                            value="<?php echo "{$userData['jmeno']}"; ?>" />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="last-name">
                            Příjmení
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="last-name" name="prijmeni" type="text" required
                            value="<?php echo "{$userData['prijmeni']}"; ?>" />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="gender" required>
                            Pohlaví
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <select
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="gender" name="pohlavi" required>
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
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="email" type="email" name="email" required value="<?php echo "{$userData['email']}"; ?>">
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
                            id="photo" type="file" />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="login">
                            Login
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="login" type="text" name="login" required
                            value="<?php echo "{$userData['login']}"; ?>" />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="role">
                            Role
                        </label>
                    </div>
                    <input type="hidden" name="role" value="<?php echo "{$userData['role']}"; ?>">
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="role" type="text" name="role_display" disabled
                            value="<?php echo "{$userData['role']}"; ?>" />
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend class="text-xl font-bold mb-4 border-b-2 border-blue-500 ">Změna hesla</legend>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="password">
                            Nové heslo
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="password" type="password" required minlength="8" />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="password-repeat">
                            Heslo znovu
                        </label>
                    </div>
                    <div class="md:w-2/3">
                        <input
                            class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                            id="password-repeat" type="password" name="heslo" required minlength="8" />
                    </div>
                </div>
            </fieldset>
            <div class="flex items-center mb-6">
                <button
                    class="w-1/2 mr-5 rounded-lg shadow-lg text-sm text-white bg-blue-500 px-4 py-3 uppercase font-semibold">
                    Uložit
                </button>
        </form>
        <form method="post" style="width: 50%;"
            class="rounded-lg shadow-lg text-sm bg-red-500 text-white px-4 py-3 uppercase font-semibold">
            <button name="delete_profile" style="width: 100%;" type="submit">
                Smazat profil
            </button>
        </form>


    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST["delete_profile"])) {
            //odebirani uzivatele
            $userId = $_GET['id'];

        
            $sql = "DELETE FROM zamestnanci WHERE id = $userId";

            if ($conn->query($sql) === TRUE) {
                echo '<meta http-equiv="refresh" content="0;url=employee-list.php">';
            } else {
                echo "Chyba při odebírání záznamu " . $conn->error;
            }
        } else {
           //ziskani dat z inputu
            $name = $_POST['jmeno'];
            $lastName = $_POST['prijmeni'];
            $email = $_POST['email'];
            $gender = $_POST['pohlavi'];
            $password = $_POST['heslo'];
            $login = $_POST['login'];
            $role = $_POST['role'];

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            //vlozeni dat do databaze
            $sql = "UPDATE zamestnanci 
                SET jmeno = '$name', prijmeni = '$lastName', pohlavi = '$gender', email = '$email', login = '$login', heslo = '$hashedPassword'
                WHERE id = $userId";

            if ($conn->query($sql) === TRUE) {
                echo "Uživatelská data byla úspěšně aktualizována.";
            } else {
                echo "Chyba při aktualizaci uživatelských dat: " . $conn->error;
            }
        }
    }
    $conn->close();
    ?>

    </div>
</body>

<script>
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