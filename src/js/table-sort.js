const roleColumnId = 6;
const genderColumnId = 4;

// filtrování tabulky
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

    // pokud jsou hodnoty shodoné tak se řádek zobrazí
    if (valuesAreEqual([textValue, genderValue, roleValue], searchedValues))
      rows[i].style.display = "";
    else rows[i].style.display = "none";
  }
}

// hodnota v buňce tabulky
function getCellValue(row, columnId) {
  var td = row[columnId];
  if (td) return td.text || td.innerText;
  else return "";
}

//hodnoty v řádku jsou shodné s těmi ve filtru
function valuesAreEqual(rowValues, searchedValues) {
  if (rowValues[0].toLowerCase().indexOf(searchedValues[0]) < 0) return false;
  if (searchedValues[1] != 0) {
    if (rowValues[1].indexOf(searchedValues[1]) < 0) return false;
  }
  if (searchedValues[2] != 0) {
    if (rowValues[2].indexOf(searchedValues[2]) < 0) return false;
  }
  return true;
}

// zrušení všech filtrů
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

// Seřazení tabulky podle sloupce (vzestupně)
// zdroj: https://www.w3schools.com/howto/howto_js_sort_table.asp
function sortTable(column) {
  var table, rows, i, current, next, switching;
  table = document.getElementById("employees-table");
  switching = true;
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < rows.length - 1; i++) {
      if (column == 0) {
        current = parseInt(
          rows[i].getElementsByTagName("td")[column].innerHTML
        );
        next = parseInt(
          rows[i + 1].getElementsByTagName("td")[column].innerHTML
        );
      } else {
        current = rows[i]
          .getElementsByTagName("td")
          [column].innerHTML.toLowerCase();
        next = rows[i + 1]
          .getElementsByTagName("td")
          [column].innerHTML.toLowerCase();
      }
      if (current > next) {
        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
        switching = true;
        break;
      }
    }
  }
}
