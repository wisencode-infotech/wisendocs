@extends('backend.layouts.master')

@section('title') Create Version @endsection

@section('content')

@component('backend.components.breadcrumb')
    @slot('li_1') Versions @endslot
    @slot('title') Create Version @endslot
@endcomponent

<form method="POST" action="{{ route('backend.version.store') }}">
    @csrf

    <div class="form-group">
        <label for="identifier">Identifier</label>
        <input type="text" class="form-control @error('identifier') is-invalid @enderror" name="identifier" value="{{ old('identifier') }}" required>
        @error('identifier')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
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
        <input type="checkbox" class="form-check-input" name="copy_content" id="copy_content">
        <label class="form-check-label" for="copy_content">
            Copy content from existing version
        </label>
    </div>

    <!-- Dropdown for existing versions -->
    <div class="form-group mb-3">
        <label for="existing_version">Select Existing Version:</label>
        <select class="form-control @error('existing_version') is-invalid @enderror" name="existing_version" id="existing_version" disabled>
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

    <button type="submit" class="btn btn-primary">Save</button>
</form>


@endsection

@section('script')
<script>
    $(document).ready(function(){
        $('#copy_content').change(function(){
            $('#existing_version').prop('disabled', !$(this).is(':checked'));
        });
    });
</script>
@endsection
