<?php
session_start();
require "db/db_connect.php";
require 'user.php';


$connection = databaseConnection();

checkUserActivity();

if (!isset($_SESSION['logged_user'])) {
    header('Location: index.php');
    exit();
}

// pokud uživatel odpovídá na zprávu
$prijemce = "";
if (isset($_GET["login"])) {
    $prijemce = $_GET["login"];
}

if (isset($_POST["send"])) {
    $login = isset($_POST["login"]) ? $_POST["login"] : '';
    $topic = isset($_POST["topic"]) ? encryptData($_POST["topic"]) : '';;
    $message = isset($_POST["message"]) ? encryptData($_POST["message"]) : '';;
    // získání id příjemce zprávy
    $sql = "SELECT id FROM zamestnanci WHERE login = '$login' LIMIT 1";
    $result = $connection->query($sql);
    if ($result && $result->num_rows > 0) {
        // uložení zprávy
        $receiverId = $result->fetch_object()->id;
        $stmt = $connection->prepare("INSERT INTO zpravy(predmet, obsah, odesilatel_id, prijemce_id) VALUES (?,?,?,?)");
        $stmt->bind_param("ssii", $topic, $message, $_SESSION["logged_user"], $receiverId);
        $stmt->execute();
        $stmt->close();

        // uložení k přijatým zprávám
        $messageId = $connection->insert_id;
        $type = "prijata";
        $read = 0;
        $stmt = $connection->prepare("INSERT INTO zpravy_zamestnancu(typ,zobrazena,id_zamestnanec, id_zprava) VALUES (?,?,?,?)");
        $stmt->bind_param("ssii", $type, $read, $receiverId, $messageId);
        $stmt->execute();
        // uložení k odeslaným zprávám
        $type = "odeslana";
        $read = 1;
        $stmt = $connection->prepare("INSERT INTO zpravy_zamestnancu(typ,zobrazena,id_zamestnanec, id_zprava) VALUES (?,?,?,?)");
        $stmt->bind_param("ssii", $type, $read, $_SESSION["logged_user"], $messageId);
        $stmt->execute();
        $stmt->close();
        echo '<script>alert("Zpráva byla odeslána")</script>';
    } else {
        echo '<script>alert("Zadaný příjemce nebyl nenalezen")</script>';
    }
}
$connection->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../dist/output.css" rel="stylesheet">
    <script src="./js/script.js"></script>
    <title>Napsat zprávu</title>
</head>

<body class="bg-white">
    <?php include './templates/header.php'; ?>
    <div class="md:mx-20 mx-auto max-w-lg mt-5 sm:max-w-xl lg:max-w-full lg:px-5 flex items-center flex-col">
        <div class="px-4 sm:px-0 flex items-stretch justify-between flex-wrap">
            <h1 class="text-3xl font-extrabold">Nová zpráva</h1>
        </div>
        <form action="new-message.php" method="post" class="bg-gray-100 mt-5 w-full max-w-lg shadow-md p-5 rounded mb-5">
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block font-bold mb-1 md:mb-0 pr-4" for="for">
                        Komu (login)
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="bg-white border-2 border-gray-200 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500" name="login" id="for" type="text" value="<?php echo $prijemce ?>" required />
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block font-bold mb-1 md:mb-0 pr-4" for="topic">
                        Předmět
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input class="bg-white border-2 border-gray-200 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500" name="topic" id="topic" type="text" minlength="1" required />
                </div>
            </div>
            <div>
                <textarea name="message" id="message" rows="6" class="block p-2.5 w-full rounded border-2 border-gray-200 focus:outline-none focus:border-blue-500" placeholder="Napište text zprávy..." required></textarea>
            </div>
            <div class="mt-5 px-4 sm:px-0 flex flex-end items-stretch justify-between flex-wrap">
                <a href="messages.php" class="w-1/5 text-center rounded-lg shadow-lg text-sm text-white bg-blue-500 px-2 py-3 uppercase font-semibold">Zpět</a>
                <input type="submit" name="send" class="w-1/5 text-center rounded-lg shadow-lg text-sm text-white bg-blue-500 w-50 uppercase font-semibold" />
            </div>
    </div>
    </form>
    </div>
    </div>
</body>

</html>