/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

import './js/callMeBack';
// import './js/downloadPhotos';
import './js/select';

import SimpleLightbox from "simplelightbox";


const action = document.querySelector('#actionChangeLocale');

if(action) {
    action.addEventListener('change', function (e) {
        e.preventDefault();

        document.cookie = "app_locale=" + e.target.value + ";path=/";
        window.location.reload();
    });
}

const mobileMenuBtn = document.querySelector('.menu_button');
const mobileMenu = document.querySelector('.mobile_menu');
const body = document.querySelector('body');

if(mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', function (e) {
        e.preventDefault();
        // const menu = document.querySelector('.menu');
        // menu.classList.toggle('is-show');
        mobileMenuBtn.classList.toggle('is-active');
        mobileMenu.classList.toggle('is-show');
        body.classList.toggle('is-overflow');
    });
}

var lightbox = new SimpleLightbox('.section-portfolio_list .section__item', {

});