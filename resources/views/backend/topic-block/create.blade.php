@extends('backend.layouts.master')

@section('title') Create Topic @endsection

@section('content')

@component('backend.components.breadcrumb')
    @slot('li_1') Topics @endslot
    @slot('title') Create Topic @endslot
@endcomponent

<div class="container">
    <h2>Create Block</h2>

    <form action="{{ route('backend.topic-block.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="topic_id" class="form-label">Topic</label>
            <input type="number" name="topic_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="block_type_id" class="form-label">Block Type</label>
            <select name="block_type_id" id="block_type" class="form-control" required>
                @foreach($blockTypes as $blockType)
                    <option value="{{ $blockType->id }}">{{ $blockType->type }}</option>
                @endforeach
            </select>
        </div>

        <div id="dynamic-fields">
            <!-- Dynamic inputs will appear here -->
        </div>

        <div class="mb-3">
            <label for="order" class="form-label">Order</label>
            <input type="number" name="order" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="start_content_level" class="form-label">Start Content Level</label>
            <input type="number" name="start_content_level" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Block</button>
    </form>
</div>
@endsection

@section('script')
<script>
    document.getElementById('block_type').addEventListener('change', function () {
        let type = this.value;
        let dynamicFields = document.getElementById('dynamic-fields');
        dynamicFields.innerHTML = '';

        if (type == 1) { // Example for Text Block
            dynamicFields.innerHTML = `
                <div class="mb-3">
                    <label for="text" class="form-label">Text</label>
                    <textarea name="attributes[text]" class="form-control" required></textarea>
                </div>
            `;
        } else if (type == 7) { // Example for Notes Block
            dynamicFields.innerHTML = `
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="attributes[title]" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="icon" class="form-label">Icon</label>
                    <input type="text" name="attributes[icon]" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="text" class="form-label">Text</label>
                    <textarea name="attributes[text]" class="form-control" required></textarea>
                </div>
            `;
        } else if (type == 6) { // Example for Screenshot
            dynamicFields.innerHTML = `
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Screenshot</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>
            `;
        } else if (type == 8) { // Screenshot Gallery
            dynamicFields.innerHTML = `
                <div class="mb-3">
                    <label for="images" class="form-label">Upload Gallery Images</label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                </div>
            `;
        }
    });
</script>
@endsection
