@extends('layouts.app')
@section('title', trans('crud.edit', ['item' => $code_module->code ? $code_module->code : 'N/A']))
@section('title_header', trans('crud.edit', ['item' => $code_module->code ? $code_module->code : 'N/A']))
@section('buttons')
<a href="{{url('admin/exhibitor/'.$code_module->exhibitor_id.'/stands')}}" class="btn btn-primary"><i class="fas fa-chevron-left"></i></a>
@endsection
@section('content')
<div class="container">
    @if ($errors->any())
    @include('admin.partials.errors', ['errors' => $errors])
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('code-modules.update', $code_module->id)}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <input type="hidden" name="exhibitor_id" value="{{ $code_module->exhibitor_id }}">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('tables.code')}}</strong>
                                    <input type="text" name="code" class="form-control" value="{{ $code_module->code }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">{{trans('generals.save')}}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection