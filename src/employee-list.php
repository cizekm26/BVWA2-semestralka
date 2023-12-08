<?php
$data = array(
    array('id' => '1', 'firstName' => 'Jan', 'lastName' => 'Novak', 'email' => 'jn@email.cz', 'gender' => 'muž', 'login' => 'jn123', 'role' => 'admin'),
    array('id' => '2', 'firstName' => 'Jana', 'lastName' => 'Novakova', 'email' => 'jnovakova@email.cz', 'gender' => 'žena', 'login' => 'jnovakova123', 'role' => 'user'),
    array('id' => '3', 'firstName' => 'Josef', 'lastName' => 'Novotny', 'email' => 'novotny@email.cz', 'gender' => 'muž', 'login' => 'login123', 'role' => 'user')
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Seznam zaměstnanců</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://kit.fontawesome.com/060a5d6fda.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>

</head>

<body class="m-0">
    <h2>Zaměstnanci</h2>
    <form class="row g-3 mb-3">
        <div class="col-md-5">
            <label for="columns">Vyhledat podle</label>
            <div class="row g-1">
                <div class="col-md-6">
                    <select class="form-select" name="columns" id="columns">
                        <option value="0">ID</option>
                        <option value="1">Jméno</option>
                        <option value="2">Příjmení</option>
                        <option value="3">Email</option>
                        <option value="5" selected>Login</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input id="key" class="form-control" type="text" placeholder="Vyhledat" />
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <label for="gender">Pohlaví</label>
            <select id="gender" class="form-select">
                <option value="0">-</option>
                <option value="muž">muž</option>
                <option value="žena">žena</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="role">Role</label>
            <select id="role" class="form-select">
                <option value="0">-</option>
                <option value="user">user</option>
                <option value="admin">admin</option>
            </select>
        </div>
        <div class="row-sm">
            <button type="button" class="btn btn-primary" onclick="filterTable()">Filtrovat</button>
            <button type="button" class="btn btn-secondary" onclick="removeFilter()">Zrušit filtr</button>
        </div>
    </form>
    <table id="employees-table" class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th scope="col" onclick="sortTable(0)">ID</th>
                <th scope="col" onclick="sortTable(1)">Jméno</th>
                <th scope="col" onclick="sortTable(2)">Přijmění</th>
                <th scope="col" onclick="sortTable(3)">Email</th>
                <th scope="col" onclick="sortTable(4)">Pohlaví</th>
                <th scope="col" onclick="sortTable(5)">Login</th>
                <th scope="col" onclick="sortTable(6)">Role</th>
                <th scope="col">Akce</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data as $employee) {
                echo "<tr>";
                foreach ($employee as $key => $value) {
                    echo "<td>$value</td>";
                }
                echo '<td scope="row">
        <button type="button" class="btn btn-primary" title="Zobrazit profil"><i class="fa-solid fa-eye fa-xs"
            alt="Zobrazit profil"></i></button>
        <button type="button" class="btn btn-success" title="Upravit profil"><i
            class="fa-solid fa-pen-to-square fa-xs" alt="Upravit profil"></i></button>
        <button type="button" class="btn btn-danger" title="Smazat profil"><i class="fa-solid fa-trash fa-xs"
            alt="Smazat profil"></i></button>
      </td></tr>';
                echo "</tr>";
            }
            ?>

        </tbody>
    </table>
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
                current = rows[i].getElementsByTagName("td")[column];
                next = rows[i + 1].getElementsByTagName("td")[column];
                if (current.innerHTML.toLowerCase() > next.innerHTML.toLowerCase()) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    break;
                }
            }
        }
    }
</script>

</html>