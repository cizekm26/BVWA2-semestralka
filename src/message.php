<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="output.css" rel="stylesheet">
    <script src="./js/script.js"></script>
    <title>Zpráva</title>
</head>
<body class="bg-white">
    <?php include './templates/header.php'; ?>
    <div class="md:mx-20 mx-auto max-w-lg mt-5 sm:max-w-xl lg:max-w-full lg:px-5 flex flex-col">
      <div class="px-4 sm:px-0 flex items-stretch justify-between flex-wrap">
        <h1 class="text-3xl font-semibold">Zpráva</h1>
        <div>
            <a href="new-message.php" class="w-28 rounded-lg shadow-lg text-sm text-white bg-blue-500 px-2 py-3 uppercase font-semibold">Odpovědět</a>
            <a href="messages.php" class="w-28 rounded-lg shadow-lg text-sm text-white bg-blue-500 px-2 py-3 uppercase font-semibold">Zpět</a>
        </div>
      </div>
      <div class="mt-5 bg-gray-100 shadow-md p-5 rounded divide-y divide-gray-600">
        <div class="flex items-stretch py-2 justify-between flex-wrap">
            <div>
                <span class="font-bold">Od: </span><span>Jan Novák</span>
            </div>
            <div>
              <span class="font-bold">Odesláno: </span><span>9. 12. 2023</span>
            </div>
        </div>
        <div class="py-2 text-lg">
            Předmět
        </div>
        <div class="py-2">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid culpa perspiciatis veritatis repellat corrupti hic, repudiandae doloremque aspernatur iure, minima quos ullam reiciendis, natus totam deleniti facere tempora illo ab.
        </div>
        <div>

        </div>
      </div>
    </div>
  </body>
</html>