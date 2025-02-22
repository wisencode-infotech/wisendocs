$(document).ready(function () {
    let selectedBlocks = $("#selected-blocks");

    function toggleEmptyMessage() {
        if (selectedBlocks.children("li").length === 0) {
            selectedBlocks.html("<div class='empty-message text-center py-4'>No Topics Added</div>");
        } else {
            $(".empty-message").remove();
        }
    }

    function updateJSON() {
        let hierarchy = [];

        function parseBlock($element) {
            let blockContent = $element.children(".block-content");
            let block = {
                id: blockContent.data("block_type_id"),
                type: blockContent.data("type"),
                sort_order: $element.index() + 1,
                children: []
            };

            $element.children(".nested-list").children("li").each(function () {
                block.children.push(parseBlock($(this)));
            });

            return block;
        }

        selectedBlocks.children("li").each(function () {
            hierarchy.push(parseBlock($(this)));
        });

        console.log(JSON.stringify(hierarchy, null, 2));
        toggleEmptyMessage();
    }

    $("#block-list .draggable").draggable({
        helper: "clone",
        revert: "invalid",
        start: function (event, ui) {
            ui.helper.css({
                "z-index": 9999,
                width: "100%",
                "min-width": "400px"
            }).addClass("dragging-effect");
        },
        stop: function (event, ui) {
            ui.helper.removeClass("dragging-effect");
        }
    });

    $("#selected-blocks, .nested-list").sortable({
        connectWith: ".nested-list, #selected-blocks",
        items: "> li",
        placeholder: "sortable-placeholder",
        tolerance: "pointer",
        start: function (event, ui) {
            ui.placeholder.css({
                height: "50px",
                background: "#f0f0f0",
                border: "2px dashed #007bff",
                margin: "15px 0"
            });
        },
        receive: function (event, ui) {
            let dragged = ui.item;
            let isNew = ui.helper.hasClass("ui-draggable-dragging");

            if (isNew) {
                dragged = $(`
                    <li class="nested-block">
                        <div class="block-content" data-type="${ui.helper.data("type")}" data-block_type_id="${ui.helper.data("block_type_id")}">
                            <span class="block-title">${ui.helper.text()}</span>
                            <div class="block-actions">
                                <button class="btn btn-sm btn-primary text-white edit-block"><i class="bx bx-pencil"></i></button>
                                <button class="btn btn-sm btn-danger text-white delete-block"><i class="bx bx-trash"></i></button>
                            </div>
                        </div>
                        <ul class="nested-list"></ul>
                    </li>
                `);
                ui.helper.remove();
                selectedBlocks.append(dragged);
                makeDraggableDroppable(dragged);
            }

            updateJSON();
        },
        update: updateJSON
    });

    selectedBlocks.droppable({
        accept: ".draggable, .nested-block",
        tolerance: "pointer",
        greedy: true,
        drop: function (event, ui) {
            let dragged = ui.helper.clone();

            if (ui.helper.hasClass("nested-block")) {
                ui.draggable.detach().appendTo(selectedBlocks);
            } else {
                dragged = $(`
                    <li class="nested-block">
                        <div class="block-content" data-type="${ui.helper.data("type")}" data-block_type_id="${ui.helper.data("block_type_id")}">
                            <span class="block-title">${ui.helper.text()}</span>
                            <div class="block-actions">
                                <button class="btn btn-sm btn-primary text-white edit-block"><i class="bx bx-pencil"></i></button>
                                <button class="btn btn-sm btn-danger text-white delete-block"><i class="bx bx-trash"></i></button>
                            </div>
                        </div>
                        <ul class="nested-list"></ul>
                    </li>
                `);
                selectedBlocks.append(dragged);
            }

            makeDraggableDroppable(dragged);
            updateJSON();
        }
    });

    function makeDraggableDroppable(element) {
        element.draggable({
            helper: "clone",
            revert: "invalid",
            start: function (event, ui) {
                ui.helper.css({
                    width: "100%",
                    "min-width": "400px"
                }).addClass("dragging");
            },
            stop: function (event, ui) {
                ui.helper.removeClass("dragging");
            }
        });

        element.droppable({
            accept: ".nested-block",
            greedy: true,
            over: function () {
                $(this).addClass("hover-border");
            },
            out: function () {
                $(this).removeClass("hover-border");
            },
            drop: function (event, ui) {
                let dragged = ui.draggable;
                if (dragged.is(this) || dragged.find(this).length) return;
                $(this).children(".nested-list").append(dragged);
                updateJSON();
            }
        });
    }

    $(document).on("click", ".delete-block", function () {
        $(this).closest("li").remove();
        updateJSON();
    });

    toggleEmptyMessage();
});