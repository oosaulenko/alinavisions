import {_FIELD_MEDIA} from "../../../variables";

export function handlerMediaDeleteImage(element) {
    const elInput = element.querySelector('.' + _FIELD_MEDIA.value);
    const elPreview = element.querySelector('.' + _FIELD_MEDIA.preview);
    const elPreviewImage = elPreview.querySelector('.' + _FIELD_MEDIA.image);

    element.classList.remove('is-active');
    elInput.value = '';

    if(elPreviewImage) {
        elPreviewImage.remove();
    }
}
