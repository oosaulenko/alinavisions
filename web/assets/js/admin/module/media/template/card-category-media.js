export const cardCategoryMedia = (name) => {
    return `
        <div class="lm-card-category_media" data-id="0" data-name="${name}">
            <input type="hidden" name="Portfolio[category_media][]" value="${name}">
            <div class="lm-card-category_media__icon"></div>
            ${name}
            <div class="lm-card-category_media__remove"><i class="fa-solid fa-xmark"></i></div>
        </div>
    `;
};