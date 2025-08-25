import SimpleLightbox from "simplelightbox";

let lightbox = new SimpleLightbox('.section-portfolio_list .section__item:not(.is--hidden)', {});

// lightbox.refresh();

document.addEventListener('click', (e) => {
    const target = e.target;
    const blockTabs = target.closest('.js-tabs');
    const tabBtn = target.closest('.js-tabs .tab');

    if (!tabBtn) return;
    e.preventDefault();

    const section = target.closest('.section');
    const list = section.querySelector('.section__list');
    const listItems = list.querySelectorAll('.section__item');
    const tabs = blockTabs.querySelectorAll('.tab');

    tabs.forEach(tab => tab.classList.remove('active'));
    tabBtn.classList.add('active');

    listItems.forEach(item => {
        if (tabBtn.dataset.name === 'all') return item.classList.remove('is--hidden');

        item.classList.add('is--hidden');

        if (item.dataset.category === tabBtn.dataset.name) {
            item.classList.remove('is--hidden');
        }
    });

    lightbox.refresh();
});