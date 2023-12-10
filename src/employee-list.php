<?php
include 'db/db_connect.php';

$data = array();

$sql = "SELECT id, jmeno, prijmeni, email, pohlavi, login, role FROM zamestnanci";
$result = $conn->query($sql);


if ($result->num_rows > 0) {

    //vkladani dat pro kazdy radek tabulky v databazi
    while ($row = $result->fetch_assoc()) {

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
    <link href="output.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/060a5d6fda.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>

</head>

<body class="bg-white">
    <?php include './templates/header.php'; ?>
    <div class="md:mx-20 mx-auto max-w-lg mt-5 sm:max-w-xl lg:max-w-full lg:px-5 flex flex-col">
        <div class="px-4 sm:px-0">
            <h1 class="text-3xl font-semibold">Zaměstnanci</h1>
        </div>
        <details>
            <summary class="p-2 text-xl font-semibold">Filtr</summary>
        <form class="w-full max-w-lg p-5 mb-5">
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
                <div class="w-1/3">
                    <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="gender">Pohlaví</label>
                </div>
                <div class="w-2/3">
                    <select id="gender" class="bg-white border-2 border-grey-900 rounded w-full py-2 px-4 focus:outline-none focus:border-blue-500">
                        <option value="0">-</option>
                        <option value="muž">muž</option>
                        <option value="žena">žena</option>
                    </select>
                </div>
            </div>
            <div class="md:flex md:items-center mb-6">
                <div class="w-1/3">
                    <label class="block font-bold md:text-right mb-1 md:mb-0 pr-4" for="role">Role</label>
                </div>
                <div class="w-2/3">
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
        <hr>
        <table id="employees-table" class="bg-gray-100 rounded border-separate mt-5 w-full border shadow text-left">
            <thead>
                <tr class="bg-blue-500 text-white cursor-pointer">
                    <th class="rounded-tl p-1" onclick="sortTable(0)">ID</th>
                    <th class="p-1" onclick="sortTable(1)">Jméno</th>
                    <th class="p-1" onclick="sortTable(2)">Přijmění</th>
                    <th class="p-1" onclick="sortTable(3)">Email</th>
                    <th class="p-1" onclick="sortTable(4)">Pohlaví</th>
                    <th class="p-1" onclick="sortTable(5)">Login</th>
                    <th class="p-1" onclick="sortTable(6)">Role</th>
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

                        echo '<td class="p-1">
                    
            <form class="divide-x-2" method="post" onsubmit="return confirmDelete()">

            <a href="profile.php?id=' . $employee['id'] . '" class="bg-blue-500 text-white px-3 py-2 rounded" title="Zobrazit profil">
            <i class="fa-solid fa-eye fa-xs" alt="Zobrazit profil"></i></button>
            </a>

            <a href="edit.php?id=' . $employee['id'] . '" class="bg-green-500 text-white px-3 py-2 rounded" title="Upravit profil">
            <i class="fa-solid fa-pen-to-square fa-xs" alt="Upravit profil"></i>
            </a>
        

            <input type="hidden" name="employee_id" value="' . $employee['id'] . '">
            
            <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded" title="Smazat profil" name="delete_profile">
                <i class="fa-solid fa-trash fa-xs" alt="Smazat profil"></i></button>
        
            </form>
                    
        
      </td></tr>';
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

                        if ($conn->query($sql) === TRUE) {

                            echo '<script>setTimeout(function(){ window.location.href = window.location.href; }, 10);</script>';
                        } else {
                            echo "Chyba při odebírání záznamu " . $conn->error;
                            echo "<br><br>";
                        }
                    }
                }

                $conn->close();
                ?>

            </tbody>
        </table>
    </div>
</body>

<script>
    const roleColumnId = 6;
    const genderColumnId = 4;

    function filterTable() {
        var textInput = document.getElementById("key");
        var genderSelect = document.getElementById("gender");
        var roleSelect = document.getElementById("role");
        var columnSelect = document.getElementById("columns");
        // id sloupce, který bude filtrován (ID, jméno, příjmení, email nebo login)
        var columnId = columnSelect.value;

        // hledané hodnoty
        var text = textInput.value.toLowerCase();
        var gender = genderSelect.value;
        var role = roleSelect.value;

        var table = document.getElementById("employees-table");
        // všechny řádky tabulky
        var rows = table.getElementsByTagName("tr");

        var searchedValues = [text, gender, role];
        for (i = 1; i < rows.length; i++) {
            // všechny buňky v řádku
            var row = rows[i].getElementsByTagName("td");
            textValue = getCellValue(row, columnId);
            genderValue = getCellValue(row, genderColumnId);
            roleValue = getCellValue(row, roleColumnId);

            if (valuesAreEqual([textValue, genderValue, roleValue], searchedValues))
                rows[i].style.display = "";
            else
                rows[i].style.display = "none";
        }
    }

    function getCellValue(row, columnId) {
        var td = row[columnId];
        if (td)
            return td.text || td.innerText;
        else
            return "";
    }

    //hodnoty v řádku jsou shodné s těmi ve filtru
    function valuesAreEqual(rowValues, searchedValues) {
        if (rowValues[0].toLowerCase().indexOf(searchedValues[0]) < 0)
            return false;
        if (searchedValues[1] != 0) {
            if (rowValues[1].indexOf(searchedValues[1]) < 0)
                return false;
        }
        if (searchedValues[2] != 0) {
            if (rowValues[2].indexOf(searchedValues[2]) < 0)
                return false;
        }
        return true;
    }

    function removeFilter() {
        var textInput = document.getElementById("key");
        var genderSelect = document.getElementById("gender");
        var roleSelect = document.getElementById("role");

        textInput.value = "";
        genderSelect.selectedIndex = 0;
        roleSelect.selectedIndex = 0;

        var table = document.getElementById("employees-table");
        var rows = table.getElementsByTagName("tr");

        for (i = 1; i < rows.length; i++) {
            var row = rows[i].getElementsByTagName("td");
            rows[i].style.display = "";
        }
    }

    function sortTable(column) {
        var table, rows, i, current, next, switching;
        table = document.getElementById("employees-table");
        switching = true;
        while (switching) {
            switching = false;
            rows = table.rows;
            for (i = 1; i < rows.length - 1; i++) {
                if(column == 0){
                    current = parseInt(rows[i].getElementsByTagName("td")[column].innerHTML);
                    next = parseInt(rows[i + 1].getElementsByTagName("td")[column].innerHTML);
                }else{
                    current = rows[i].getElementsByTagName("td")[column].innerHTML.toLowerCase();
                    next = rows[i + 1].getElementsByTagName("td")[column].innerHTML.toLowerCase();
                }
                if (current > next) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    break;
                }
            }
        }
    }

    function confirmDelete() {
        return confirm("Opravdu chcete tento záznam smazat?");
    }
</script>

</html>