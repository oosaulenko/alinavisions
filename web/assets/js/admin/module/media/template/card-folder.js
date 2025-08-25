export const cardFolder = (name) => {
    return `
        <div class="lm-card-folder" data-id="0" data-name="${name}">
            <div class="lm-card-folder__icon"></div>
            ${name}
        </div>
    `;
};