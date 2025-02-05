@extends('backend.layouts.master')

@section('title') Edit Version @endsection

@section('content')

@component('backend.components.breadcrumb')
@slot('li_1') Versions @endslot
@slot('title') Edit Version @endslot
@endcomponent

<form method="POST" action="{{ route('backend.version.update', $version->id) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="identifier">Identifier</label>
        <input type="text" class="form-control" name="identifier" value="{{ $version->identifier }}" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" name="description">{{ $version->description }}</textarea>
    </div>
    <div class="form-group">
        <label for="notes">Notes</label>
        <textarea class="form-control" name="notes">{{ $version->notes }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary mt-2">Update</button>
</form>

@endsection
