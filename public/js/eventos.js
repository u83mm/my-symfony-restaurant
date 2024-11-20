"use strict"; 

/** Comprueba si el elemento "available" del formulario del CRUD de la entidad "Dish" está marcado o no */
function checkAvailable() {
    let availabeleCheck = document.getElementById("dish_available");
    if (availabeleCheck.checked) {
        availableCheck.setAttribute("value", "1");
    }
}

window.addEventListener('DOMContentLoaded', () => {
    /** Define un evento "click" para el elemento "available" del formulario del CRUD de la entidad "Dish" */
	let availableCheck = document.getElementById("dish_available");
    if (availableCheck) {addEventListener("click", checkAvailable, false)};

    /* Selects all elements with the class name 'show_password'
	and adds an event listener to them. It then checks if there are any elements found
	with that class using `if(showPasswordChars.length > 0)`. */
	let showPasswordChars = document.querySelectorAll('.show_password');

	if(showPasswordChars.length > 0) {
		showPasswordChars.forEach(showPasswordChar => {
			showPasswordChar.addEventListener('click', () => {				
				let input = showPasswordChar.parentNode.previousElementSibling.querySelector('input');
				if(input.type == 'password') {
					input.type = 'text';
					showPasswordChar.src = '/images/eye_closed.svg';
				} else {
					input.type = 'password';
					showPasswordChar.src = '/images/eye.svg';
				}
			});
		});
	}
});
