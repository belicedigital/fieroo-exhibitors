@extends('layouts.app')
@section('title', trans('crud.new', ['obj' => trans('entities.collaborator')]))
@section('title_header', trans('crud.new', ['obj' => trans('entities.collaborator')]))
@section('buttons')
<a href="{{url('admin/collaborators')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.back')}}"><i class="fas fa-chevron-left"></i></a>
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
                    <form action="{{route('collaborators.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            @if(is_object($data['exhibitor_data']))
                            @php
                            $exhibitor_data = $data['exhibitor_data'];
                            @endphp
                            <input type="hidden" id="exhibitor_id" name="exhibitor_id" value="{{ $exhibitor_data->exhibitor_id }}">
                            @else
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.exhibitor')}}</strong>
                                    <select class="form-control" id="exhibitor_id" name="exhibitor_id" required>
                                        <option value="">{{__('forms.select_choice')}}</option>
                                        @foreach($data['exhibitors'] as $exhibitor)
                                        <option value="{{$exhibitor->exhibitor_id}}">{{$exhibitor->company}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.brand')}}</strong>
                                    <select class="form-control" id="brand_id" name="brand_id" required>
                                        <option value="">{{__('forms.select_choice')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.name')}}</strong>
                                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <strong>{{trans('forms.email')}}</strong>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
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
    const resetBrands = () => {
        let select = $('#brand_id');
        $.each(select.find('option[value!=""]'), (index, value) => {
            $(value).remove()
        })
    }
    const initBrands = (exhibitor_id) => {
        common_request.post('/api/collaborators/brands', {
            exhibitor_id: exhibitor_id
        })
        .then(response => {
            let data = response.data
            if(data.status) {
                $.each(data.data, function(index, value) {
                    let option = document.createElement('option')
                    option.value = value.id
                    option.text = value.name
                    $('select[name="brand_id"]').append(option)
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
    $(document).ready(function() {
        let type_element = $('#exhibitor_id').attr('type');
        if(type_element == 'hidden') {
            initBrands($('#exhibitor_id').val())
        } else {
            $('#exhibitor_id').on('change', function() {
                resetBrands()
                let value = $('#exhibitor_id').val()
                if(value.length > 0) {
                    initBrands(value);
                }
            })
        }
    });
</script>
@endsection