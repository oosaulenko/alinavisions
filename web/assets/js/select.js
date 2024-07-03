import SlimSelect from 'slim-select'

document.addEventListener("DOMContentLoaded", function() {
    const selects = document.querySelectorAll("select");

    selects.forEach(function(select) {
        new SlimSelect({
            select: select,
            settings: {
                showSearch: false,
            }
        });
    });
});

