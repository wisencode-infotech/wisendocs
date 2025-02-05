@extends('backend.layouts.master')

@section('title') Dashboard @endsection

@section('content')

@component('backend.components.breadcrumb')
@slot('li_1') Dashboards @endslot
@slot('title') Dashboard @endslot
@endcomponent

<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <p class="fw-medium">Welcome to Wisenshop Docs!</p>
        </div>
    </div>
</div>
</div>
</div>
@endsection
@section('script')
@endsection
