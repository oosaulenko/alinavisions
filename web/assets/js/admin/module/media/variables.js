/**
 * API
 */
export const _API = {
    media_list: '/api/media/list',
    media_add: '/api/media/add',
    media_update: '/api/media/update',
    media_remove: '/api/media/remove',
    folder_list: '/api/folder/list',
    folder_add: '/api/folder/add',
    folder_update: '/api/folder/update',
    folder_remove: '/api/folder/remove',
    folder_add_media: '/api/folder/add_media',
}

/**
 * Field: Media
 */
export const _FIELD_MEDIA = {
    field: 'lm-field_single_media',
    value: 'lm-field_single_media__input',
    preview: 'lm-field_single_media__preview',
    image: 'lm-field_single_media__image',
    actions: {
        select: 'lm-field_single_media__action--select',
        delete: 'lm-field_single_media__action--delete',
    }
}

export const _FIELD_MULTI_MEDIA = {
    list: 'lm-gallery',
    actions: {
        add: 'lm-gallery__action--add',
        cancel: 'lm-gallery__action--cancel',
        delete: 'lm-gallery__action--delete_selected',
        select: 'lm-gallery__action--select',
        load_more: 'lm-gallery__action--load_more'
    }
}

export const _UPLOAD = {
    file: 'lm-file_upload',
    actions: {
        modal_show: 'lm-action--modal_upload_show',
    }
}

/**
 * Modal: Library
 */
export const _MODAL_GALLERY = {
    title: 'lm-gallery__title',
    list: 'lm-gallery',
    items: 'lm-gallery__items',
    folders: 'lm-gallery__folders',
    actions: {
        select: 'lm-gallery__action--select',
        load_more: 'lm-gallery__action--load_more',
        close: 'lm-gallery__action--close',
    }
}

/**
 * Variables for card media
 */
export const _CARD = {
    list: 'lm-gallery',
    card: 'lm-card-media',
    checkbox: 'lm-card-media__checkbox',
    remove: 'lm-card-media__remove'
}

/**
 * Variables for gallery field
 */
export const _GALLERY = {
    list: 'lm-gallery',
    actions: {
        add: 'lm-gallery__action--add',
        cancel: 'lm-gallery__action--cancel',
        delete: 'lm-gallery__action--delete_selected',
        select: 'lm-gallery__action--select',
        load_more: 'lm-gallery__action--load_more'
    }
}

export const _LIBRARY = {
    title: 'lm-library__folder_name',
    list: 'lm-library',
    actions: {
        upload: '',
        back_to_main_folder: 'lm-action--back_to_main_folder',
        load_more: 'lm-library__action--load_more'
    }
}

/**
 * Variables for library modal
 */
export const _MODAL_DELETE = {
    actions: {
        cancel: 'lm-modal-delete--cancel',
        delete: 'lm-modal-delete--delete',
    }
}