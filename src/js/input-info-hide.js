const input_photo = document.querySelector(".input-photo")
const output_photo = document.querySelector(".output-photo")
const input_login = document.querySelector(".input-login")
const output_login = document.querySelector(".output-login")

// Funkce pro zmizení varovné hlášky s obrázkem po kliknutí na input
input_photo.onclick = function() {
    output_photo.classList.add("hidden")
}

// To samé akorát s loginem
input_login.onclick = function() {
    output_login.classList.add("hidden")
}