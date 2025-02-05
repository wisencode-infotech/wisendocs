@extends('backend.layouts.master')

@section('title') Topics @endsection

@section('content')

@component('backend.components.breadcrumb')
@slot('li_1') Topics @endslot
@slot('title') Topics @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm"></div>
                    <div class="col-sm-auto">
                        <div class="text-sm-end">
                            <a href="{{ route('backend.topic.create') }}" class="btn btn-success btn-rounded" id="addTopic-btn"><i class="mdi mdi-plus me-1"></i> Add New</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered" id="topics-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Version</th>
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
<script src="{{ asset('assets/backend/js/datatable/topic.js') }}"></script>
@endsection
