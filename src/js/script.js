// zobrazí menu po rozklinutí profilu
function showMenu() {
    var dropdown = document.getElementById("dropdown");
    if(dropdown.classList.contains('hidden'))
      dropdown.classList.remove("hidden");
    else
      dropdown.classList.add('hidden');
  }
  // menu zmizí po kliknutí vedle
  window.onclick = function(event) {
    if (!event.target.matches('.dropButton')) {
      var dropdown = document.getElementById("dropdown");
      if (!dropdown.classList.contains('hidden')) {
        dropdown.classList.add('hidden');
        }
      }
    }