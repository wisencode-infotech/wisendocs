@extends('backend.layouts.master')

@section('title') Create Version @endsection

@section('content')

@component('backend.components.breadcrumb')
    @slot('li_1') Versions @endslot
    @slot('title') Create Version @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">{{ __('Create New Version') }}</div>

            <div class="card-body">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('backend.version.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="identifier">Identifier</label>
                        <input type="text" placeholder="V1" class="form-control @error('identifier') is-invalid @enderror" name="identifier" value="{{ old('identifier') }}" required>
                        @error('identifier')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="notes">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" name="notes">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Checkbox for copying content -->
                    <div class="form-check mb-3">
                        <input type="checkbox" checked class="form-check-input" name="copy_content" id="copy_content">
                        <label class="form-check-label" for="copy_content">
                            Copy content from existing version
                        </label>
                    </div>

                    <!-- Dropdown for existing versions -->
                    <div class="form-group mb-3">
                        <label for="existing_version">Select Existing Version:</label>
                        <select class="form-control @error('existing_version') is-invalid @enderror" name="existing_version" id="existing_version">
                            <option value="">-- Select Version --</option>
                            @foreach($versions as $version)
                                <option value="{{ $version->id }}" {{ old('existing_version') == $version->id ? 'selected' : '' }}>
                                    {{ $version->identifier }}
                                </option>
                            @endforeach
                        </select>
                        @error('existing_version')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-success btn-rounded">Create Version</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function(){
        // Enable/disable the version dropdown based on checkbox
        $('#copy_content').change(function(){
            $('#existing_version').prop('disabled', !$(this).is(':checked'));
        });

        // Form validation on submit
        $('form').submit(function(e){
            let isChecked = $('#copy_content').is(':checked');
            let selectedVersion = $('#existing_version').val();

            if (isChecked && !selectedVersion) {
                e.preventDefault();
                toastr.error('Please select a version if "Copy content from existing version" is checked.');
                return false;
            }
        });
    });
</script>
@endsection
