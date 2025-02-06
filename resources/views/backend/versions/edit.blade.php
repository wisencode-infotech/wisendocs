@extends('backend.layouts.master')

@section('title') Edit Version @endsection

@section('content')

@component('backend.components.breadcrumb')
@slot('li_1') Versions @endslot
@slot('title') Edit Version @endslot
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

                <form method="POST" action="{{ route('backend.version.update', $version->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="identifier">Identifier</label>
                        <input type="text" class="form-control" name="identifier" value="{{ $version->identifier }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description">{{ $version->description }}</textarea>
                    </div>
                    <div class="form-group mb-3">
                        <label for="notes">Notes</label>
                        <textarea class="form-control" name="notes">{{ $version->notes }}</textarea>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-success btn-rounded">Update</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



@endsection
