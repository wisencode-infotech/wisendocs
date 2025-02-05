@extends('backend.layouts.master')

@section('title') Version @endsection

@section('content')

@component('backend.components.breadcrumb')
@slot('li_1') Versions @endslot
@slot('title') Versions @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
            <div class="row mb-2">
                    <div class="col-sm"></div>
                    <!-- end col -->
                    <div class="col-sm-auto">
                        <div class="text-sm-end">
                            <a href="{{ route('backend.version.create') }}" class="btn btn-success btn-rounded" id="addProject-btn"><i class="mdi mdi-plus me-1"></i> Add New</a>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="versions-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Identifier</th>
                                <th>Description</th>
                                <th>Notes</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/backend/js/datatable/versions.js') }}"></script>
@endsection
