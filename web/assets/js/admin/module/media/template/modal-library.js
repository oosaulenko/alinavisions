export const modalLibrary = () => {
    return `
        <div class="lm-modal lm-modal-library is-loading">
            <div class="lm-modal__body">  
                <div class="lm-gallery lm-field" data-type="library" data-page="1" data-limit="40">  
                    <div class="lm-gallery__wrapper">
                        <div class="lm-gallery__panel">
                            <div class="lm-gallery__actions">
                                <button class="btn btn-default lm-action--back_to_main_folder is-hidden"><i class="fa-solid fa-arrow-left"></i></button>
                                <button class=" btn lm-action--modal_upload_show"><i class="fa-solid fa-upload"></i> Upload file</button>
                                <button type="button" class="btn btn-primary lm-gallery__action lm-gallery__action--select"><i class="fa-solid fa-circle-check"></i> Select</button>
                                <button type="button" class="btn btn-primary lm-gallery__action lm-gallery__action--add"><i class="fa-solid fa-plus"></i></button>
                                <button type="button" class="btn lm-gallery__action lm-gallery__action--cancel">Cancel</button>
                                <button type="button" class="btn btn-danger lm-gallery__action lm-gallery__action--delete_selected">Delete selected</button>
                            </div>
                            <h6 class="lm-gallery__title lm-library_info_title">Media Library</h6>
                            <div class="lm-gallery__right">
                                <button type="button" class="btn lm-gallery__action lm-gallery__action--add_folder lm-action--modal_folder_show"><i class="fa-solid fa-folder-plus"></i> Add folder</button>
                                <button type="button" class="btn lm-gallery__action lm-gallery__action--close"><i class="fa-solid fa-xmark"></i> Close</button>
                            </div>
                        </div>
                        <div class="lm-gallery__folder_items">
                            <div class="lm-gallery__folders lm-folders"></div>
                            <div class="lm-gallery__items lm-field__items"></div>
                        </div>
                        <div class="lm-gallery__footer">
                            <button type="button" class="btn lm-gallery__action lm-gallery__action--load_more">Load more</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}