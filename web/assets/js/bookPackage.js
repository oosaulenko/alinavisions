import * as basicLightbox from 'basiclightbox';
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

document.addEventListener('click', (e) => {
    if (e.target.classList.contains('actionBookPackage')) {
        e.preventDefault();

        const modalBookPackage = document.querySelector('.templateModalBookPackage');
        basicLightbox.create(modalBookPackage).show();
    }
});

document.addEventListener('submit', (e) => {
    if (e.target.classList.contains('formBookPackage')) {
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

            })
            .catch(function (error) {
                console.log(error);
            });

    }
});