/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../scss/app.scss';

// the bootstrap module doesn't export/return anything
import 'bootstrap';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

/*
 *
 * Gestion du bouton pour retourner en haut de la page
 *
 */
$(document).ready(function () {
    //Get the button:
    var mybutton = document.getElementById("scrollTopBtn");
    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function () { scrollFunction() };
    
    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        } else {
            mybutton.style.display = "none";
        }
    }
    
    // When the user clicks on the button, scroll to the top of the document
    $('#scrollTopBtn').on('click', function () {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    })
})


/*
 *
 * Écoute de l'événement associé à l'upload de fichier lors de l'envoi d'un message de contact
 * 
 */
$('.custom-file-input').on('change', function (e) {
    // Récupération de l'input
    var inputFile = e.currentTarget;
    // Récupération du parent <div class="custom-file"> et on cherche l'enfant qui représente le label
    $(inputFile).parent().find('.custom-file-label').html(inputFile.files[0].name);
})