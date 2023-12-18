<?php
session_start(); // Start the session

include 'db/db_connect.php';
require 'user.php';

if (!isset($_SESSION['logged_user'])) {
    header('Location: index.php');
    exit();
}

checkUserActivity();

$connection = databaseConnection();

$data = array();

$sql = "SELECT id, jmeno, prijmeni, email, telefon,pohlavi, login, role FROM zamestnanci";
$result = $connection->query($sql);


if ($result->num_rows > 0) {

    //vkladani dat pro kazdy radek tabulky v databazi
    while ($row = $result->fetch_assoc()) {
        $row['email'] = decryptData($row['email']);
        $row['telefon'] = decryptData($row['telefon']);
        $data[] = $row;
    }
} else {
    echo "0 results";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seznam zaměstnanců</title>
    <link href="../dist/output.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/060a5d6fda.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script src="js/table-sort.js"></script>
</head>

<body class="bg-white">
    <?php require './templates/header.php'; ?>
    <div class="md:mx-20 mx-auto max-w-lg mt-5 mb-5 sm:max-w-xl lg:max-w-full lg:px-5 flex flex-col">
        <div class="px-4 sm:px-0">
            <h1 class="text-3xl font-extrabold">Zaměstnanci</h1>
        </div>
        <details>
            <summary class="p-2 text-xl font-semibold">Filtr</summary>
            <form class="w-full max-w-lg p-5">
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="columns">Vyhledat podle</label>
                    </div>
                    <div class="md:w-1/3">
                        <select class="w-full bg-white border-2 border-grey-900 rounded py-2 px-4 focus:outline-none focus:border-blue-500" name="columns" id="columns">
                            <option value="0">ID</option>
                            <option value="1">Jméno</option>
                            <option value="2">Příjmení</option>
                            <option value="3">Email</option>
                            <option value="5" selected>Login</option>
                        </select>
                    </div>
                    <div class="md:w-1/3">
                        <input id="key" class="w-full bg-white border-2 border-grey-900 rounded py-2 px-4 focus:outline-none focus:border-blue-500" type="text" placeholder="Vyhledat" />
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="gender">Pohlaví</label>
                    </div>
                    <div class="md:w-2/3">
                        <select id="gender" class="w-full bg-white border-2 border-grey-900 rounded py-2 px-4 focus:outline-none focus:border-blue-500">
                            <option value="0">-</option>
                            <option value="muž">muž</option>
                            <option value="žena">žena</option>
                        </select>
                    </div>
                </div>
                <div class="md:flex md:items-center mb-6">
                    <div class="md:w-1/3">
                        <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="role">Role</label>
                    </div>
                    <div class="md:w-2/3">
                        <select id="role" class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500">
                            <option value="0">-</option>
                            <option value="user">user</option>
                            <option value="admin">admin</option>
                        </select>
                    </div>
                </div>
                <div class="mt-5 sm:px-0 flex justify-center space-x-2 flex-wrap">
                    <button type="button" class="text-sm text-center rounded-lg shadow-lg text-white bg-blue-500 px-2 py-3 uppercase font-semibold" onclick="filterTable()">Filtrovat</button>
                    <button type="button" class="text-sm text-center rounded-lg shadow-lg text-white bg-blue-500 px-2 py-3 uppercase font-semibold" onclick="removeFilter()">Zrušit filtr</button>
                </div>
            </form>
        </details>
        <div class="overflow-x-scroll">
            <table id="employees-table" class=" bg-gray-100 rounded border-separate w-full border shadow text-left">
                <thead>
                    <tr class="bg-blue-500 text-white cursor-pointer">
                        <th class="rounded-tl p-1" onclick="sortTable(0)">ID</th>
                        <th class="p-1" onclick="sortTable(1)">Jméno</th>
                        <th class="p-1" onclick="sortTable(2)">Přijmění</th>
                        <th class="p-1" onclick="sortTable(3)">Email</th>
                        <th class="p-1" onclick="sortTable(4)">Telefon</th>
                        <th class="p-1" onclick="sortTable(5)">Pohlaví</th>
                        <th class="p-1" onclick="sortTable(6)">Login</th>
                        <th class="p-1" onclick="sortTable(7)">Role</th>
                        <th class="rounded-tr p-1">Akce</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($data != null) {
                        foreach ($data as $employee) {
                            echo "<tr>";
                            foreach ($employee as $key => $value) {
                                echo "<td class='p-1'>$value</td>";
                            }

                            echo '<td scope="row" class="flex flex-row flex-wrap gap-1 p-1">';
                            echo '<a href="profile.php?id=' . $employee['id'] . '" class="bg-blue-500 text-white px-3 py-2 rounded" title="Zobrazit profil">
            <i class="fa-solid fa-eye fa-xs" alt="Zobrazit profil"></i></button>
            </a>';
                            //zobrazení tlačítek podle toho jestli uživatel je admin
                            if ($_SESSION['user_name']['role'] === 'admin') {
                                echo '<form class="flex flex-row flex-wrap gap-1" method="post" onsubmit="return confirmDelete()">            
            <a href="edit.php?id=' . $employee['id'] . '" class="bg-green-500 text-white px-3 py-2 rounded" title="Upravit profil">
            <i class="fa-solid fa-pen-to-square fa-xs" alt="Upravit profil"></i>
            </a>
        

            <input type="hidden" name="employee_id" value="' . $employee['id'] . '">
            
            <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded" title="Smazat profil" name="delete_profile">
                <i class="fa-solid fa-trash fa-xs" alt="Smazat profil"></i></button>
        
            </form>';
                            }

                            echo '</td></tr>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Nejsou dostupné žádné záznamy</td></tr>";
                    }

                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        //odebirani zaznamu
                        if (isset($_POST["delete_profile"])) {
                            $employee_id = $_POST["employee_id"];

                            $sql = "DELETE FROM zamestnanci WHERE id = $employee_id";
                            echo '<script>setTimeout(function(){ window.location.href = "employee-list.php"; }, 10);</script>';

                            if ($connection->query($sql) === TRUE) {
                                $folder_path = "./resources/" . $login;

                                if (file_exists($folder_path) && is_dir($folder_path)) {
                                    rmdir($folder_path);
                                }

                                //kontrola jestli neodbirame prihlaseneho uzivatele
                                if (isset($_SESSION['logged_user']) && $_SESSION['logged_user'] == $employee_id) {
                                    unset($_SESSION['logged_user']);
                                    session_destroy();
                                    exit();
                                }
                            } else {
                                echo "Chyba při odebírání záznamu " . $connection->error;
                                echo "<br><br>";
                            }
                        }
                    }

                    if (!isset($_SESSION['logged_user'])) {
                        header("Location: login.php");
                        exit();
                    }

                    $connection->close();
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</body>

<script>
    function confirmDelete() {
        return confirm("Opravdu chcete tento záznam smazat?");
    }
</script>

</html>