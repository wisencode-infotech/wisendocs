@extends('backend.layouts.master')

@section('title') Manage Topic Block @endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/backend/css/manage-topic-blocks.css') }}" />
@endsection

@section('content')

@component('backend.components.breadcrumb')
    @slot('li_1') Manage Topic Block @endslot
    @slot('title') {{ $topic->name }} (Version {{ $topic->versioning()->select('identifier')->first()->identifier ?? '' }} ) @endslot
@endcomponent

<div class="manage-block-section">

    <div class="d-flex justify-content-end mb-3">
        <!-- <a target="_blank" href="{{ url('/'. $topic->slug) }}" class="btn btn-info">Publish</a> -->
        <button class="btn btn-info publish">Publish</a>
    </div>


    <div class="row">
        <div class="col-md-3 p-3 bg-light border" id="block-list">
            <h5 class="text-center">Available Block Types</h5>
            <ul class="list-group">
                @foreach($block_types as $block_type)
                    <li class="list-group-item draggable" data-type="{{ $block_type->type }}" data-block_type_id="{{ $block_type->id }}" draggable="true">
                        {{ ucfirst(str_replace('-', ' ', $block_type->type)) }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-6 p-3 bg-white border" id="selected-blocks">
            <h5 class="text-center">Selected Blocks</h5>
            
            {!! $block_html !!}

            <input type="hidden" name="selected_blocks" id="selected-blocks-input">
        </div>

        <div class="col-md-3 p-3 bg-light border hide-if-no-block-active" id="manage-attribute-section">
            <h5 class="text-center">Block Attributes</h5>
            <input type="hidden" name="attributes[topic_block_id]" id="topic_block_id">
            <input type="hidden" name="attributes[block_type_id]" id="block_type_id">
            <input type="hidden" name="attributes[topic_id]" id="topic_id" value="{{ $topic->id }}">
            
            <div id="attribute-options">Select a block to edit attributes.</div>

            <span class="attribute-error error"></span>
            <button class="btn btn-primary w-100 mt-3" id="save-block-attributes">Save Block Attributes</button>
        </div>
    </div>
</div>

@endsection

@section('script')

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script src="{{ asset('assets/backend/js/manage-topic-blocks.js') }}"></script>

@endsection
