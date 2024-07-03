import * as basicLightbox from 'basiclightbox';
import axios from 'axios';

document.addEventListener('submit', function (e) {
    if (e.target.classList.contains('formCallMeBack')) {
        e.preventDefault();

        const formData = new FormData(e.target);

        const nameEl = e.target.elements.name;
        const phoneEl = e.target.elements.phone;

        if(nameEl.value.length === 0) {
            nameEl.closest('.form__group').classList.add('is--error');
            nameEl.closest('.form__group').querySelector('.form__error').innerHTML = 'The name field is required.';
        } else {
            nameEl.closest('.form__group').classList.remove('is--error');
            nameEl.closest('.form__group').querySelector('.form__error').innerHTML = '';
        }

        if(phoneEl.value.length === 0 || !validatePhoneEmail(phoneEl.value)) {
            phoneEl.closest('.form__group').classList.add('is--error');

            if (phoneEl.value.length === 0) {
                phoneEl.closest('.form__group').querySelector('.form__error').innerHTML = 'The phone field is required.';
            } else {
                phoneEl.closest('.form__group').querySelector('.form__error').innerHTML = 'The phone or email field is invalid.';
            }
        } else {
            phoneEl.closest('.form__group').classList.remove('is--error');
            phoneEl.closest('.form__group').querySelector('.form__error').innerHTML = '';
        }

        if (!formData.get('phone') || !formData.get('name') || !validatePhoneEmail(phoneEl.value)) {
            return;
        } else {
            phoneEl.closest('.form__group').classList.remove('is--error');
            nameEl.closest('.form__group').classList.remove('is--error');
        }

        axios.post('/api/call_me_back', formData)
            .then(function (response) {
                e.target.reset();

                if (response.data.status === 'success') {
                    const instanceModalForm = basicLightbox.create(`
                        <div class="modal">
                            <h3 class="modal__title">${response.data.title}</h3>
                            <div class="modal__content">${response.data.message}</div>
                        </div>
                    `).show();
                }
            })
            .catch(function (error) {
                alert('Помилка відправки форми');
            });
    }
});

function validatePhoneEmail(value) {
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const phonePattern = /^\+?[0-9\s\-()]{10,}$/;

    if (emailPattern.test(value) || phonePattern.test(value)) {
        return true;
    } else {
        return false;
    }
}