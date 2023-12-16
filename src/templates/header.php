<header>
        <nav class="flex items-stretch min-h-18 p-5 justify-between flex-wrap bg-blue-500">

            <div class="flex items-center flex-shrink-0 text-white mr-6">
                <a class="font-bold text-white text-2xl cursor-pointer" href="profile.php">Profil zaměstnance</a>
            </div>
            <div class="w-full block flex-end lg:flex lg:items-center lg:w-auto">
              <div>
                <a class="text-white hover:text-gray-200 px-4 py-2 hover:bg-blue-600 cursor-pointer font-bold" href="employee-list.php">Seznam zaměstnanců</a>
                <a class="text-white hover:text-gray-200 px-4 py-2 hover:bg-blue-600 cursor-pointer font-bold" href="messages.php">Zprávy</a>
              </div>
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
                    <img class="dropButton inline h-8 rounded-full" src="../public/imgs/profile.jpg">
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
