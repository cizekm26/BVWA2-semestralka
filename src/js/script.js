function myFunction() {
    var dropdown = document.getElementById("dropdown");
    if(dropdown.classList.contains('hidden'))
      dropdown.classList.remove("hidden");
    else
      dropdown.classList.add('hidden');
  }
  
  window.onclick = function(event) {
    if (!event.target.matches('.dropButton')) {
      var dropdown = document.getElementById("dropdown");
      if (!dropdown.classList.contains('hidden')) {
        dropdown.classList.add('hidden');
        }
      }
    }