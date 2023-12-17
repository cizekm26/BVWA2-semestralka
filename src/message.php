<?php
session_start();
require 'db/db_connect.php';

$connection = databaseConnection();

if (!isset($_SESSION['logged_user'])) {
  header('Location: index.php');
  exit();
}

// načtení zprávy
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $messageId = $_GET['id'];
  $sql = "SELECT zpravy.id, zpravy.predmet, zpravy.obsah, zamestnanci.login, zamestnanci.jmeno, zamestnanci.prijmeni, DATE_FORMAT(zpravy.cas_odeslani, '%d. %m. %Y %H:%i') as cas_odeslani FROM zpravy INNER JOIN zamestnanci ON zamestnanci.id = zpravy.odesilatel_id WHERE zpravy.id =" . $messageId;
  $result = $connection->query($sql);
  if ($result && $result->num_rows > 0) {
    $message = $result->fetch_assoc();
    // označení přečtené zprávy, pokud uživatel neprohlíží svou odeslanou zprávu
    $stmt = $connection->prepare("UPDATE zpravy_zamestnancu SET zobrazena = ? WHERE id_zprava = ?");
    $read = 1;
    $stmt->bind_param('ii', $read, $messageId);
    $stmt->execute();
  } else {
    echo "Zpráva nebyla nalezena";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../dist/output.css" rel="stylesheet">
  <script src="./js/script.js"></script>
  <title>Zpráva</title>
</head>

<body class="bg-white">
  <?php include './templates/header.php'; ?>
  <div class="md:mx-20 mx-auto max-w-lg mt-5 sm:max-w-xl lg:max-w-full lg:px-5 flex flex-col">
    <div class="px-4 sm:px-0 flex items-stretch justify-between flex-wrap">
      <h1 class="text-3xl font-extrabold">Zpráva</h1>
      <div>
        <a href="new-message.php?login=<?php echo $message['login']; ?>" class="w-28 rounded-lg shadow-lg text-sm text-white bg-blue-500 px-2 py-3 uppercase font-semibold">Odpovědět</a>
        <a href="messages.php" class="w-28 rounded-lg shadow-lg text-sm text-white bg-blue-500 px-2 py-3 uppercase font-semibold">Zpět</a>
      </div>
    </div>
    <div class="mt-5 bg-gray-100 shadow-md p-5 rounded divide-y divide-gray-600">
      <div class="flex items-stretch py-2 justify-between flex-wrap">
        <div>
          <span class="font-bold">Od: </span><span><?php echo $message["jmeno"] . " " . $message["prijmeni"]; ?></span>
        </div>
        <div>
          <span class="font-bold">Odesláno: </span><span><?php echo $message["cas_odeslani"]; ?></span>
        </div>
      </div>
      <div class="py-2 text-lg">
        <?php echo $message["predmet"]; ?>
      </div>
      <div class="py-2">
        <?php echo $message["obsah"]; ?>
      </div>
      <div>
      </div>
    </div>
  </div>
</body>

</html>