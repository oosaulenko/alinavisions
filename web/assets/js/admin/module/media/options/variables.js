
/**
 * Variables for API
 */
export const _API = {
    list: '/bundle/looly/media-bundle/list',
    add: '/bundle/looly/media-bundle/add',
    remove: '/bundle/looly/media-bundle/remove',
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

/**
 * Variables for media field
 */
export const _MEDIA = {
    field: 'lm-media',
    value: 'lm-media__input',
    preview: 'lm-media__preview',
    image: 'lm-media__image',
    actions: {
        select: 'lm-media__action--select',
        delete: 'lm-media__action--delete',
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
export const _MODAL_LIBRARY = {
    list: 'lm-gallery',
    actions: {
        select: 'lm-gallery__action--select',
        load_more: 'lm-gallery__action--load_more',
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

export const _UPLOAD = {
    file: 'lm-file_upload',
    actions: {
        modal_upload: 'lm-action--modal_upload',
    }
}

export const _FOLDER = {
    card: 'lm-card-folder',
    list: 'lm-library__folders',
    api: {
        list: '/bundle/looly/media-bundle/folder/list',
        add: '/bundle/looly/media-bundle/folder/add',
        add_media: '/bundle/looly/media-bundle/folder/add_media',
        update: '/bundle/looly/media-bundle/folder/update',
        remove: '/bundle/looly/media-bundle/folder/remove',
    },
    fields: {
        add_input: 'lm-field--add_folder',
    },
    actions: {
        modal_show: 'lm-action--modal_add_folder',
        modal_cancel: 'lm-action--modal_folder_cancel',
        add: 'lm-action--add_folder',
    }
}