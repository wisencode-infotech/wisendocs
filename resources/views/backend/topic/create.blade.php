@extends('backend.layouts.master')

@section('title') Create Topic @endsection

@section('content')

@component('backend.components.breadcrumb')
    @slot('li_1') Topics @endslot
    @slot('title') Create Topic @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">{{ __('Create New Topic') }}</div>

            <div class="card-body">
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('backend.topic.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="name">Topic Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="version_id">Select Version</label>
                        <select class="form-control @error('version_id') is-invalid @enderror" name="version_id" id="version_id" required>
                            <option value="">-- Select Version --</option>
                            @foreach($versions as $version)
                                <option value="{{ $version->id }}" {{ old('version_id') == $version->id ? 'selected' : '' }}>
                                    {{ $version->identifier }}
                                </option>
                            @endforeach
                        </select>
                        @error('version_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group text-end">
                        <button type="submit" class="btn btn-success btn-rounded">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
