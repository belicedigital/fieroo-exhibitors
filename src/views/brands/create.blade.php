@extends('layouts.app')
@section('title', trans('crud.new', ['obj' => trans('entities.brand')]))
@section('title_header', trans('crud.new', ['obj' => trans('entities.brand')]))
@section('buttons')
<a href="{{url('admin/brands')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.back')}}"><i class="fas fa-chevron-left"></i></a>
@endsection
@section('content')
<div class="container">
    @if ($errors->any())
    @include('admin.partials.errors', ['errors' => $errors])
    @endif
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('brands.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.name')}}</strong>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.exhibitor')}}</strong>
                                    <select name="exhibitor_id" class="form-control">
                                        <option value="">{{trans('forms.select_choice')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <div class="icheck-primary d-inline">
                                        <input type="checkbox" id="is_approved" name="is_approved">
                                        <label for="is_approved">{{trans('forms.is_admitted')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">{{trans('generals.save')}}</button>
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
    const getExhibitors = () => {
        let base_url = '/admin/exhibitors/getSelectList'
        common_request.post(base_url)
        .then(response => {
            let data = response.data
            if(data.status) {
                $.each(data.data, function(index, value){
                    let option = document.createElement('option')
                    option.value = value.exhibitor_id
                    option.text = value.company
                    $('select[name="exhibitor_id"]').append(option)
                })
                $('select[name="exhibitor_id"]').select2({
                    theme: "bootstrap4"
                })
            } else {
                toastr.error(data.message)
            }
        })
        .catch(error => {
            toastr.error(error)
            console.log(error)
        })
    }
    $(document).ready(function(){
        getExhibitors();
    });
</script>
@endsection