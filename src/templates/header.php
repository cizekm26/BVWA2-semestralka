<?php 
require_once "db/db_connect.php";
require_once "user.php";
?>

<header>
        <nav class="flex items-stretch space-y-1 min-h-18 p-5 justify-between flex-wrap bg-blue-500">
                <a class="font-bold text-white text-2xl cursor-pointer" href="profile.php">Profil zaměstnance</a>
            <div class="block flex-end flex-wrap md:flex md:items-center md:w-auto md:mt-0 mt-5">
                <a class="text-white hover:text-gray-200 px-4 py-2 hover:bg-blue-600 cursor-pointer font-bold" href="employee-list.php">Seznam zaměstnanců</a>
                <a class="text-white hover:text-gray-200 px-4 py-2 hover:bg-blue-600 cursor-pointer font-bold" href="messages.php">Zprávy <span class="rounded-full px-2 py-1 bg-green-500"><?php if(isset($_SESSION['logged_user'])) echo getNewMessagesCount(databaseConnection(), $_SESSION['logged_user']); ?></span></a>
              
                <div class="dropdown">
                <button <?php if(isset($_SESSION['logged_user'])){ echo 'onclick="showMenu()"';}?> class="dropButton flex flex-row items-center space-x-2 w-full px-4 py-2 mt-2 bg-blue-600 hover:bg-blue-800 md:w-auto md:inline md:mt-0 md:ml-4 rounded-lg">
                <span class="dropButton text-white">
            <?php if(isset($_SESSION["user_name"]))
                    echo $_SESSION["user_name"]["jmeno"] . " " . $_SESSION["user_name"]["prijmeni"]; 
                  else{
                    echo "Nepřihlášený uživatel";
                  }
            ?>
          </span>
          <img class="dropButton inline h-8 rounded-full"  src="resources/<?php if(isset($_SESSION["user_name"])){ echo $_SESSION['user_name']['login']; ?>/<?php echo $_SESSION['user_name']['photo']; } else echo "img/profile.jpg"?>" >
                </button>
                <div id="dropdown" class="z-50 absolute hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                        <a href="profile.php" class="block px-4 py-2 hover:bg-gray-200">Zobrazit profil</a>
                        <a href="edit.php?id=<?php echo $_SESSION['logged_user']; ?>" class="block px-4 py-2 hover:bg-gray-200">Upravit profil</a>
                        <a href="logout.php" class="block px-4 py-2 hover:bg-gray-200">Odhlásit se</a>
                </div>
            </div>
            </div>
        </nav>
    </header>
