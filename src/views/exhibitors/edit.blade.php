@extends('layouts.app')
@section('title', trans('entities.exhibitor').' '.$exhibitor->company)
@section('title_header', trans('entities.exhibitor').' '.$exhibitor->company)
@section('buttons')
<a href="{{url('admin/exhibitors')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.back')}}"><i class="fas fa-chevron-left"></i></a>
{{--<a id="admitBtn" href="javascript:void(0)" onclick="admit({{$exhibitor->exhibitor_id}})" class="btn btn-primary {{$exhibitor->is_admitted ? 'd-none' : ''}}" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.admit')}}"><i class="fas fa-check"></i></a>--}}
{{--<a href="{{url('admin/exhibitor/'.$exhibitor->id.'/download-pdf')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.pdf_download')}}"><i class="fas fa-download"></i></a>--}}
@endsection
@section('content')
<div class="container">
    @if ($errors->any())
    @include('admin.partials.errors', ['errors' => $errors])
    @endif

    @if (Session::has('success'))
    @include('admin.partials.success')
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('generals.info') }}</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <strong>Espositore {{$exhibitor->locale == 'it' ? 'Italiano' : 'Inglese'}}</strong> 
                    </div>
                    <form action="{{route('exhibitors.update', $exhibitor->id)}}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-6">
                                {{--<div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="already_download">{{__('forms.exhibitor_form.already_compiled', ['date' => date('Y') + 1])}}</label>
                                            <select class="form-control" id="already_download" name="already_download">
                                                <option value="no" {{ $exhibitor->already_download == 0 ? 'selected' : '' }}>{{__('generals.no')}}</option>
                                                <option value="yes" {{ $exhibitor->already_download == 1 ? 'selected' : '' }}>{{__('generals.yes')}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="already_expo">{{__('forms.exhibitor_form.already_expo')}}</label>
                                            <select class="form-control" id="already_expo" name="already_expo">
                                                <option value="no"  {{ $exhibitor->already_expo == 0 ? 'selected' : '' }}>{{__('generals.no')}}</option>
                                                <option value="yes" {{ $exhibitor->already_expo == 1 ? 'selected' : '' }}>{{__('generals.yes')}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="select_brand">* {{__('forms.exhibitor_form.interested_brand')}}</label>
                                            <select class="form-control" id="select_brand" name="select_brand" required>
                                                <option value="">{{__('forms.select_choice')}}</option>
                                                @foreach($stands_types as $stand_type)
                                                <option data-price="{{$stand_type->price}}" value="{{$stand_type->stand_type_id}}" {{ $exhibitor->stand_type_id == $stand_type->stand_type_id ? 'selected' : '' }}>{{$stand_type->name}} ({{trans('generals.mq').' '.$stand_type->size}})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" id="n_modules_selected" value="{{$exhibitor->n_modules}}">
                                            <label for="n_modules">* {{__('forms.exhibitor_form.n_modules')}}</label>
                                            <select id="n_modules" name="n_modules" class="form-control" required>
                                            </select>
                                        </div>
                                    </div>
                                </div>--}}
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">{{__('forms.exhibitor_form.company_data')}}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="company">* {{__('forms.exhibitor_form.exhibitor.company.name')}}</label>
                                            <input type="text" name="company" class="form-control w-100" value="{{ $exhibitor->company }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">* {{__('forms.exhibitor_form.exhibitor.company.address')}}</label>
                                            <input type="text" name="address" class="form-control w-100" value="{{ $exhibitor->address }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="civic_number">* {{__('forms.exhibitor_form.exhibitor.company.civic_number')}}</label>
                                            <input type="text" name="civic_number" class="form-control w-100" value="{{ $exhibitor->civic_number }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="city">* {{__('forms.exhibitor_form.exhibitor.company.city')}}</label>
                                            <input type="text" name="city" class="form-control w-100" value="{{ $exhibitor->city }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="cap">* {{__('forms.exhibitor_form.exhibitor.company.postal_code')}}</label>
                                            <input type="text" name="cap" class="form-control w-100" value="{{ $exhibitor->cap }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="province">* {{__('forms.exhibitor_form.exhibitor.company.province')}}</label>
                                            <input type="text" name="province" class="form-control w-100" value="{{ $exhibitor->province }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">* {{__('forms.exhibitor_form.exhibitor.company.phone')}}</label>
                                            <input type="text" name="phone" class="form-control w-100" value="{{ $exhibitor->phone }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="fax">{{__('forms.exhibitor_form.exhibitor.company.fax')}}</label>
                                            <input type="text" name="fax" class="form-control w-100" value="{{ $exhibitor->fax }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="web">{{__('forms.exhibitor_form.exhibitor.company.web')}}</label>
                                            <input type="text" name="web" class="form-control w-100" value="{{ $exhibitor->web }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="responsible">* {{__('forms.exhibitor_form.exhibitor.company.responsible')}}</label>
                                            <input type="text" name="responsible" class="form-control w-100" value="{{ $exhibitor->responsible }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="phone_responsible">* {{__('forms.exhibitor_form.exhibitor.company.responsible_phone')}}</label>
                                            <input type="text" name="phone_responsible" class="form-control w-100" value="{{ $exhibitor->phone_responsible }}" required>
                                        </div>
                                        {{--<div class="form-group">
                                            <label for="email_responsible">* {{__('forms.exhibitor_form.exhibitor.company.responsible_email')}}</label>
                                            <input type="email" name="email_responsible" class="form-control w-100" value="{{ $exhibitor->email_responsible }}" required>
                                        </div>--}}
                                        <div class="form-group">
                                            <label for="fiscal_code">{{__('forms.exhibitor_form.exhibitor.company.fiscal_code')}}</label>
                                            <input type="text" name="fiscal_code" class="form-control w-100" value="{{ $exhibitor->fiscal_code }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="vat_number">* {{__('forms.exhibitor_form.exhibitor.company.vat_number')}}</label>
                                            <input type="text" name="vat_number" class="form-control w-100" value="{{ $exhibitor->vat_number }}" required>
                                        </div>
                                        @if($exhibitor->locale == 'it')
                                        <div class="form-group">
                                            <label for="uni_code">* {{__('forms.exhibitor_form.exhibitor.company.uni_code')}}</label>
                                            <input type="text" name="uni_code" class="form-control w-100" value="{{ $exhibitor->uni_code }}" required>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            <label>{{__('forms.exhibitor_form.diff_billing')}}</label>
                                            <select class="form-control" id="diff_billing" name="diff_billing">
                                                <option value="no" {{ $exhibitor->diff_billing == 0 ? 'selected' : '' }}>{{__('generals.no')}}</option>
                                                <option value="yes" {{ $exhibitor->diff_billing == 1 ? 'selected' : '' }}>{{__('generals.yes')}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group" data-billing>
                                            <label for="receiver">{{__('forms.exhibitor_form.data_billing.heading')}}</label>
                                            <input type="text" name="receiver" class="form-control w-100" value="{{ $exhibitor->receiver }}">
                                        </div>
                                        <div class="form-group" data-billing>
                                            <label for="receiver_address">{{__('forms.exhibitor_form.data_billing.address')}}</label>
                                            <input type="text" name="receiver_address" class="form-control w-100" value="{{ $exhibitor->receiver_address }}">
                                        </div>
                                        <div class="form-group" data-billing>
                                            <label for="receiver_civic_number">{{__('forms.exhibitor_form.data_billing.civic_number')}}</label>
                                            <input type="text" name="receiver_civic_number" class="form-control w-100" value="{{ $exhibitor->receiver_civic_number }}">
                                        </div>
                                        <div class="form-group" data-billing>
                                            <label for="receiver_city">{{__('forms.exhibitor_form.data_billing.city')}}</label>
                                            <input type="text" name="receiver_city" class="form-control w-100" value="{{ $exhibitor->receiver_city }}">
                                        </div>
                                        <div class="form-group" data-billing>
                                            <label for="receiver_cap">{{__('forms.exhibitor_form.data_billing.postal_code')}}</label>
                                            <input type="text" name="receiver_cap" class="form-control w-100" value="{{ $exhibitor->receiver_cap }}">
                                        </div>
                                        <div class="form-group" data-billing>
                                            <label for="receiver_province">{{__('forms.exhibitor_form.data_billing.province')}}</label>
                                            <input type="text" name="receiver_province" class="form-control w-100" value="{{ $exhibitor->receiver_province }}">
                                        </div>
                                        <div class="form-group" data-billing>
                                            <label for="receiver_fiscal_code">{{__('forms.exhibitor_form.data_billing.fiscal_code')}}</label>
                                            <input type="text" name="receiver_fiscal_code" class="form-control w-100" value="{{ $exhibitor->receiver_fiscal_code }}">
                                        </div>
                                        <div class="form-group" data-billing>
                                            <label for="receiver_vat_number">{{__('forms.exhibitor_form.data_billing.vat_number')}}</label>
                                            <input type="text" name="receiver_vat_number" class="form-control w-100" value="{{ $exhibitor->receiver_vat_number }}">
                                        </div>
                                        @if($exhibitor->locale == 'it')
                                        <div class="form-group" data-billing>
                                            <label for="receiver_uni_code">{{__('forms.exhibitor_form.data_billing.uni_code')}}</label>
                                            <input type="text" name="receiver_uni_code" class="form-control w-100" value="{{ $exhibitor->receiver_uni_code }}">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <blockquote class="blockquote m-0">
                                    {{--
                                    <div class="form-group">
                                        <label>{{__('forms.exhibitor_form.acconto.tot')}}</label>
                                        <p class="text-lg">
                                            <span id="acconto_tot"></span>
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('forms.exhibitor_form.payment_mode.saldo_tot')}}</label>
                                        <p class="text-lg">
                                            <span id="saldo_tot"></span>
                                        </p>
                                    </div>
                                    div class="form-group">
                                        <label>{{__('forms.exhibitor_form.tot')}}</label>
                                        <p class="text-lg">
                                            <span id="tot">{{ $exhibitor->stand_price * $exhibitor->n_modules }}</span>
                                        </p>
                                    </div>--}}
                                    <div class="form-group">
                                        <h3 class="bg-success p-3">{{__('forms.exhibitor_form.privacy_accepted_at', ['hour' => \Carbon\Carbon::parse($exhibitor->created_at)->format('H:i:s'), 'day' => \Carbon\Carbon::parse($exhibitor->created_at)->format('d/m/Y') ])}}</h3>
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('forms.exhibitor_form.terms_conditions.stats')}}</label>
                                        <p class="text-lg">
                                            @if($exhibitor->accept_stats)
                                            <i class="far fa-check-circle text-green"></i>
                                            @else
                                            <i class="far fa-times-circle text-red"></i>
                                            @endif
                                            <span>{{ $exhibitor->accept_stats ? __('generals.yes') : __('generals.no') }}</span>
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label>{{__('forms.exhibitor_form.terms_conditions.marketing')}}</label>
                                        <p class="text-lg">
                                            @if($exhibitor->accept_marketing)
                                            <i class="far fa-check-circle text-green"></i>
                                            @else
                                            <i class="far fa-times-circle text-red"></i>
                                            @endif
                                            <span>{{ $exhibitor->accept_marketing ? __('generals.yes') : __('generals.no') }}</span>
                                        </p>
                                    </div>
                                </blockquote>
                            </div>
                            <div class="col-12 text-center">
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
@section('scripts')
<script>
    const resetCalcs = () => {
        $('#tot, #acconto_tot, #saldo_tot').text('')
    }
    const removeOptions = (select) => {
        $.each(select.find('option'), (index, value) => {
            $(value).remove()
        })
    }
    const resetModules = (select) => {
        removeOptions(select)
        resetCalcs()
    }
    const createModules = (select, n, selected) => {
        removeOptions(select)
        for(let i = 0; i < n; i++) {
            let opt = document.createElement('option')
            opt.text = i + 1;
            opt.value = i + 1;
            if(opt.value == selected){
                opt.selected = true
            }
            select.append(opt)
        }
    }
    const initModules = () => {
        common_request.post('/api/brand', {
            id: $('#select_brand').val()
        })
        .then(response => {
            let data = response.data
            if(data.status) {
                let result = data.object.price * parseInt($('#n_modules_selected').val());
                renderCalcs(result)
                createModules($('#n_modules'), data.object.max_number_modules, $('#n_modules_selected').val());
            } else {
                toastr.error(data.message)
            }
        })
        .catch(error => {
            toastr.error(error)
            console.log(error)
        })
    }
    const renderCalcs = (price) => {
        /*
        let formatPrice = parseFloat(price).toFixed(2)
        $('#tot').text(formatPrice)
        let acconto_price = parseFloat((price / 100) * 30).toFixed(2)
        let iva_acconto_price = 0;
        if($('input[name="locale"]').val() == 'it') {
            iva_acconto_price = parseFloat((acconto_price / 100) * 22).toFixed(2)
        }
        let tot_acconto_price = parseFloat(acconto_price) + parseFloat(iva_acconto_price)
        tot_acconto_price = tot_acconto_price.toFixed(2)
        $('#acconto_tot').text(tot_acconto_price)
        let saldo_price = parseFloat(price - acconto_price).toFixed(2)
        let iva_saldo_price = 0;
        if($('input[name="locale"]').val() == 'it') {
            iva_saldo_price = parseFloat((saldo_price / 100) * 22).toFixed(2)
        }
        let tot_saldo_price = parseFloat(saldo_price) + parseFloat(iva_saldo_price)
        tot_saldo_price = tot_saldo_price.toFixed(2)
        $('#saldo_tot').text(tot_saldo_price)
        */
        let formatPrice = parseFloat(price).toFixed(2)
        $('#tot').text(formatPrice)
        let acconto_price = parseFloat((price / 100) * 30).toFixed(2)
        $('#acconto_tot').text(acconto_price)
        let saldo_price = parseFloat(price - acconto_price).toFixed(2)
        $('#saldo_tot').text(saldo_price)
    }
    const admit = (exhibitor_id) => {
        Swal.fire({
            icon: 'info',
            title: "{!! trans('generals.confirm_admit') !!}",
            html: "{!! trans('generals.confirm_admit_text') !!}",
            showCancelButton: true,
            confirmButtonText: "{{ trans('generals.confirm') }}",
            cancelButtonText: "{{ trans('generals.cancel') }}",
        }).then((result) => {
            if (result.isConfirmed) {
                common_request.get('/admin/exhibitor/'+exhibitor_id+'/admit')
                .then(response => {
                    let data = response.data
                    if(data.status) {
                        $('#admitBtn').hide();
                        toastr.success(data.message)
                    } else {
                        toastr.error(data.message)
                    }
                })
                .catch(error => {
                    toastr.error(error)
                    console.log(error)
                })
            }
        })
    }
    $(document).ready(function() {
        /*
        renderCalcs($('#tot').text())
        initModules()
        */

        if($('#diff_billing').val() == 'no') {
            $('[data-billing]').addClass('d-none');
        }

        $('#diff_billing').on('change', function() {
            $('[data-billing]').toggleClass('d-none');
        });

        $('#select_brand').on('change', function() {
            let value = $(this).val();
            if(value.length > 0) {
                common_request.post('/api/brand', {
                    id: value
                })
                .then(response => {
                    let data = response.data
                    if(data.status) {
                        renderCalcs(data.object.price)
                        createModules($('#n_modules'), data.object.max_number_modules);
                    } else {
                        toastr.error(data.message)
                    }
                })
                .catch(error => {
                    toastr.error(error)
                    console.log(error)
                })
            } else {
                resetModules($('#n_modules'))
            }
        });

        $('#n_modules').on('change', function() {
            let value = $(this).val();
            if(value.length > 0) {
                let price = parseInt($('#select_brand').find(':selected').data('price'))
                let result = price * value;
                renderCalcs(result)
            } else {
                resetCalcs()
            }
        });
    });
</script>
@endsection