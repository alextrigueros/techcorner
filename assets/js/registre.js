//Funció per mostrar/ocultar la contrasenya
function togglePassword(inputId, button) {
    let input = document.querySelector("#" + inputId);

    if (input.type === "password") {
        input.type = "text";
        button.textContent = "🔓";
    }
    else {
        input.type = "password";
        button.textContent = "🔒";
    }
}