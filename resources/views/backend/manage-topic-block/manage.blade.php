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
    @slot('title') Manage Topic Block @endslot
@endcomponent

<div class="manage-block-section">
    <div class="row">
        <div class="col-md-3 p-3 bg-light border" id="block-list">
            <h5 class="text-center">Available Block Types</h5>
            <ul class="list-group">
                @foreach($block_types as $block_type)
                    <li class="list-group-item draggable" data-type="{{ $block_type->type }}" draggable="true">
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
            <input type="hidden" name="attributes[block_id]" id="block_id">
            <input type="hidden" name="attributes[block_type]" id="block_type">
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

    // Handle dragging
    $(document).on("dragstart", ".draggable", function(event) {
        draggedBlockType = $(this).data("type"); // Store block type
        event.originalEvent.dataTransfer.setData("text/plain", draggedBlockType);
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

        let parentLi = $(event.target).closest("li");
        let level = parentLi.length ? parseInt(parentLi.attr("data-level") || 1) + 1 : 1;

        let newBlock = $(`
            <li class="list-group-item selected-block level-${level}" data-type="${blockType}" data-level="${level}">
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

    // Edit block attributes
    $(document).on("click", ".edit-block", function() {

        $("#save-btn").prop("disabled", false);
        $('.attribute-error').html('');

        let $block = $(this).closest("li");
        let blockType = $block.data("type");
        let attributes = $block.attr("data-attribute");
        let block_id = $block.attr("data-id");

        if (block_id) {
            $('#block_id').val(block_id);
        } else {
            $('#block_id').val(null);
        }

        $('#block_type').val(blockType);

        // Parse attributes JSON if available
        let attributesData = attributes ? JSON.parse(attributes.replace(/&quot;/g, '"')) : {};

        let fieldsHtml = "";

        let blockAttributes = {
            'title': [
                { label: 'Text', name: 'attributes[text]', type: 'textarea' }
            ],
            'subtitle': [
                { label: 'Text', name: 'attributes[text]', type: 'textarea' }
            ],
            'description': [
                { label: 'Text', name: 'attributes[text]', type: 'textarea' }
            ],
            'list': [
                { label: 'List Items', name: 'attributes[list]', type: 'textarea', placeholder: 'Enter items separated by commas' }
            ],
            'code_block': [
                { label: 'Code', name: 'attributes[code]', type: 'textarea', placeholder: 'Enter code here' },
                { label: 'Language', name: 'attributes[language]', type: 'text', placeholder: 'e.g., PHP, JavaScript' }
            ],
            'screenshot': [
                { label: 'Title', name: 'attributes[title]', type: 'text' },
                { label: 'Description', name: 'attributes[description]', type: 'textarea' },
                { label: 'Image URL', name: 'attributes[imageUrl]', type: 'text' }
            ],
            'note': [
                { label: 'Type', name: 'attributes[type]', type: 'text' },
                { label: 'Title', name: 'attributes[title]', type: 'text' },
                { label: 'Icon', name: 'attributes[icon]', type: 'text' },
                { label: 'Text', name: 'attributes[text]', type: 'textarea' }
            ],
            'screenshot-gallery': [
                { label: 'Image Title', name: 'attributes[images][0][title]', type: 'text' },
                { label: 'Image Description', name: 'attributes[images][0][description]', type: 'textarea' },
                { label: 'Image URL', name: 'attributes[images][0][imageUrl]', type: 'text' }
            ],
            'tree': [
                { label: 'Structure', name: 'attributes[tree]', type: 'textarea', placeholder: 'Enter hierarchical structure' }
            ],
            'custom-link': [
                { label: 'URL', name: 'attributes[url]', type: 'text' },
                { label: 'Text', name: 'attributes[text]', type: 'text' },
                { label: 'Target', name: 'attributes[target]', type: 'text', placeholder: '_blank, _self, etc.' }
            ]
        };

        if (blockType in blockAttributes) {
            blockAttributes[blockType].forEach(attr => {
                let value = attributesData[attr.name.split('[').pop().replace(']', '')] || ""; // Get value from attributesData

                fieldsHtml += `
                    <label>${attr.label}</label>
                    ${attr.type === 'textarea' 
                        ? `<textarea name="${attr.name}" class="form-control" placeholder="${attr.placeholder || ''}">${value}</textarea>` 
                        : `<input type="${attr.type}" name="${attr.name}" class="form-control" placeholder="${attr.placeholder || ''}" value="${value}">`
                    }
                `;
            });
        }

        $("#attribute-options").html(fieldsHtml);
    });

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

       

        checkSaveButtonState();

        let attributes = {};

            // Select all input and textarea fields inside #attribute-options
            document.querySelectorAll("#attribute-options input, #attribute-options textarea").forEach(field => {
                let name = field.name.replace("attributes[", "").replace("]", ""); // Extract field name
                attributes[name] = field.value; // Store value
            });

            attributes["block_id"] = document.getElementById("block_id").value;
            attributes["block_type"] = document.getElementById("block_type").value;
            attributes["topic_id"] = document.getElementById("topic_id").value;

            console.log(attributes); // Check the collected attributes
        
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

});

</script>
@endsection
