export const cardMedia = (data) => {
    if(!data.fullPath || !data.slug) return;

    return `
        <div class="lm-card-media" data-category="none">
            <input class="lm-card-media__checkbox_category" type="hidden" name="Portfolio[category_media_items][]" value="none_${data.id}">
            <input class="lm-card-media__checkbox" type="checkbox" id="${data.slug}" name="__" value="${data.id}">
            <label for="${data.slug}" class="lm-card-media__label">
                 <button class="lm-card-media__remove"></button>
                 <img src="/${data.thumbnail}" class="lm-item__image">
            </label>
        </div>
    `;
};