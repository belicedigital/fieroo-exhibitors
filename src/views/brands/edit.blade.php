@extends('layouts.app')
@section('title', trans('crud.edit', ['item' => trans('entities.brand').' '.$brand->name]))
@section('title_header', trans('crud.edit', ['item' => trans('entities.brand').' '.$brand->name]))
@section('buttons')
@if(auth()->user()->roles->first()->name == 'collaboratore-espositori')
<a href="{{url('admin/collaborator/'.auth()->user()->id.'/brands')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.back')}}"><i class="fas fa-chevron-left"></i></a>
@else
<a href="{{url('admin/brands')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.back')}}"><i class="fas fa-chevron-left"></i></a>
@endif
@endsection
@section('content')
<div class="container">
    @if(auth()->user()->roles->first()->name == 'espositore' || auth()->user()->roles->first()->name == 'collaboratore-espositori')
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="callout callout-info">
                {!! trans('messages.brands_callout_text') !!}
            </div>
        </div>
    </div>
    @endif
    @if ($errors->any())
    @include('admin.partials.errors', ['errors' => $errors])
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('brands.update', $brand->id)}}" method="POST" enctype="multipart/form-data">
                        @METHOD('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.logo')}}</strong>
                                    <p class="text-sm">{{trans('forms.logo_sub')}}</p>
                                    <input type="file" name="logo" class="form-control" accept="application/pdf, application/ai, application/eps" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.photo')}}</strong>
                                    <p class="text-sm">{{trans('forms.photo_sub')}}</p>
                                    <input type="file" name="photo" class="form-control" accept="application/pdf, application/ai, application/eps, image/jpeg" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.website')}}</strong>
                                    <input type="text" name="website" class="form-control" value="{{ $brand->website }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.email')}}</strong>
                                    <input type="email" name="email" class="form-control" value="{{ $brand->email }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.phone')}}</strong>
                                    <input type="text" name="phone" class="form-control" value="{{ $brand->phone }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.phone_2')}}</strong>
                                    <input type="text" name="phone_2" class="form-control" value="{{ $brand->phone_2 }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.city')}}</strong>
                                    <input type="text" name="city" class="form-control" value="{{ $brand->city }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.nation')}}</strong>
                                    <input type="text" name="nation" class="form-control" value="{{ $brand->nation }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.description')}} (Max: 1000)</strong>
                                    <textarea name="description" class="form-control" maxlength="1000" required>{{ $brand->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="is_read" name="is_read">
                                        <label for="is_read">{{trans('forms.brand_text_check_before_send')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary" disabled>{{trans('generals.send')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#is_read').on('change', function() {
            if($(this).is(':checked')) {
                $('button[type="submit"]').removeAttr('disabled')
            } else {
                $('button[type="submit"]').attr('disabled', true)
            }
        })
    })
</script>
@endsection