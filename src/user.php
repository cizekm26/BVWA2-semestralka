<?php
// Funkce spojené s prací s uživatelem

// Funkce pro práci správnou práci s obrázkem
function photo($connection, $login)
{
    $photo_name = $_FILES["photo"]["name"];
    //$photo_size = $_FILES["photo"]["size"];
    $photo_tmp_name = $_FILES["photo"]["tmp_name"];
    $error = $_FILES["photo"]["error"];

    if ($error === 0) {

        // Získá koncovku obrázku (.jpg, ...)
        $photo_extension = pathinfo($photo_name, PATHINFO_EXTENSION);
        // nastaví ji na malé písmena - kdyby náhodou
        $photo_extension = strtolower($photo_extension);
        // Povolené koncovky
        $allowed_extensions = ["jpg", "jpeg", "png", "gif", "bmp", "tiff"];

        // Zjištění zda ukládaný obrázek souhlasí s některou s povolených koncovek
        if (in_array($photo_extension, $allowed_extensions)) {
            // Zároveň uložení jako .jpeg soubor
            $new_photo_name = "PROFILE_IMG_$login" . "." . "jpeg";

            // Vytvoření složky pro uživatele pokud ještě neexistje
            if (!file_exists("./resources/" . $login)) {
                mkdir("./resources/" . $login, 0707, true);
            }

            // Nahrání do složky pro uživatele
            $photo_upload_path = "./resources/" . $login . "/" . $new_photo_name;
            move_uploaded_file($photo_tmp_name, $photo_upload_path);

            $resizedWidth = 800;
            resizeImage($photo_upload_path, $photo_upload_path, $resizedWidth);

            return $new_photo_name;
        } else {
            return "format";
        }

    } else {
        // uživatel si nevybral fotku
        if (!file_exists("./resources/" . $login)) {
            mkdir("./resources/" . $login, 0707, true);
        }

        $default_photo_path = "./resources/img/profile.jpg"; //cesta k výchozí fotografii
        $new_photo_name = "PROFILE_IMG_default.jpeg";
        $photo_upload_path = "./resources/" . $login . "/" . $new_photo_name;

        copy($default_photo_path, $photo_upload_path);

        return $new_photo_name;
    }
}

// Kontrola, zda nenastal nějaký problém s profilovou fotkou
function anyProblemWithPhoto($error)
{
    switch ($error) {
        case "format":
            return "Špatný formát profilového obrázku!";
            break;
        case "size":
            return "Příliš velká velikost obrázku!";
            break;
        case "error":
            return "Nastal nečekaný problém při nahrávání obrázku.";
            break;
        default:
            return false;
            break;
    }
}

// Funkce pro přidání nově registrovaného uživatele
function createUser($connection, $first_name, $last_name, $phone_number,$email, $gender, $login, $password, $photo)
{
    if (!doesThisUserExists($connection, $login)) {
        $sql = "INSERT INTO zamestnanci (jmeno, prijmeni, email,telefon, pohlavi, login, role, heslo, photo) VALUES (?, ?, ?, ?, ?,?, 'user', ?, ?)";
        $stmt = mysqli_prepare($connection, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssss", $first_name, $last_name, $email, $phone_number,$gender, $login, $password, $photo);
            mysqli_stmt_execute($stmt);
            $id = mysqli_insert_id($connection);

            return $id;
        }
    } else {
        return "login";
    }
}

// Kontrola existence uživatele s tímto loginem
function doesThisUserExists($connection, $login)
{
    $sql = "SELECT * FROM zamestnanci WHERE login = '$login'";
    $stmt = mysqli_query($connection, $sql);

    if (mysqli_num_rows($stmt) == 0) {
        return false;
    } else {
        return "Uživatel s tímto přihlašovacím jménem již existuje!";
    }
}

// (Funkce) Kontrola, zda je uživatel přihlášený (true/false)
function isLogged()
{
    return isset($_SESSION["is_logged"]) and $_SESSION["is_logged"];
}

// Funkce pro autentifikaci uživatele při přihlašování
function authenticate($connection, $login, $password)
{
    $sql = "SELECT login, heslo FROM zamestnanci WHERE login = ?";
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $login);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            // Kontrola zda se našel údaj shodující s vloženými hodnotami
            if (mysqli_num_rows($result) > 0) {
                // Vyber ten prvek
                $database_password = mysqli_fetch_assoc($result);
                // Ulož si ten prvek
                $user_database_password = $database_password['heslo'];

                // Pokud tam něco je
                if ($user_database_password) {
                    // Vrať true/false podle toho jestli se shodují
                    return password_verify($password, $user_database_password);
                }
            } else {
                echo mysqli_error($connection);
            }
        }
    } else {
        echo mysqli_error($connection);
    }
}


// ------------------------------------------------------------------------------------

// Funkce navíc, co se můžou hodit


// Funkce pro získání uživatelského ID - pro práci s jeho údaji
function getUserID($connection, $login)
{
    $sql = "SELECT id FROM zamestnanci WHERE login = ?";
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $login);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $database_id = mysqli_fetch_row($result);
            $user_database_id = $database_id[0];

            return $user_database_id;
        }
    } else {
        echo mysqli_error($connection);
    }
}

// Funkce pro získání uživatelova loginu
function getUserLogin($connection, $id)
{
    $sql = "SELECT login FROM zamestnanci WHERE id = ?";
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            $database_login = mysqli_fetch_row($result);
            $user_database_login = $database_login[0];

            return $user_database_login;
        }
    }
}

function resizeImage($sourcePath, $targetPath, $width) {
    list($originalWidth, $originalHeight) = getimagesize($sourcePath);
    $aspectRatio = $originalWidth / $originalHeight;
    $newHeight = $width / $aspectRatio;

    //odkomentovat v php.ini ;extension = gd
    $sourceImage = imagecreatefromstring(file_get_contents($sourcePath));
    $resizedImage = imagecreatetruecolor($width, $newHeight);

    //uchování průhlednosti pro gif a png obrázky
    imagealphablending($resizedImage, false);
    imagesavealpha($resizedImage, true);

    imagecopyresampled($resizedImage, $sourceImage, 0, 0, 0, 0, $width, $newHeight, $originalWidth, $originalHeight);

    //uložení resiznutého obrázku
    imagejpeg($resizedImage, $targetPath, 90);

    //uvolnění paměti
    imagedestroy($sourceImage);
    imagedestroy($resizedImage);
}


function getUserData($connection, $userId)
{
    $stmt = $connection->prepare("SELECT id, jmeno, prijmeni, login, role, photo FROM zamestnanci WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        return $userData;
    } else {
        return null;
    }
}

// vrací počet nepřečtených zpráv
function getNewMessagesCount($connection, $id)
{
    $type = 'prijata';
    $read = 0;
    $stmt = $connection->prepare("SELECT count(id) as count FROM zpravy_zamestnancu WHERE id_zamestnanec = ? AND typ = ? AND zobrazena = ?");
    $stmt->bind_param("isi", $id, $type, $read);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        return $data['count'];
    } else {
        return 0;
    }
}


// Zobrazení obrázku
// echo "<img src='" . getUserPhoto(databaseConnection(), $login) . "'";
?>