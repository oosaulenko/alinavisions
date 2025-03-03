/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

import './js/callMeBack';
import './js/bookPackage';
// import './js/downloadPhotos';
import './js/select';

import * as basicLightbox from 'basiclightbox';
import SimpleLightbox from "simplelightbox";
import axios from 'axios';


function validatePhoneEmail(value) {
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const phonePattern = /^\+?[0-9\s\-()]{10,}$/;

    if (emailPattern.test(value) || phonePattern.test(value)) {
        return true;
    } else {
        return false;
    }
}

function scrollToTarget(targetId) {
    const targetElement = document.getElementById(targetId);
    if (targetElement) {
        window.scrollTo({
            top: targetElement.offsetTop,
            behavior: "smooth"
        });
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const savedAnchor = sessionStorage.getItem("scrollToAnchor");

    if (savedAnchor) {
        sessionStorage.removeItem("scrollToAnchor");
        setTimeout(() => scrollToTarget(savedAnchor), 250);
    }
});

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

document.addEventListener("click", function (e) {
    if(e.target.href) {
        if(e.target.href.includes('#')) {
            e.preventDefault();

            const [path, templateId] = e.target.href.split("#");
            console.log(templateId);
            console.log(path);

            if(document.querySelector(`.template${templateId}`)) {
                const template = document.querySelector(`.template${templateId}`);
                basicLightbox.create(template).show();
            } else {
                if(window.location.href !== path) {
                    sessionStorage.setItem("scrollToAnchor", templateId);
                    window.location.href = path;
                } else {
                    scrollToTarget(templateId);
                }


                const targetElement = document.querySelector(`#${templateId}`);
                console.log(targetElement);
            }

            // console.log(templateId);
        }
    }
});

document.addEventListener('submit', (e) => {
    if (e.target.classList.contains('formValidation')) {
        e.preventDefault();

        let validForm = true;
        const elements = e.target.elements;

        for (let i = 0; i < elements.length; i++) {
            const attributes = elements[i].attributes;
            const dataset = elements[i].dataset;

            if (attributes.required) {
                if (elements[i].value.length === 0) {
                    elements[i].closest('.form__group').classList.add('is--error');
                    if (dataset.message_required && !elements[i].nextElementSibling) {
                        elements[i].insertAdjacentHTML('afterend', `<div class="form__error">${dataset.message_required}</div>`);
                        validForm = false;
                    }
                } else {
                    elements[i].closest('.form__group').classList.remove('is--error');
                    if (elements[i].nextElementSibling) {
                        elements[i].nextElementSibling.remove();
                        if (validForm) {
                            validForm = true;
                        }
                    }
                }
            }

            if (dataset.validation) {
                if (dataset.validation === 'phone_email') {
                    if (!validatePhoneEmail(elements[i].value)) {
                        elements[i].closest('.form__group').classList.add('is--error');
                        if (dataset.message_validate && !elements[i].nextElementSibling) {
                            elements[i].insertAdjacentHTML('afterend', `<div class="form__error">${dataset.message_validate}</div>`);
                            validForm = false;
                        }
                    } else {
                        elements[i].closest('.form__group').classList.remove('is--error');
                        if (elements[i].nextElementSibling) {
                            elements[i].nextElementSibling.remove();
                            if (validForm) {
                                validForm = true;
                            }
                        }
                    }
                }
            }
        }

        if (!validForm) {
            return;
        }

        axios.post('/api/form', new FormData(e.target))
            .then(function (response) {
                e.target.reset();

                e.target.insertAdjacentHTML('beforeend', `<div class="form__message">${response.data.message}</div>`);

                setTimeout(() => {
                    e.target.querySelector('.form__message').remove();
                }, 3000);

                console.log(response.data);

            })
            .catch(function (error) {
                console.log(error);
            });

    }
});