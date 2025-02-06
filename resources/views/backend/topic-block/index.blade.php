@extends('backend.layouts.master')

@section('title') Topic Blocks @endsection

@section('content')

@component('backend.components.breadcrumb')
@slot('li_1') Topic Blocks @endslot
@slot('title') Topic Blocks @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-sm">
                        <div class="search-box me-2 d-inline-block">
                            <div class="position-relative">
                                <input type="text" class="form-control" autocomplete="off" id="searchTableList" placeholder="Search...">
                                <i class="bx bx-search-alt search-icon"></i>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-sm-auto">
                        <div class="text-sm-end">
                            <a href="{{ route('backend.topic-block.create') }}" class="btn btn-success btn-rounded" id="addTopicBlock-btn"><i class="mdi mdi-plus me-1"></i> Add New</a>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
                <div class="table-responsive">
                    <table id="topic-blocks-table" class="table project-list-table align-middle table-nowrap dt-responsive nowrap w-100 table-borderless">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="width: 60px">#</th>
                                <th scope="col">Topic</th>
                                <th scope="col">Block Type</th>
                                <th scope="col">Action</th>
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
<script src="{{ asset('assets/backend/js/datatable/topic-block.js') }}"></script>
<script>
    var TOPIC_BLOCK_URL = "{{ route('backend.topic-block.index', $version->id) }}";
    var DELETE_URL = "{{ route('backend.topic-block.destroy', ':id') }}";
</script>
@endsection
