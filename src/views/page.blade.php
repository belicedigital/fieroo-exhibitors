@extends('layouts.app')
@section('title', $page->title)
@section('title_header', $page->title)
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{$page->description}}</h5>
                </div>
                <div class="card-body">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection