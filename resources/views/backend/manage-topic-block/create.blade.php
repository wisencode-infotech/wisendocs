@extends('backend.layouts.master')

@section('title') Create Topic Block @endsection

@section('content')

@component('backend.components.breadcrumb')
    @slot('li_1') Manage Topic Block  @endslot
    @slot('title') Create Topic Block @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">{{ __('Create New Block') }}</div>

            <div class="card-body">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <form action="{{ route('backend.topic-block.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="block_type_id" class="form-label">Block Type</label>
                        <select name="block_type_id" id="block_type" class="form-control" required>
                            <option value="">Select Block Type</option>
                            @foreach($block_types as $block_type)
                                <option value="{{ $block_type->id }}">{{ $block_type->type }}</option>
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
                        <select name="start_content_level" id="start_content_level" class="form-control" required>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-success btn-rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    document.getElementById('block_type').addEventListener('change', function () {
        let type = this.value;
        let dynamicFields = document.getElementById('dynamic-fields');
        dynamicFields.innerHTML = ''; // Clear previous fields

        if (type == 1) { // Title Block
            dynamicFields.innerHTML = `
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="attributes[title]" class="form-control" required>
                </div>
            `;
        } else if (type == 2) { // Subtitle Block
            dynamicFields.innerHTML = `
                <div class="mb-3">
                    <label for="subtitle" class="form-label">Subtitle</label>
                    <input type="text" name="attributes[subtitle]" class="form-control" required>
                </div>
            `;
        } else if (type == 3) { // Description Block
            dynamicFields.innerHTML = `
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="attributes[description]" class="form-control" required></textarea>
                </div>
            `;
        } else if (type == 4) { // List Block
            dynamicFields.innerHTML = `
                <div class="mb-3">
                    <label for="list" class="form-label">List</label>
                    <textarea name="attributes[list]" class="form-control" required></textarea>
                </div>
            `;
        } else if (type == 5) { // Code Block
            dynamicFields.innerHTML = `
                <div class="mb-3">
                    <label for="code_block" class="form-label">Code Block</label>
                    <textarea name="attributes[code_block]" class="form-control" required></textarea>
                </div>
            `;
        } else if (type == 6) { // Screenshot Block
            dynamicFields.innerHTML = `
                <div class="mb-3">
                    <label for="image" class="form-label">Upload Screenshot</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>
            `;
        } else if (type == 7) { // Notes Block
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
        } else if (type == 8) { // Screenshot Gallery Block
            dynamicFields.innerHTML = `
                <div class="mb-3">
                    <label for="images" class="form-label">Upload Gallery Images</label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple required>
                </div>
            `;
        } else if (type == 9) { // Tree Block
            dynamicFields.innerHTML = `
                <div class="mb-3">
                    <label for="tree" class="form-label">Tree Structure</label>
                    <textarea name="attributes[tree]" class="form-control" required></textarea>
                </div>
            `;
        } else if (type == 10) { // Custom Link Block
            dynamicFields.innerHTML = `
                <div class="mb-3">
                    <label for="custom_link" class="form-label">Custom Link</label>
                    <input type="url" name="attributes[custom_link]" class="form-control" required>
                </div>
            `;
        }
    });
</script>
@endsection
