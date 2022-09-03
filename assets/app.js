/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

const $ = require('jquery');

// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap');

// start the Stimulus application
import './bootstrap';

/*
 *
 * Gestion du bouton pour retourner en haut de la page
 *
 */
$(function () {
    //Get the button:
    const backToTopBtn = document.getElementById("js-back-to-top-btn");
    // When the user scrolls down 300px from the top of the document, show the button
    window.onscroll = function () { scrollFunction(); };

    function scrollFunction() {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            if (!backToTopBtn.classList.contains("btnEntrance")) {
                backToTopBtn.classList.remove("btnExit");
                backToTopBtn.classList.add("btnEntrance");
                backToTopBtn.style.display = "block";
            }
        } else {
            if (backToTopBtn.classList.contains("btnEntrance")) {
                backToTopBtn.classList.remove("btnEntrance");
                backToTopBtn.classList.add("btnExit");
                setTimeout(function () {
                    backToTopBtn.style.display = "none";
                }, 250);
            }
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    backToTopBtn.onclick = function () { smoothScrollBackToTop()};

    function smoothScrollBackToTop() {
        const targetPosition = 0;
        const startPosition = window.pageYOffset;
        const distance = targetPosition - startPosition;
        const duration = 500;
        let start = null;

        window.requestAnimationFrame(step);

        function step(timestamp) {
            if (!start) start = timestamp;
            const progress = timestamp - start;
            window.scrollTo(0, easeInOutCubic(progress, startPosition, distance, duration));
            if (progress < duration) window.requestAnimationFrame(step);
        }
    }

    function easeInOutCubic(t, b, c, d) {
        t /= d / 2;
        if (t < 1) return c / 2 * t * t * t + b;
        t -= 2;
        return c / 2 * (t * t * t + 2) + b;
    };
});

/*
 *
 * Écoute de l'événement associé à l'upload de fichier lors de l'envoi d'un message de contact
 * 
 */
$(function () {
    $('.custom-file-input').on('change', function (e) {
        // Récupération de l'input
        var inputFile = e.currentTarget;
        // Récupération du parent <div class="custom-file"> et on cherche l'enfant qui représente le label
        $(inputFile).parent().find('.custom-file-label').html(inputFile.files[0].name);
    });
});
