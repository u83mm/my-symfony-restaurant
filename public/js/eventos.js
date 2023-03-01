"use strict"; 

/** Comprueba si el elemento "available" del formulario del CRUD de la entidad "Dish" está marcado o no */
function checkAvailable() {
    let availabeleCheck = document.getElementById("dish_available");
    if (availabeleCheck.checked) {
        availableCheck.setAttribute("value", "1");
    }
}

window.onload = function() {
    /** Define un evento "click" para el elemento "available" del formulario del CRUD de la entidad "Dish" */
	let availableCheck = document.getElementById("dish_available");
    if (availableCheck) {addEventListener("click", checkAvailable, false)};
}
