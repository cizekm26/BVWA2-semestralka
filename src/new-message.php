<?php
  session_start();

  if(!isset($_SESSION['logged_user'])){
    header('Location: index.php');
    exit();
}
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
        <form class="bg-gray-100 mt-5 w-full max-w-lg shadow-md p-5 rounded mb-5">
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block font-bold mb-1 md:mb-0 pr-4" for="for">
                        Komu
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input
                        class="bg-white border-2 border-gray-200 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                        id="for" type="text" required/>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="md:w-1/3">
                    <label class="block font-bold mb-1 md:mb-0 pr-4" for="topic">
                        Předmět
                    </label>
                </div>
                <div class="md:w-2/3">
                    <input
                        class="bg-white border-2 border-gray-200 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500"
                        id="topic" type="text" required/>
                </div>
            </div>
            <div>
                <textarea id="message" rows="6" class="block p-2.5 w-full rounded border-2 border-gray-200 focus:outline-none focus:border-blue-500" placeholder="Napište text zprávy..."></textarea>
            </div>
            <div class="mt-5 px-4 sm:px-0 flex flex-end items-stretch justify-between flex-wrap">
                <a href="messages.php" class="w-1/5 text-center rounded-lg shadow-lg text-sm text-white bg-blue-500 px-2 py-3 uppercase font-semibold">Zpět</a>
                <a href="messages.php" class="w-1/5 text-center rounded-lg shadow-lg text-sm text-white bg-blue-500 px-2 py-3 uppercase font-semibold">Odeslat</a>
            </div>
            </div>
        </form>
      </div>
    </div>
  </body>
</html>