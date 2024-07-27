@extends('layouts/layoutMaster')

@section('title', trans('crud.edit', ['obj' => trans('entities.categories')]))
@section('title_header', trans('crud.edit', ['obj' => trans('entities.categories')]))

@section('path', trans('entities.categories'))
@section('current', trans('crud.new', ['obj' => trans('entities.category')]))

@section('button')
    <a href="{{ url('admin/categories') }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ trans('generals.back') }}"><i class="fas fa-chevron-left"></i></a>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @METHOD('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group mb-3">
                                    <strong>{{ trans('tables.name') }}</strong>
                                    <input type="text" name="name" class="form-control" value="{{ $category->name }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group mb-3">
                                    <label class="switch switch-primary switch-sm me-0">
                                        <input class='switch-input'type="checkbox" id="is_active" name="is_active"
                                            {{ $category->is_active ? 'checked' : '' }} data-toggle="toggle"
                                            data-on="{{ trans('generals.yes') }}" data-off="{{ trans('generals.no') }}"
                                            data-onstyle="success" data-offstyle="danger" data-size="sm">
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                        <span class="switch-label fs-6 fw-bolder">{{ trans('forms.publish') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-end">
                            <button type="submit" class="btn btn-primary">{{ trans('generals.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
