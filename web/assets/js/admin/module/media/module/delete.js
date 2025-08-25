import * as basicLightbox from 'basiclightbox';
import {modalDelete} from '../template/modal-delete';
import {_CARD, _MODAL_DELETE} from "../options/variables";
import {handlerApiMediaRemove} from '../handler/api/remove';

let modal;
let field;

/**
 * Open modal delete
 */
export function handlerOpenModalDelete(fieldHandler) {
    field = fieldHandler;

    modal = basicLightbox.create(modalDelete(), {
        onShow: (instance) => { },
        onClose: (instance) => { }
    });

    modal.show();
}

document.addEventListener('click', (event) => {
    const target = event.target;

    const btnCancel = target.closest('.' + _MODAL_DELETE.actions.cancel);
    const btnDelete = target.closest('.' + _MODAL_DELETE.actions.delete);

    /**
     * Close modal without delete
     */
    if(btnCancel) {
        modal.close();
    }

    /**
     * Delete media from library
     */
    if(btnDelete) {
        const input = field.querySelector('.' + _CARD.checkbox);

        if(!input) {
            return;
        }

        handlerApiMediaRemove(input.value).then(r => {
            field.remove();
            modal.close();
        });
    }
});