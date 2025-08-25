import DragSelect from "dragselect";
import {handlerApiFolderAddMedia} from "../handler/api/folder/add_media";

document.addEventListener("DOMContentLoaded", () => {
    const area = document.querySelector<HTMLElement>(".lm-library__items")!;
    const cards = Array.from(document.querySelectorAll<HTMLElement>(".lm-card-media"));
    const folders = Array.from(document.querySelectorAll<HTMLElement>(".lm-card-folder"));

    const ds = new DragSelect({
        area,
        selectables: cards,
        multiSelectMode: true,
        multiSelectToggling: true,
    });

    const getSelected = () => ds.getSelection() as HTMLElement[];

    const transparentImg = new Image();
    transparentImg.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";

    /** 3) Наш живий лічильник */
    let ghostEl: HTMLDivElement | null = null;
    let dragging = false;

    function ensureGhost(count: number) {
        if (ghostEl) return;
        ghostEl = document.createElement("div");
        ghostEl.className = "ds-drag-ghost";
        ghostEl.textContent = String(count) + " вибрано";
        Object.assign(ghostEl.style, {
            position: "fixed",
            top: "0",
            left: "0",
            transform: "translate(-9999px,-9999px)",
            padding: "8px 12px",
            borderRadius: "999px",
            background: "rgba(0,0,0,0.8)",
            color: "#fff",
            fontWeight: "700",
            fontFamily: "system-ui, -apple-system, Segoe UI, Roboto, sans-serif",
            fontSize: "14px",
            boxShadow: "0 6px 18px rgba(0,0,0,0.25)",
            pointerEvents: "none",
            zIndex: "9999",
        } as CSSStyleDeclaration);
        document.body.appendChild(ghostEl);
    }

    function moveGhost(x: number, y: number) {
        if (!ghostEl) return;
        const offset = 12;
        ghostEl.style.transform = `translate(${x + offset}px, ${y + offset}px)`;
    }

    function removeGhost() {
        ghostEl?.remove();
        ghostEl = null;
    }

    cards.forEach((card) => {
        card.addEventListener("pointerdown", (e) => {
            if (card.classList.contains("ds-selected")) {
                console.log("DragSelect: pointerdown on selected card, stopping DS");
                e.stopPropagation();
            }
        }, true);

        card.addEventListener("mousedown", (e) => {
            if (card.classList.contains("ds-selected")) {
                console.log("DragSelect: mousedown on selected card, stopping DS");
                e.stopPropagation();
            }
        }, true);

        card.setAttribute("draggable", "true");

        card.addEventListener("dragstart", (e) => {
            if (!card.classList.contains("ds-selected")) {
                ds.setSelection([card]);
            }

            console.log("DragSelect: dragstart on card", card.dataset.id);

            const selected = getSelected();
            const ids = selected.map((x) => x.dataset.id ?? "");

            // деякі браузери вимагають text/plain (інакше drag не стартує/не дропнеться)
            e.dataTransfer!.effectAllowed = "move";
            e.dataTransfer!.setData("application/json", JSON.stringify(ids));
            e.dataTransfer!.setData("text/plain", ids.join(","));    // Chrome/Firefox-safe
            e.dataTransfer!.setData("text/uri-list", "about:blank"); // Safari-safe «якорець»

            // сховати нативний ghost і показати наш лічильник
            e.dataTransfer!.setDragImage(transparentImg, 0, 0);
            ensureGhost(selected.length);
            dragging = true;
        });
    });

    // function stopDSOnSelected(card: HTMLElement) {
    //     const handler = (e: Event) => {
    //         console.log(e);
    //         if (card.classList.contains("ds-selected")) {
    //             e.stopPropagation(); // не чіпай preventDefault — drag може не стартувати
    //         }
    //     };
    //     ["pointerdown", "mousedown", "touchstart", "dragover"].forEach((type) => {
    //         card.addEventListener(type, handler, true); // capture
    //     });
    // }
    //
    // cards.forEach((card) => stopDSOnSelected(card));

    /** 6) Живий рух лічильника */
    document.addEventListener("dragover", (e) => {
        if (!dragging) return;
        e.preventDefault();
        if (ghostEl) ghostEl.textContent = String(getSelected().length);
        moveGhost(e.clientX, e.clientY);
    }, {passive: false});

    function endDragCleanup() {
        dragging = false;
        removeGhost();
    }
    document.addEventListener("drop", endDragCleanup, true);
    document.addEventListener("dragend", endDragCleanup, true);

// захист від «фантомного кліку» після drag, який може змінити вибір
    document.addEventListener("click", (e) => {
        if (dragging) {
            e.stopPropagation();
            e.preventDefault();
        }
    }, true);


    folders.forEach((folder) => {
        folder.addEventListener("dragover", (e) => {
            e.preventDefault();
            e.dataTransfer!.dropEffect = "move";
            folder.classList.add("drag-over");
        });

        folder.addEventListener("dragleave", () => folder.classList.remove("drag-over"));

        folder.addEventListener("drop", (e) => {
            e.preventDefault();
            folder.classList.remove("drag-over");

            const raw = e.dataTransfer!.getData("application/json") || "[]";
            const ids: [] = JSON.parse(raw);
            const folderId = folder.dataset.name ?? "";
            ds.setSelection([]);
            const ids_string = ids.join(",");

            console.log(`Переміщуємо ${ids.length} елемент(и) у папку ${folderId}`, ids);
            handlerApiFolderAddMedia(folderId, ids_string).then((response) => {
                if (response.status === "success") {
                    console.log("Елементи успішно переміщено");

                    ids.forEach((id) => {
                        document.querySelector('.lm-card-media[data-id="' + id + '"]')?.remove();
                    });

                } else {
                    console.error("Помилка при переміщенні елементів:", response.message);
                }
            });
        });
    });

    document.addEventListener(
        "click",
        (e) => {
            if (dragging) return;
            const t = e.target as HTMLElement;
            const clickInsideArea = !!t.closest(".lm-library__items");
            if (!clickInsideArea) {
                ds.setSelection([]);
            }
        },
        true
    );

});
