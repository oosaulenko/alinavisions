import {_CARD, _FIELD_MULTI_MEDIA} from "../../variables";
import {handlerOpenModalLibrary} from "../../module/modal-library/modal";
import * as basicLightbox from 'basiclightbox';
import {modalCategoryAdd} from "../../template/modal-category-add";
import {cardCategoryMedia} from "../../template/card-category-media";
import Sortable from 'sortablejs';

let modal;
let field;

var elCategories = document.querySelector('.lm-gallery__categories');
var sortableCategories = Sortable.create(elCategories, {
    filter: '.is--not_drag',
});

var elMediaItems = document.querySelector('.lm-gallery__items');
var sortableMediaItems = Sortable.create(elMediaItems, {
    filter: '.is--not_drag',
});

document.addEventListener('click', (event) => {
    const target = event.target;
    const btnRemoveCard = target.closest('.' + _CARD.remove);
    const elCard = target.closest('.' + _CARD.card);
    const elList = target.closest('.' + _FIELD_MULTI_MEDIA.list);
    const btnDeleteSelected = target.closest('.' + _FIELD_MULTI_MEDIA.actions.delete);
    const btnCancel = target.closest('.' + _FIELD_MULTI_MEDIA.actions.cancel);
    const btnAdd = target.closest('.' + _FIELD_MULTI_MEDIA.actions.add);
    const typeGallery = elList?.getAttribute('data-type');
    const actionModalShowAddCategory = target.closest('.lm-gallery__action--add_category');
    const elCardCategory = target.closest('.lm-card-category_media');
    const elCardCategoryRemove = target.closest('.lm-card-category_media__remove');

    if(!elList) {
        return;
    }

    if(actionModalShowAddCategory) {
        event.preventDefault();
        event.stopPropagation();

        field = elList;

        modal = basicLightbox.create(modalCategoryAdd());
        modal.show();
    }

    if(elCardCategoryRemove) {
        event.preventDefault();
        event.stopPropagation();

        const cards = elList.querySelectorAll('.' + _CARD.card);
        cards.forEach((card) => {
            if(
                card.getAttribute('data-category') === elCardCategory.getAttribute('data-name') ||
                card.getAttribute('data-category') === 'none'
            ) {
                const mediaId = card.querySelector('.lm-card-media__checkbox').value;
                card.querySelector('.lm-card-media__checkbox_category').value = 'none_' + mediaId;
                card.setAttribute('data-category', 'none');
                card.classList.remove('is-hidden');
            }
        });

        elList.querySelectorAll('.lm-card-category_media').forEach((catMedia) => {
            catMedia.classList.remove('is--active');
        });

        elList.querySelector('.lm-card-category_media[data-name="none"]').classList.add('is--active');
        elCardCategory.remove();
        console.log(elCardCategoryRemove);
    }

    if(elCardCategory && !elCardCategoryRemove) {
        const elsCategories = elList.querySelectorAll('.lm-card-category_media');

        elsCategories.forEach((elCategory) => {
            elCategory.classList.remove('is--active');
            elCategory.getAttribute('data-name');
        });

        const cards = elList.querySelectorAll('.' + _CARD.card);
        cards.forEach((card) => {
            if(card.getAttribute('data-category') === elCardCategory.getAttribute('data-name')) {
                card.classList.remove('is-hidden');
            } else {
                card.classList.add('is-hidden');
            }
        });

        console.log(elCardCategory.getAttribute('data-name'));
        elCardCategory.classList.add('is--active');
    }

    if(btnRemoveCard || elCard || btnDeleteSelected || btnCancel || btnAdd) {
        event.preventDefault();
        event.stopPropagation();
    }

    /**
     * Remove card from gallery
     */
    if(btnRemoveCard && elCard) {
        elCard.remove();
        handleMultipleDelete(elList);
    }

    /**
     * Select card from gallery
     */
    if(elCard && !btnRemoveCard) {
        if(!elCard.closest('.' + _FIELD_MULTI_MEDIA.list + '[data-type="field"]')) {
            return;
        }

        const checkbox = elCard.querySelector('.' + _CARD.checkbox);
        if(checkbox) {
            checkbox.checked = !checkbox.checked;
            handleMultipleDelete(elList);
        }
    }

    /**
     * Delete selected cards
     */
    if(btnDeleteSelected) {
        const cards = elList.querySelectorAll('.' + _CARD.card);
        cards.forEach((card) => {
            const checkbox = card.querySelector('.' + _CARD.checkbox);

            if(!checkbox.checked) {
                card.remove();
            }
        });

        handleMultipleDelete(elList);
    }

    /**
     * Cancel delete selected cards
     */
    if(btnCancel) {
        const checkboxes = elList.querySelectorAll('.' + _CARD.checkbox);
        checkboxes.forEach((checkbox) => {
            checkbox.checked = true;
        });

        handleMultipleDelete(elList);
    }

    /**
     * Open modal library
     */
    if(btnAdd) {
        handlerOpenModalLibrary(elList, getCheckedCards(elList));
    }
});

document.addEventListener('click', (event) => {
    const target = event.target;
    const actionAddCategory = target.closest('.lm-action--category_add');

    if(actionAddCategory) {
        event.preventDefault();
        event.stopPropagation();

        const elInput = document.querySelector('.lm-folder__add_input');
        const categoryName = elInput.value.trim();

        if(categoryName) {
            const gCategoriesList = field.querySelector('.lm-gallery__categories');
            gCategoriesList.insertAdjacentHTML('beforeend', cardCategoryMedia(categoryName));

            const elChoice = field.querySelector('.lm-gallery__select_category');
            elChoice.insertAdjacentHTML('beforeend', `<option value="${categoryName}">${categoryName}</option>`);

            //////

            modal.close();
        } else {
            console.error('Category name cannot be empty');
        }
    }
});

document.addEventListener('change', (event) => {
    const target = event.target;
    const elList = target.closest('.' + _FIELD_MULTI_MEDIA.list);
    const elChoice = target.closest('.lm-gallery__select_category');

    if (elChoice) {
        const cards = elList.querySelectorAll('.' + _CARD.card);
        cards.forEach((card) => {
            const category = card.querySelector('.lm-card-media__checkbox_category');
            const checkbox = card.querySelector('.' + _CARD.checkbox);

            if(!checkbox.checked) {
                card.setAttribute('data-category', elChoice.value);
                category.value = elChoice.value + '_' + checkbox.value;
                card.classList.add('is-hidden');
                console.log(category);
                console.log(checkbox.value);
                // card.remove();
            }
        });

        const checkboxes = elList.querySelectorAll('.' + _CARD.checkbox);
        checkboxes.forEach((checkbox) => {
            checkbox.checked = true;
        });

        handleMultipleDelete(elList);

        console.log(elList);
        console.log(elChoice.value);
    }

});

function checkingUnSelectedCard(wrapper) {
    let selected = false;
    const checkboxes = wrapper.querySelectorAll('.' + _CARD.checkbox);

    checkboxes.forEach((checkbox) => {
        if(!checkbox.checked) {
            selected = true;
        }
    });

    return selected;
}

function handleMultipleDelete(wrapper) {
    if(checkingUnSelectedCard(wrapper)) {
        wrapper.classList.add('is-multiple_delete');
    } else {
        wrapper.classList.remove('is-multiple_delete');
    }
}

function getCheckedCards(wrapper) {
    let selected = [];
    const checkboxes = wrapper.querySelectorAll('.' + _CARD.checkbox);

    checkboxes.forEach((checkbox) => {
        selected.push(Number(checkbox.value));
    });

    return selected;
}