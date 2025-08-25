import {_UPLOAD} from "../../variables";
import {handlerOpenModalUpload} from "./upload-handler";

document.addEventListener('click', (event) => {
    const target = event.target;
    const elUpload = target.closest('.' + _UPLOAD.actions.modal_show);
    const elField = target.closest('.lm-field');

    if(elUpload) {
        handlerOpenModalUpload(elField);
    }
});