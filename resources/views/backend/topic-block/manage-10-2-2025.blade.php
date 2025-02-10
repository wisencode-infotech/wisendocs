@extends('backend.layouts.master')

@section('title') Manage Topic Block @endsection

<style>
    #middle-list {
        min-height: 300px;
        border: 2px dashed #ccc;
        padding: 25px;
        list-style: none;
    }

    .nested-list {
        list-style: none;
        padding-left: 0;
    }

    .nested-list li:first-child {
        margin-top: 10px;
    }

    .list-group{
        max-height: 500px;
        overflow: auto;
    }

    .list-group-item {
        cursor: grab;
        padding: 10px;
        display: flex;
        align-items: center;
        /* overflow: auto; */
    }

    .list-group-item .item-content {
        flex-grow: 1;
        font-weight: bolder;
        margin-right: 10px;
    }

    .remove-block {
        cursor: pointer;
        color: red;
        font-weight: bold;
    }

    .level-indent {
        padding-left: 20px;
    }

    .btn.rounded-circle {
        width: 30px; /* Adjust as needed */
        height: 30px; /* Adjust as needed */
        align-items: center;
        justify-content: center;
        padding: 0;
    }
</style>

@section('content')

@component('backend.components.breadcrumb')
    @slot('li_1') Manage Topic Block @endslot
    @slot('title') {{ $topic->name }} (Version {{ $topic->versioning()->select('identifier')->first()->identifier ?? '' }} ) @endslot
@endcomponent

<div class="manage-block-section">
    <div class="row">
        <div class="col-md-3 p-3 bg-light border" id="block-list">
            <h5 class="text-center">Available Block Types</h5>
            <ul class="list-group">
                @foreach($block_types as $block_type)
                    <li class="list-group-item draggable" data-type="{{ $block_type->type }}" data-block_type_id="{{ $block_type->id }}" draggable="true">
                        {{ ucfirst(str_replace('-', ' ', $block_type->type)) }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-6 p-3 bg-white border" id="selected-blocks">
            <h5 class="text-center">Selected Blocks</h5>
            
            {!! $block_html !!}

            <input type="hidden" name="selected_blocks" id="selected-blocks-input">
        </div>

        <div class="col-md-3 p-3 bg-light border" id="manage-attribute-section">
            <h5 class="text-center">Block Attributes</h5>
            <input type="hidden" name="attributes[topic_block_id]" id="topic_block_id">
            <input type="hidden" name="attributes[block_type_id]" id="block_type_id">
            <input type="hidden" name="attributes[topic_id]" id="topic_id" value="{{ $topic->id }}">
            
            <div id="attribute-options">Select a block to edit attributes.</div>
            <span class="attribute-error error"></span>
            <button class="btn btn-primary w-100 mt-3" id="save-btn">Save Block Attributes</button>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
$(document).ready(function() {
    let draggedBlockType = null;
    let draggedBlockTypeId = null;

    // Handle dragging
    $(document).on("dragstart", ".draggable", function(event) {
        draggedBlockType = $(this).data("type"); // Store block type
        draggedBlockTypeId = $(this).data("block_type_id"); // Store block type id
        event.originalEvent.dataTransfer.setData("text/plain", draggedBlockType);
        event.originalEvent.dataTransfer.setData("text/plain", draggedBlockTypeId);
    });

    // Prevent multiple drops
    $(document).on("dragover", "#middle-list, .nested-list", function(event) {
        event.preventDefault();
        event.stopPropagation(); // Stop event bubbling
    });

    // Drop event - prevents multiple block creation
    $(document).on("drop", "#middle-list, .nested-list", function(event) {
        event.preventDefault();
        event.stopPropagation(); // Prevent multiple triggers

        let blockType = draggedBlockType;
        if (!blockType) return;

        let blockTypeId = draggedBlockTypeId;
        if (!blockTypeId) return;

        let parentLi = $(event.target).closest("li");
        let level = parentLi.length ? parseInt(parentLi.attr("data-level") || 1) + 1 : 1;

        let newBlock = $(`
            <li class="list-group-item selected-block level-${level}" data-type="${blockType}" data-level="${level}" data-block_type_id="${blockTypeId}">
                <span class="item-content">${blockType.replace("-", " ")}</span>
                <button class="btn btn-sm btn-success edit-block rounded-circle"><i class="bx bx-pencil"></i></button>
                <button class="btn btn-sm btn-danger rounded-circle remove-block"><i class="bx bx-x"></i></button>
                <ul class="nested-list"></ul>
            </li>
        `);

        if (parentLi.length) {
            parentLi.children(".nested-list").append(newBlock);
        } else {
            $("#middle-list").append(newBlock);
        }

        // Make sortable only after adding the block
        $(".nested-list").sortable({
            connectWith: ".nested-list",
            update: function() {
                updateSelectedBlocks();
            }
        });

        updateSelectedBlocks();
    });

    // Enable sorting
    $("#middle-list").sortable({
        connectWith: ".nested-list",
        update: function() {
            updateSelectedBlocks();
        }
    }).disableSelection();

    $(".nested-list").sortable({
        connectWith: ".nested-list",
        update: function() {
            updateSelectedBlocks();
        }
    });

    // Remove block
    $(document).on("click", ".remove-block", function() {
        $(this).closest("li").remove();
        updateSelectedBlocks();
    });

    $(document).on("click", ".edit-block", function () {
        $("#save-btn").prop("disabled", false);
        $('.attribute-error').html('');

        let $block = $(this).closest("li");
        let attributes = $block.attr("data-attribute");
        let blockType = $block.data("type");

        let attributesData = attributes ? JSON.parse(attributes.replace(/&quot;/g, '"')) : {};

        let fieldsHtml = "";
        let block_attributes = @json($block_attributes);

        if (blockType in block_attributes) {
            block_attributes[blockType].forEach(attr => {

                let key = attr.name.split('[').pop().replace(']', '');

                if(key == 'tree'){
                    key = 'nodes';
                }

                let value = attributesData[key] !== undefined ? attributesData[key] : "";
                let formattedValue = formatValue(value);
                let formattedPlaceholder = formatValue(attr.placeholder || "");

                console.log(formattedPlaceholder);
                console.log(value);

                fieldsHtml += `
                    <div class='mb-2'>
                        <label>${attr.label}</label>
                        ${attr.type === 'textarea' 
                            ? `<textarea name="${attr.name}" class="form-control" placeholder="${formattedPlaceholder}">${formattedValue}</textarea>` 
                            : attr.type === 'checkbox'
                                ? `<input type="checkbox" name="${attr.name}" class="form-check-input" ${value == "1" || value == "true" ? "checked" : ""}><br>`
                                : `<input type="${attr.type}" name="${attr.name}" class="form-control" placeholder="${formattedPlaceholder}" value="${formattedValue}">`
                        }
                    </div>`;
            });
        }

        $("#attribute-options").html(fieldsHtml);
    });



    function formatValue(data) {
        if (Array.isArray(data)) {
            return data.map(item => formatValue(item)).join(", "); // Recursively format each item
        } else if (typeof data === 'object' && data !== null) {
            return JSON.stringify(data, null, 2); // Pretty-print JSON for nested objects
        } else {
            return data !== undefined ? data.toString() : ""; // Convert non-object values to string
        }
    }


    // Edit block attributes
    // $(document).on("click", ".edit-block", function() {

    //     $("#save-btn").prop("disabled", false);
    //     $('.attribute-error').html('');

    //     let $block = $(this).closest("li");
    //     let block_type_id = $block.data("block_type_id");
    //     let attributes = $block.attr("data-attribute");
    //     let topic_block_id = $block.attr("data-id");
    //     let blockType = $block.data("type");

    //     if (topic_block_id)
    //         $('#topic_block_id').val(topic_block_id);
    //     else
    //         $('#topic_block_id').val(null);

    //     $('#block_type_id').val(block_type_id);

    //     // Parse attributes JSON if available
    //     let attributesData = attributes ? JSON.parse(attributes.replace(/&quot;/g, '"')) : {};

    //     let fieldsHtml = "";

    //     let block_attributes = @json($block_attributes);

    //     // Ensure each attribute is an array
    //     Object.keys(block_attributes).forEach(key => {
    //         if (!Array.isArray(block_attributes[key])) {
    //             block_attributes[key] = Object.values(block_attributes[key]);
    //         }
    //     });

    //     // console.log(block_attributes);

    //     if (blockType in block_attributes) {
    //         block_attributes[blockType].forEach(attr => {
    //             let value = attributesData[attr.name.split('[').pop().replace(']', '')] || ""; // Get value from attributesData

    //             let placeholderData = attr.placeholder;

    //             // value = JSON.stringify(value, null, 4)

    //             console.log(attributesData);

    //             // if (value) {
    //             //     let jsonString = JSON.stringify(value, null, 4);
    //             //     console.log(value);
    //             // } else {
    //             //     console.error("value is empty or undefined");
    //             // }

    //             placeholder = JSON.stringify(value, null, 4)

    //             // try {
    //             //     let decodedString = decodeHTMLEntities(placeholderData); // Decode HTML entities
    //             //     console.log("Decoded String:", decodedString);

    //             //     let jsonData = JSON.parse(decodedString); // Try parsing JSON

    //             //     console.log("Parsed JSON:", jsonData);
    //             //     var  placeholder = jsonData; // Use parsed JSON
    //             // } catch (error) {
    //             //     console.warn("JSON parse failed, using raw string:", error);
    //             //     var placeholder = placeholderData; // Fallback to plain text
    //             // }

    //             // console.log("Final Placeholder:", placeholder);


    //             //     try {
    //             //         // Parse JSON if it's a string
    //             //         if (typeof placeholderData === 'string') {
    //             //             placeholderData = JSON.parse(placeholderData);
    //             //         }

    //             //         // If it's an array, extract the first object's title
    //             //         if (Array.isArray(placeholderData) && placeholderData.length > 0) {
    //             //             placeholderData = placeholderData[0]; // Get the first item
    //             //         }

    //             //         // Extract the title from `info`
    //             //         let placeholderText = placeholderData?.info?.title || 'No Title Available';

    //             //         // Decode HTML entities (if necessary)
    //             //         const tempDiv = document.createElement("div");
    //             //         tempDiv.innerHTML = placeholderText;
    //             //         placeholderText = tempDiv.textContent || tempDiv.innerText;

    //             //         console.log("Final Placeholder:", placeholderText);

    //             //     } catch (error) {
    //             //         console.error("Error parsing placeholder:", error);
    //             //     }

    //             // console.log(attr.placeholder);

    //             fieldsHtml += `

                
    //             <div class='mb-2'>
    //                 <label>${attr.label}</label>
    //                 ${attr.type === 'textarea' 
    //                     ? `<textarea name="${attr.name}" class="form-control" placeholder="${placeholder}">${value}</textarea>` 
    //                     : attr.type === 'checkbox'
    //                         ? `<input type="checkbox" name="${attr.name}" class="form-check-input" ${value == "1" || value == "true" ? "checked" : ""}><br>`
    //                         : `<input type="${attr.type}" name="${attr.name}" class="form-control" placeholder="${attr.placeholder || ''}" value="${value}">`
    //                 }
    //             </div>`;
    //         });
    //     }

    //     $("#attribute-options").html(fieldsHtml);
    // });

    // function decodeHTMLEntities(text) {
    //     const textarea = document.createElement("textarea");
    //     textarea.innerHTML = text;
    //     return textarea.value;
    // }


    // Update selected blocks
    function updateSelectedBlocks() {
        let selected = [];

        function processList($list) {
            let blocks = [];
            $list.children("li").each(function() {
                let blockType = $(this).data("type");

                // Prevent duplicate blocks
                if (!blocks.some(b => b.type === blockType)) {
                    let block = {
                        type: blockType,
                        level: $(this).data("level"),
                        children: processList($(this).children(".nested-list"))
                    };
                    blocks.push(block);
                }
            });
            return blocks;
        }

        selected = processList($("#middle-list"));
        $("#selected-blocks-input").val(JSON.stringify(selected));
    }

    // Save button event
    $("#save-btn").click(function() {

        if (!checkSaveButtonState()) return;

        let payload = {
            attributes : {},
            topic_block_id : document.getElementById("topic_block_id").value,
            block_type_id : document.getElementById("block_type_id").value,
            topic_id : document.getElementById("topic_id").value
        };

        let attributes = {};

        // Select all input and textarea fields inside #attribute-options
        document.querySelectorAll("#attribute-options input, #attribute-options textarea").forEach(field => {
            let name = field.name.replace("attributes[", "").replace("]", ""); // Extract field name
            attributes[name] = field.value; // Store value
        });

        payload.topic_block_attributes = attributes;

        execPostAjax('{{ route("backend.topic-block.save-attributes", [ $topic ]) }}', payload, 
        function(response) {
            // console.log(response)
            $('#topic_block_id').val(response.data.topic_block.id);
            $('#block_type_id').val(response.data.topic_block.block_type_id);
            
            toastSuccessMsgs(response);
        }, function(error) {
            toastValidationErrors(error);
        });
        
    });

    // Disable the Save button initially
    $("#save-btn").prop("disabled", true);

    function checkSaveButtonState() {
        let allFilled = true;
        
        $("#attribute-options input, #attribute-options textarea").each(function() {
            if ($(this).val().trim() === "") {
                allFilled = false;
            }
        });

        if (allFilled) {
            $('.attribute-error').html('');
            return true;
        } else {
            $('.attribute-error').html('Please fill up all attributes.');
            return false;
        }
    }

    $(document).on("click", ".remove-block", function() {
        let $block = $(this).closest("li");
        let topicBlockId = $block.attr("data-id"); // Assuming topic block has a data-id attribute

        if (!topicBlockId) {
            $block.remove(); // If no ID, just remove from DOM
            updateSelectedBlocks();
            return;
        }

        if (confirm("Are you sure you want to delete this block?")) {
            $.ajax({
                url: "{{ route('backend.topic-block.destroy', $topic) }}", // Adjust route accordingly
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: topicBlockId
                },
                success: function(response) {
                    if (response.success) {
                        $block.remove();
                        updateSelectedBlocks();
                    } else {
                        alert("Error deleting block.");
                    }
                },
                error: function(xhr) {
                    alert("An error occurred: " + xhr.responseText);
                }
            });
        }
    });

});

</script>
@endsection
