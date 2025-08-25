export const modalFolderMove = () => {
    return `
        <div class="lm-folder_move">
            <div class="lm-modal__header">
                <h6 class="lm-modal__title">Create folder</h6>
            </div>
            <div class="lm-modal__body"> 
                <input class="lm-field-input lm-field--add_folder lm-folder__add_input" type="text">
            </div>
            <div class="lm-modal__footer">
                <button class="btn btn-default lm-action--modal_folder_cancel">Cancel</button>
                <button class="btn btn-primary lm-action--folder_add">Create</button>
        </div>
    `;
}