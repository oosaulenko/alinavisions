import {handlerOpenModalDelete} from "../module/delete";
import {_CARD, _FOLDER, _LIBRARY} from "../options/variables";
import {handlerApiMediaList} from "../handler/api/media/list";
import {cardMedia} from "../template/card-media";
import "./drag";
// import DragSelect, {DSInputElement} from "dragselect";

// document.addEventListener("DOMContentLoaded", () => {
//     // let currentSelection: HTMLElement[] = [];
//     const selectables = Array.from(
//         document.querySelectorAll<HTMLElement>(".lm-card-media")
//     );
//
//     const folders = Array.from(document.querySelectorAll<HTMLElement>(".lm-card-folder"));
//     console.log(folders.length);
//
//     console.log(folders.map((el, i) => ({ element: el, id: el.dataset.folderId ?? `folder-${i}` })));
//
// // Ініціалізація DragSelect
//     const ds = new DragSelect({
//         selectables: selectables as DSInputElement[], // приводимо до потрібного типу
//         area: document.querySelector(".lm-library__wrapper") as HTMLElement, // контейнер
//         draggability: false,
//         selectableClass: 'is--selectable',
//         selectedClass: 'is--selected',
//         // multiSelectMode: true,
//         // multiSelectToggling: true,
//     });
//
//     const getSelected = () => ds.getSelection() as HTMLElement[];
//
//     const transparentImg = new Image();
//     transparentImg.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
//
//     let ghostEl: HTMLDivElement | null = null;
//     let dragging = false;
//
//     function ensureGhost(count: number) {
//         if (ghostEl) return;
//         const el = document.createElement("div");
//         el.className = "ds-drag-ghost";
//         el.textContent = String(count);
//         Object.assign(el.style, {
//             position: "fixed",
//             top: "0",
//             left: "0",
//             transform: "translate(-9999px, -9999px)",
//             padding: "8px 12px",
//             borderRadius: "999px",
//             background: "rgba(0,0,0,0.8)",
//             color: "#fff",
//             fontWeight: "700",
//             fontFamily: "system-ui, -apple-system, Segoe UI, Roboto, sans-serif",
//             fontSize: "14px",
//             boxShadow: "0 6px 18px rgba(0,0,0,0.25)",
//             pointerEvents: "none",
//             zIndex: "9999",
//         } as CSSStyleDeclaration);
//         document.body.appendChild(el);
//         ghostEl = el;
//     }
//
//     function moveGhost(x: number, y: number) {
//         if (!ghostEl) return;
//         const offset = 12; // відступ від курсора
//         ghostEl.style.transform = `translate(${x + offset}px, ${y + offset}px)`;
//     }
//
//     function removeGhost() {
//         ghostEl?.remove();
//         ghostEl = null;
//     }
//
//     document.addEventListener("click", (e) => {
//         if (dragging) {
//             e.stopPropagation();
//             e.preventDefault();
//         }
//     }, true);
//
//     selectables.forEach((card) => {
//         card.setAttribute("draggable", "true");
//
//         card.addEventListener("pointerdown",
//             (e) => {
//                 // DS додає клас 'ds-selected' — перевіряємо по ньому
//                 if (card.classList.contains("is-selected")) {
//                     console.log(`Card ${card.dataset.id} is selected`);
//                     e.stopPropagation();
//                 }
//             },
//             true // capture: ловимо подію РАНІШЕ за DragSelect
//         );
//
//         card.addEventListener("dragstart", (e) => {
//             // якщо тягнемо не-вибране — переносимо лише його
//             // if (!getSelected().includes(card)) ds.setSelection([card]);
//             if (!card.classList.contains("ds-selected")) {
//                 ds.setSelection([card]);
//             }
//
//             const ids = getSelected().map((x) => x.dataset.id ?? "");
//             e.dataTransfer?.setData("application/json", JSON.stringify(ids));
//             e.dataTransfer?.setData("text/plain", ids.join(",")); // fallback
//
//             // сховати нативний ghost
//             e.dataTransfer?.setDragImage(transparentImg, 0, 0);
//
//             // створити наш
//             ensureGhost(getSelected().length);
//             dragging = true;
//         });
//     });
//
//     document.addEventListener("dragover", (e) => {
//         if (!dragging) return;
//         // важливо: дозволити dragover скрізь, щоб подія йшла постійно
//         e.preventDefault();
//         // на всяк випадок оновимо число, якщо вибір зміниться під час drag
//         if (ghostEl) ghostEl.textContent = String(getSelected().length);
//         moveGhost(e.clientX, e.clientY);
//     });
//
//     /** 6) При завершенні — очистка */
//     function endDragCleanup() {
//         dragging = false;
//         removeGhost();
//     }
//     document.addEventListener("drop", endDragCleanup, true);
//     document.addEventListener("dragend", endDragCleanup, true);
//
//     /** 7) Папки як drop-зони */
//     folders.forEach((folder) => {
//         folder.addEventListener("dragover", (e) => {
//             e.preventDefault();
//             folder.classList.add("drag-over");
//         });
//         folder.addEventListener("dragleave", () => folder.classList.remove("drag-over"));
//         folder.addEventListener("drop", (e) => {
//             e.preventDefault();
//             folder.classList.remove("drag-over");
//
//             const data = e.dataTransfer?.getData("application/json");
//             const ids: string[] = data ? JSON.parse(data) : [];
//             const folderId = folder.dataset.name ?? "";
//             console.log(`Переміщуємо ${ids.length} елемент(и) у папку ${folderId}`, ids);
//
//             // TODO: тут виклик твого API moveMedia(ids, folderId)
//         });
//     });
//
//     // function makeCountGhost(count: number): HTMLElement {
//     //     const el = document.createElement("div");
//     //     el.textContent = String(count);
//     //     el.className = "ds-drag-ghost";
//     //     Object.assign(el.style, {
//     //         position: "fixed",
//     //         top: "0",
//     //         left: "0",
//     //         padding: "8px 12px",
//     //         borderRadius: "999px",
//     //         background: "rgba(0,0,0,0.75)",
//     //         color: "#fff",
//     //         fontWeight: "600",
//     //         fontFamily: "system-ui, -apple-system, Segoe UI, Roboto, sans-serif",
//     //         fontSize: "14px",
//     //         boxShadow: "0 6px 18px rgba(0,0,0,0.25)",
//     //         pointerEvents: "none",
//     //         zIndex: "9999",
//     //     } as CSSStyleDeclaration);
//     //     document.body.appendChild(el);
//     //     return el;
//     // }
//     //
//     // selectables.forEach((card) => {
//     //     card.setAttribute("draggable", "true");
//     //
//     //     card.addEventListener("dragstart", (e) => {
//     //         // Якщо тягнемо картку поза поточним вибором — переносимо лише її
//     //         if (!getSelected().includes(card)) {
//     //             ds.setSelection([card]);
//     //         }
//     //
//     //         const selected = getSelected();
//     //         const ids = selected.map((x) => x.dataset.id ?? "");
//     //         e.dataTransfer?.setData("application/json", JSON.stringify(ids));
//     //         e.dataTransfer?.setData("text/plain", ids.join(",")); // fallback
//     //
//     //         // Кастомний drag-«привид» з кількістю
//     //         const ghost = makeCountGhost(selected.length);
//     //
//     //         // Дати браузеру порахувати розмір — і прикріпити як drag image
//     //         requestAnimationFrame(() => {
//     //             e.dataTransfer?.setDragImage(ghost, ghost.offsetWidth / 2, ghost.offsetHeight / 2);
//     //         });
//     //
//     //         // При завершенні перетягування прибираємо «привид»
//     //         const cleanup = () => ghost.remove();
//     //         document.addEventListener("dragend", cleanup, { once: true, capture: true });
//     //         document.addEventListener("drop", cleanup, { once: true, capture: true });
//     //     });
//     // });
//     //
//     // folders.forEach((folder) => {
//     //     console.log(`Folder element: ${folder}, ID: ${folder.dataset.name}`);
//     //     folder.addEventListener("dragover", (e) => {
//     //         e.preventDefault(); // дозволяє drop
//     //         folder.classList.add("drag-over");
//     //     });
//     //     folder.addEventListener("dragleave", () => {
//     //         folder.classList.remove("drag-over");
//     //     });
//     //     folder.addEventListener("drop", (e) => {
//     //         e.preventDefault();
//     //         folder.classList.remove("drag-over");
//     //
//     //         const data = e.dataTransfer?.getData("application/json");
//     //         const ids: string[] = data ? JSON.parse(data) : [];
//     //         const folderId = folder.dataset.name ?? "";
//     //
//     //         // TODO: твоя логіка переміщення (API/DOM)
//     //         console.log(`Переміщуємо ${ids.length} елемент(и) у папку ${folderId}`, ids);
//     //     });
//     // });
// });

document.addEventListener('click', (event) => {
    const target = event.target as Element;

    const elList = <HTMLElement> target.closest('.' + _LIBRARY.list);
    const elCard = target.closest('.' + _CARD.card) as HTMLElement;
    const btnRemoveCard = target.closest('.' + _CARD.remove);
    const btnLoadMore = target.closest('.' + _LIBRARY.actions.load_more) as HTMLButtonElement;
    const actionBackToMainFolder = target.closest('.' + _LIBRARY.actions.back_to_main_folder) as HTMLButtonElement;

    if(btnRemoveCard || btnLoadMore) {
        event.preventDefault();
        event.stopPropagation();
    }

    if(btnRemoveCard) {
        handlerOpenModalDelete(elCard);
    }

    if(btnLoadMore) {
        const page =  Number(elList.getAttribute('data-page'));
        const limit = Number(elList.getAttribute('data-limit'));
        const itemsEl = elList.querySelector('.lm-library__items') as HTMLElement;
        btnLoadMore.classList.add('is-loading');

        handlerApiMediaList(limit, page).then((response) => {
            itemsEl.insertAdjacentHTML('beforeend',
                response.data.map((item) => {
                    return cardMedia(item);
                }).join(''));

            if(response.data.length < limit) {
                btnLoadMore.style.display = 'none';
            }

            elList.setAttribute('data-page', (page + 1).toString());
            btnLoadMore.classList.remove('is-loading');
        }).catch((error) => {});
    }

    if(actionBackToMainFolder) {
        console.log('Back to main folder clicked');
        const elList = document.querySelector('.' + _LIBRARY.list) as HTMLElement;
        elList.setAttribute('data-folder-name', '0');
        elList.setAttribute('data-page', '1');
        elList.querySelector('.lm-library__items')!.innerHTML = '';
        actionBackToMainFolder.classList.add('is-hidden');
        const nameTitleEl = document.querySelector('.lm-library__folder_name');
        nameTitleEl!.textContent = '';
        const folders = document.querySelector('.' + _FOLDER.list) as HTMLElement;
        folders.classList.remove('is-hidden');

        // elList.querySelector('.' + _LIBRARY.actions.load_more)!.style.display = 'block';
        handlerApiMediaList(20, 1).then((response) => {
            const itemsEl = elList.querySelector('.lm-library__items') as HTMLElement;
            itemsEl.innerHTML = response.data.map((item) => {
                return cardMedia(item);
            }).join('');
        });
    }
});

document.addEventListener('dblclick', (event) => {
    const target = event.target as Element;
    const elFolder = target.closest('.' + _FOLDER.card) as HTMLElement;

    if(elFolder) {
        const folderName = elFolder.getAttribute('data-name');
        const elList = document.querySelector('.' + _LIBRARY.list) as HTMLElement;
        const nameTitleEl = document.querySelector('.lm-library__folder_name');
        const actionBackToMainFolder = document.querySelector('.' + _LIBRARY.actions.back_to_main_folder) as HTMLButtonElement;
        const folders = document.querySelector('.' + _FOLDER.list) as HTMLElement;
        const btnLoadMore = document.querySelector('.' + _LIBRARY.actions.load_more) as HTMLButtonElement;

        console.log(`Folder clicked: Name=${folderName}`);

        if(folderName && elList) {
            elList.setAttribute('data-folder-name', folderName);
            elList.setAttribute('data-page', '1');
            elList.querySelector('.lm-library__items')!.innerHTML = '';
            actionBackToMainFolder.classList.remove('is-hidden');
            nameTitleEl!.textContent = ' - ' + folderName;
            folders.classList.add('is-hidden');

            // elList.querySelector('.' + _LIBRARY.actions.load_more)!.style.display = 'block';
            handlerApiMediaList(20, 1, [], folderName).then((response) => {
                const itemsEl = elList.querySelector('.lm-library__items') as HTMLElement;
                itemsEl.innerHTML = response.data.map((item) => {
                    return cardMedia(item);
                }).join('');

                if(response.data.length < 20) {
                    btnLoadMore.style.display = 'none';
                }
            });
        }
    }
});