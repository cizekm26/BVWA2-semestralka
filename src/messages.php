<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/060a5d6fda.js" crossorigin="anonymous"></script>
  <link href="output.css" rel="stylesheet">
  <script src="./js/script.js"></script>
  <title>Zprávy</title>
</head>

<body class="bg-white">
  <?php include './templates/header.php'; ?>
  <div class="md:mx-20 mx-auto max-w-lg mt-5 sm:max-w-xl lg:max-w-full lg:px-5 flex flex-col">
    <div class="px-4 sm:px-0 flex items-stretch justify-between flex-wrap">
      <h1 class="text-3xl font-semibold">Zprávy</h1>
      <a href="new-message.php"
        class="rounded-lg shadow-lg text-sm text-white bg-blue-500 px-2 py-3 uppercase font-semibold">Napsat zprávu</a>
    </div>
    <table class="bg-gray-100 rounded border-separate mt-5 w-full border shadow text-left">
      <thead>
        <tr class="bg-blue-500 text-white">
          <th class="rounded-tl p-2">Datum</th>
          <th class="p-2">Odesílatel</th>
          <th class="p-2">Text</th>
          <th class="rounded-tr p-2"></th>
        </tr>
      </thead>
      <tbody>
      <tr class="cursor-pointer hover:bg-gray-200">
          <td class="p-2"><a class="block" href="message.php">14. 11. 2023</a></td>
          <td class="p-2"><a class="block" href="message.php">Jan Novotný</a></td>
          <td class="p-2"><a class="block" href="message.php">Lorem ipsum dolor sit amet consectetur</a></td>
          <form onsubmit="return confirmDelete()">
          <td class="p-2 text-center"><button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded" title="Smazat zprávu"><i class="fa-solid fa-trash fa-sm"
            alt="Smazat profil"></i></button></td>
          </form>
        </tr>
        <tr class="cursor-pointer font-bold hover:bg-gray-200">
          <td class="p-2"><a class="block" href="message.php">14. 11. 2023</a></td>
          <td class="p-2"><a class="block" href="message.php">Jan Novák</a></td>
          <td class="p-2"><a class="block" href="message.php">Lorem ipsum dolor sit amet consectetur</a></td>
          <form onsubmit="return confirmDelete()">
          <td class="p-2 text-center"><button type="submit" class="bg-blue-500 text-white px-3 py-2 rounded" title="Smazat zprávu"><i class="fa-solid fa-trash fa-sm"
            alt="Smazat profil"></i></button></td>
          </form>
        </tr>
      </tbody>
    </table>
  </div>
</body>
<script>
    function confirmDelete() {
        return confirm("Opravdu chcete tento záznam smazat?");
    }
</script>
</html>