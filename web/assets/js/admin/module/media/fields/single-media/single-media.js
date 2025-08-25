import {_FIELD_MEDIA} from "../../variables";
import {handlerOpenModalLibrary} from "../../module/modal-library/modal";
import {handlerMediaDeleteImage} from "./handler/delete-image";

document.addEventListener('click', (event) => {
    const target = event.target;
    const elField = target.closest('.' + _FIELD_MEDIA.field);
    if(!elField) {
        return;
    }

    const actionSelect = target.closest('.' + _FIELD_MEDIA.actions.select);
    const actionDelete = target.closest('.' + _FIELD_MEDIA.actions.delete);
    const elInput = elField.querySelector('.' + _FIELD_MEDIA.value);

    /**
     * Open modal library
     */
    if(actionSelect) {
        handlerOpenModalLibrary(elField, [Number(elInput.value)]);
    }

    /**
     * Delete selected media
     */
    if(actionDelete) {
        handlerMediaDeleteImage(elField);
    }
});