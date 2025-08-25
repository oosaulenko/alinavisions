import * as basicLightbox from 'basiclightbox';
import {modalUpload} from '../../template/modal-upload';
import {_UPLOAD, _API} from "../../variables";
import {cardMedia} from "../../template/card-media";
import * as FilePond from 'filepond';
import FilePondPluginFileMetadata from 'filepond-plugin-file-metadata';
import 'filepond/dist/filepond.min.css';

FilePond.registerPlugin(
    FilePondPluginFileMetadata
);

let modal;
let field;

/**
 * Open modal delete
 */
export function handlerOpenModalUpload(fieldHandler) {
    field = fieldHandler;

    modal = basicLightbox.create(modalUpload(), {
        onShow: (instance) => {
            const element = instance.element();
            const elFile = element.querySelector('.' + _UPLOAD.file);

            handlerInitFilePond(elFile);

        },
        onClose: (instance) => {
        }
    });

    modal.show();
}

function handlerInitFilePond(input) {
    return FilePond.create(input, {
        allowRevert: false,
        server: {
            process: {
                url: _API.media_add,
                method: 'POST',
                withCredentials: false,
                onload: (response) => {
                    response = JSON.parse(response);
                    const elItems = field.querySelector('.lm-field__items');

                    elItems.insertAdjacentHTML('afterbegin',
                        response.data.map((item) => {
                            return cardMedia(item);
                        }).join(''));

                    return 126;
                }
            }
        }
    });
}
