import {handlerModalOpenFolderAdd, handlerModalCloseFolderAdd, handlerFolderAdd} from "./folder-handler";
import {_LIBRARY} from "../../variables";
import {handlerApiMediaList} from "../../handler/api/media/list";
import {cardMedia} from "../../template/card-media";

export const _FOLDER = {
    list: 'lm-folders',
    card: 'lm-card-folder',
    fields: {
        add_input: 'lm-folder__add_input',
    },
    actions: {
        modal_show: 'lm-action--modal_folder_show',
        modal_cancel: 'lm-action--modal_folder_cancel',
        add: 'lm-action--folder_add',
        update: 'lm-action--folder_update',
        remove: 'lm-action--folder_remove',
        back_to_main_folder: 'lm-action--back_to_main_folder',
    }
}

let field;

/**
 * Show modal to add folder
 */
document.addEventListener('click', (event) => {
    const target = event.target;
    const elModal = target.closest('.' + _FOLDER.actions.modal_show);
    const elField = target.closest('.lm-field');

    if(elModal) {
        field = elField;
        handlerModalOpenFolderAdd();
    }
});


/**
 * Cancel modal to add folder
 */
document.addEventListener('click', (event) => {
    const target = event.target;
    const elCancel = target.closest('.' + _FOLDER.actions.modal_cancel);

    if(elCancel) {
        handlerModalCloseFolderAdd();
    }
});


/**
 * Create folder
 */
document.addEventListener('click', (event) => {
    const target = event.target;
    const elActionAdd = target.closest('.' + _FOLDER.actions.add);

    if(elActionAdd) {
        const elField = document.querySelector('.' + _FOLDER.fields.add_input);
        const folderName = elField.value.trim();

        if(folderName) {
            handlerFolderAdd(folderName, field);
        } else {
            console.error('Folder name cannot be empty');
        }
    }
});

/**
 * Open folder
 */
document.addEventListener('dblclick', (event) => {
    const target = event.target;
    const elFolder = target.closest('.' + _FOLDER.card);
    const elField = target.closest('.lm-field');

    if(elFolder) {
        const folderName = elFolder.getAttribute('data-name');
        field = elField;

        console.log(`Open folder: Name=${folderName}`);
        console.log(`Field:`, field);

        field.querySelector('.' + _FOLDER.actions.back_to_main_folder).classList.remove('is-hidden');
        field.querySelector('.' + _FOLDER.actions.modal_show).classList.add('is-hidden');
        field.querySelector('.lm-library_info_title').textContent = folderName;

        const folders = field.querySelector('.' + _FOLDER.list);
        const btnLoadMore = field.querySelector('.' + _LIBRARY.actions.load_more);

        if(folderName && field) {
            field.setAttribute('data-folder-name', folderName);
            field.setAttribute('data-page', '1');
            field.querySelector('.lm-field__items').innerHTML = '';
            folders.classList.add('is-hidden');

            handlerApiMediaList(20, 1, [], folderName).then((response) => {
                const itemsEl = field.querySelector('.lm-field__items');

                console.log(response.data);

                itemsEl.innerHTML = response.data.map((item) => {
                    return cardMedia(item);
                }).join('');

                if(response.data.length < 20) {
                    // btnLoadMore.style.display = 'none';
                }
            });
        }

        // const elList = document.querySelector('.' + _LIBRARY.list);
        // const nameTitleEl = document.querySelector('.lm-library__folder_name');
        // const actionBackToMainFolder = document.querySelector('.' + _LIBRARY.actions.back_to_main_folder);
        // const folders = document.querySelector('.' + _FOLDER.list);
        // const btnLoadMore = document.querySelector('.' + _LIBRARY.actions.load_more);
        //
        // console.log(`Folder clicked: Name=${folderName}`);

        // if(folderName && elList) {
        //     elList.setAttribute('data-folder-name', folderName);
        //     elList.setAttribute('data-page', '1');
        //     elList.querySelector('.lm-library__items').innerHTML = '';
        //     actionBackToMainFolder.classList.remove('is-hidden');
        //     nameTitleEl.textContent = ' - ' + folderName;
        //     folders.classList.add('is-hidden');
        //
        //     // elList.querySelector('.' + _LIBRARY.actions.load_more)!.style.display = 'block';
        //     handlerApiMediaList(20, 1, [], folderName).then((response) => {
        //         const itemsEl = elList.querySelector('.lm-library__items');
        //         itemsEl.innerHTML = response.data.map((item) => {
        //             return cardMedia(item);
        //         }).join('');
        //
        //         if(response.data.length < 20) {
        //             btnLoadMore.style.display = 'none';
        //         }
        //     });
        // }
    }
});

/**
 * Back to main folder
 */
document.addEventListener('click', (event) => {
    const target = event.target;
    const action = target.closest('.' + _FOLDER.actions.back_to_main_folder);

    if(action) {
        field.querySelector('.' + _FOLDER.actions.back_to_main_folder).classList.add('is-hidden');
        field.querySelector('.' + _FOLDER.actions.modal_show).classList.remove('is-hidden');
        field.querySelector('.lm-library_info_title').textContent = 'Media Library';
        field.querySelector('.' + _FOLDER.list).classList.remove('is-hidden');
        field.removeAttribute('data-folder-name');
        field.querySelector('.lm-field__items').innerHTML = '';
        field.setAttribute('data-page', '1');

        handlerApiMediaList(20, 1, []).then((response) => {
            const itemsEl = field.querySelector('.lm-field__items');
            itemsEl.innerHTML = response.data.map((item) => {
                return cardMedia(item);
            }).join('');

            if(response.data.length < 20) {
                // btnLoadMore.style.display = 'none';
            }
        });
    }
});
