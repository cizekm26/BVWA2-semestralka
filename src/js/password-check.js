const password_first = document.querySelector(".password-first")
const password_second = document.querySelector(".password-second")
const info = document.querySelector(".info")
const submit_button = document.querySelector(".submit-button")

// Kontrola, zda se první input shoduje s tím druhým
passwordControl(password_first)

// Kontrola, zda se druhý input shoduje s tím prvním
passwordControl(password_second)

// Funkce pro kontrolu "shodnosti" hesel
function passwordControl(password) {
    password.addEventListener("input", () => { // Sleduje změny v inputu
        const password_first_value = password_first.value
        const password_second_value = password_second.value

        if (password_first_value === password_second_value) {
            info.textContent = "Hesla se shodují."
            info.classList.remove("hidden")
            info.classList.add("block")
            info.classList.remove("text-red-600")
            info.classList.add("text-green-600")

            submit_button.disabled = false
        } else {
            info.textContent = "Hesla se neshodují!"
            info.classList.add("text-red-600")
            info.classList.remove("hidden")
            info.classList.add("block")
            info.classList.remove("text-green-600")

            submit_button.disabled = true
        }

        // Kontrola, když jsou inputy prázdné, aby se nic nevypisovalo
        if (password_first_value === "" && password_second_value === "") {
            info.classList.remove("block")
            info.classList.add("hidden")
            info.textContent = ""

            submit_button.disabled = false
        }
    })
}

