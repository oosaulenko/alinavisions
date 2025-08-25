import * as basicLightbox from 'basiclightbox';
import {modalLibrary} from '../../template/modal-library';
import {cardMedia} from "../../template/card-media";
import {_CARD, _GALLERY, _MODAL_GALLERY, _FIELD_MEDIA} from "../../variables";
import {handlerApiMediaList} from "../../handler/api/media/list";
import {handlerApiFolderList} from "../../handler/api/folder/list";
import {cardFolder} from "../../template/card-folder";

let excludeIds = [];
let field;
let modal;
let library;

export function handlerOpenModalLibrary(fieldHandler, ids = []) {
    const bodyEl = document.querySelector('body');
    excludeIds = ids;
    field = fieldHandler;

    const modalHandler = basicLightbox.create(modalLibrary(), {
        onShow: (instance) => {
            bodyEl.classList.add('is-scroll');

            const element = instance.element();
            const elModal = element.querySelector('.lm-modal');
            const elFolders = element.querySelector('.' + _MODAL_GALLERY.folders);
            const elItems = element.querySelector('.' + _MODAL_GALLERY.items);
            const elList = element.querySelector('.' + _MODAL_GALLERY.list);
            const page =  Number(elList.getAttribute('data-page'));
            const limit = Number(elList.getAttribute('data-limit'));

            library = elList;

            handlerApiFolderList().then(response => {
                elFolders.innerHTML = response.data.map((folder) => {
                    return cardFolder(folder.name);
                }).join('');
            });

            handlerApiMediaList(limit, page, ids).then((response) => {
                elItems.innerHTML = response.data.map((item) => {
                    return cardMedia(item);
                }).join('');

                elList.setAttribute('data-page', (page + 1).toString());
                elModal.classList.remove('is-loading');
            }).catch((error) => {});
        },
        onClose: (instance) => {
            bodyEl.classList.remove('is-scroll');
        }
    });

    modal = modalHandler;
    modalHandler.show();

    return modalHandler;
}

document.addEventListener('click', (event) => {
    const target = event.target;

    const elList = target.closest('.' + _MODAL_GALLERY.list);
    const actionSelect = target.closest('.' + _MODAL_GALLERY.actions.select);
    const actionLoadMore = target.closest('.' + _MODAL_GALLERY.actions.load_more);
    const actionClose = target.closest('.' + _MODAL_GALLERY.actions.close);
    const elCard = target.closest('.' + _CARD.card);

    if(!elList) {
        return;
    }

    if(actionSelect || actionLoadMore || actionClose) {
        event.preventDefault();
        event.stopPropagation();
    }

    /**
     * Choice card from library
     */
    if(elCard) {
        if(!elCard.closest('.' + _GALLERY.list + '[data-type="library"]')) {
            return;
        }

        const multiple = field.getAttribute('data-multiple');

        const checkbox = elCard.querySelector('.' + _CARD.checkbox);

        if(checkbox) {
            if(multiple && multiple == "true") {
                checkbox.checked = !checkbox.checked;
                handleMultipleSelect(elList);
            } else {
                handleSingleSelect(elList);
                checkbox.checked = !checkbox.checked;
            }
        }
    }

    /**
     * Select media from library
     */
    if(actionSelect) {
        const fieldItems = field.querySelector('.lm-gallery__items');
        const nameField = field.getAttribute('data-name-field');

        if(fieldItems && nameField) {
            if(field.querySelector('.lm-gallery__categories')) {
                field.querySelectorAll('.lm-card-category_media').forEach((catMedia) => {
                    if(catMedia.getAttribute('data-name') === 'none') {
                        catMedia.classList.add('is--active');
                    } else {
                        catMedia.classList.remove('is--active');
                    }
                });
            }

            getSelectedCards().forEach((item) => {
                const checkbox = item.querySelector('.' + _CARD.checkbox);
                checkbox.checked = true;
                checkbox.setAttribute('name', nameField);

                fieldItems.insertAdjacentElement('afterbegin', item);
            });

            if(fieldItems.querySelector('.lm-gallery__notification')) {
                fieldItems.querySelector('.lm-gallery__notification').remove();
            }
        } else {
            const preview = field.querySelector('.' + _FIELD_MEDIA.preview);
            const fieldInput = field.querySelector('.' + _FIELD_MEDIA.value);

            if(preview) {
                preview.innerHTML = getSelectedCards().map((item) => {
                    const img = item.querySelector('img');
                    if(!img || !img.getAttribute('src')) return;
                    return '<img src="' + img.getAttribute('src') + '" class="' + _FIELD_MEDIA.image + '">';
                }).join('');
                field.classList.add('is-active');
            }

            if(fieldInput) {
                fieldInput.value = getSelectedCards().map((item) => {
                    const input = item.querySelector('input');
                    if(!input || !input.value) return;
                    return input.value;
                }).join('');
                handlerUpdateCard(fieldInput);
            }
        }

        modal.close();
    }

    if(actionClose) {
        modal.close();
    }

    /**
     * Load more media from library
     */
    if(actionLoadMore) {
        const page =  Number(elList.getAttribute('data-page'));
        const limit = Number(elList.getAttribute('data-limit'));
        const itemsEl = elList.querySelector('.lm-gallery__items');
        actionLoadMore.classList.add('is-loading');

        handlerApiMediaList(limit, page, excludeIds).then((response) => {
            itemsEl.insertAdjacentHTML('beforeend',
                response.data.map((item) => {
                    return cardMedia(item);
                }).join(''));

            if(response.data.length < limit) {
                actionLoadMore.style.display = 'none';
            }

            elList.setAttribute('data-page', (page + 1).toString());
            actionLoadMore.classList.remove('is-loading');
        }).catch((error) => {});
    }
});

function getSelectedCards() {
    let selected = [];
    const checkboxes = library.querySelectorAll('.' + _CARD.checkbox + ':checked');

    checkboxes.forEach((checkbox) => {
        const card = checkbox.closest('.' + _CARD.card);
        selected.push(card);
    });

    return selected;
}

function checkingSelectedCard(wrapper) {
    let selected = false;
    const checkboxes = wrapper.querySelectorAll('.' + _CARD.checkbox);

    checkboxes.forEach((checkbox) => {
        if(checkbox.checked) {
            selected = true;
        }
    });

    return selected;
}

function handleMultipleSelect(wrapper) {
    if(checkingSelectedCard(wrapper)) {
        wrapper.classList.add('is-multiple_select');
    } else {
        wrapper.classList.remove('is-multiple_select');
    }
}

function handleSingleSelect(wrapper) {
    const list = wrapper.querySelectorAll('.' + _CARD.card);

    list.forEach((card) => {
        const checkbox = card.querySelector('.' + _CARD.checkbox);
        checkbox.checked = false;
    });

    wrapper.classList.add('is-multiple_select');
}

function handlerUpdateCard(input) {
    setTimeout(() => {
        const card = input.closest('.card');

        if(!card) {
            return;
        }

        const divForm = card.parentElement;
        const divDivForm = divForm.parentElement;

        if(divDivForm) {
            divDivForm.dispatchEvent(new Event('change'));
        }
    }, 300);
}