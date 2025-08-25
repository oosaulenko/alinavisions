import * as basicLightbox from 'basiclightbox';
import {modalFolder} from '../../template/modal-folder';
import {handlerApiFolderAdd} from "../../handler/api/folder/add";
import {_FOLDER} from "./folder";
import {cardFolder} from "../../template/card-folder";

let modal;

/**
 * Open modal create folder
 */
export function handlerModalOpenFolderAdd() {
    modal = basicLightbox.create(modalFolder());
    modal.show();
}

/**
 * Close modal create folder
 */
export function handlerModalCloseFolderAdd() {
    if(modal) {
        modal.close();
    }
}

/**
 * Add folder
 */
export function handlerFolderAdd(folderName, fieldHandler) {
    handlerApiFolderAdd(folderName).then(r => {
        if(r.status === 'success') {
            const list = fieldHandler.querySelector('.lm-folders');
            list.insertAdjacentHTML('afterbegin', cardFolder(folderName));
            modal.close();
        }
    });
}
