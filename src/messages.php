<?php
session_start();

include 'db/db_connect.php';

if (!isset($_SESSION['logged_user'])) {
  header('Location: index.php');
  exit();
}

$connection = databaseConnection();

$messages = array();
// načtení přijatých zpráv
$sql = "SELECT zpravy.id, zpravy.predmet, zpravy.obsah, zamestnanci.jmeno, zamestnanci.prijmeni, zpravy.zobrazena,zpravy.prijemce_id, DATE_FORMAT(zpravy.cas_odeslani, '%d. %m. %Y') as cas_odeslani FROM zpravy INNER JOIN zamestnanci ON zamestnanci.id = zpravy.odesilatel_id" . " WHERE zpravy.prijemce_id =" . $_SESSION['logged_user'] . " ORDER BY zpravy.cas_odeslani DESC";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
  }
}

// smazání zprávy
if(isset($_POST["delete"])){
  if(isset($_POST["message_id"])){
    $messageId = $_POST["message_id"];
    $stmt = $connection->prepare("DELETE FROM zpravy WHERE id = ?");
    $stmt->bind_param("i", $messageId);
    $stmt->execute();
    $stmt->close();
    header("Location: messages.php");
  }else{
    echo "Zpráva nebyla nalezena";
  }
}
$connection->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/060a5d6fda.js" crossorigin="anonymous"></script>
  <link href="../dist/output.css" rel="stylesheet">
  <script src="./js/script.js"></script>
  <title>Zprávy</title>
</head>

<body class="bg-white">
  <?php include './templates/header.php'; ?>
  <div class="md:mx-20 mx-auto max-w-lg mt-5 sm:max-w-xl lg:max-w-full lg:px-5 flex flex-col">
    <div class="px-4 sm:px-0 flex items-stretch justify-between flex-wrap">
      <h1 class="text-3xl font-extrabold">Zprávy</h1>
      <a href="new-message.php" class="rounded-lg shadow-lg text-sm text-white bg-blue-500 px-2 py-3 uppercase font-semibold">Napsat zprávu</a>
    </div>
    <table class="bg-gray-100 rounded border-collapse mt-5 w-full border shadow text-left">
      <thead>
        <tr class="bg-blue-500 text-white">
          <th class="rounded-tl p-2">Datum</th>
          <th class="p-2">Odesílatel</th>
          <th class="p-2">Text</th>
          <th class="rounded-tr p-2"></th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($messages != null && sizeof($messages)>0) {
          foreach ($messages as $message) {
            // zpráva delší než 80 znaků bude v náhledu zkrácena
            echo '<tr class="'.($message["zobrazena"] ? "" : "font-bold") .' cursor-pointer hover:bg-gray-200">
                                <td class="p-2"><a class="block" href="message.php?id=' . $message['id'] . '">' . $message["cas_odeslani"] . '</a></td>
                                <td class="p-2"><a class="block" href="message.php?id=' . $message['id'] . '">' . $message["jmeno"] . ' ' . $message["prijmeni"] . '</a></td>
                                <td class="p-2"><a class="block" href="message.php?id=' . $message['id'] . '">' . (strlen($message["obsah"] > 80) ? substr($message["obsah"], 0, 80) . "..." : $message["obsah"]) . '</a></td>
                                <form method="post" onsubmit="return confirmDelete()">
                                <input type="hidden" name="message_id" value="' . $message['id'] . '">
                                <td class="p-2 text-center"><button type="submit" name="delete" class="bg-blue-500 text-white px-3 py-2 rounded" title="Smazat zprávu"><i class="fa-solid fa-trash fa-sm"
                                  alt="Smazat profil"></i></button></td>
                                </form>
                              </tr>';
          }
        }else{
          echo "Žádné nové zprávy"; 
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
<script>
  function confirmDelete() {
    confirm("Opravdu chcete tento záznam smazat?");
  }
</script>

</html>