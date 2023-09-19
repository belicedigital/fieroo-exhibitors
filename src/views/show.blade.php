@extends('layouts.app')
@section('title', trans('entities.exhibitor').' '.$exhibitor->company)
@section('title_header', trans('entities.exhibitor').' '.$exhibitor->company)
@section('buttons')
<a href="{{url('admin/exhibitors')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.back')}}"><i class="fas fa-chevron-left"></i></a>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">{{ trans('generals.info') }}</h5>
                </div>
                <div class="card-body">
                    @if($exhibitor->created_at != $exhibitor->updated_at)
                    <div class="alert alert-info">
                        <strong>{{trans('generals.last_updt')}} {{ \Carbon\Carbon::parse($exhibitor->updated_at)->format('d/m/Y H:i:s') }}</strong> 
                    </div>
                    @endif
                    <div class="alert alert-info">
                        <strong>{{trans('entities.exhibitor')}} {{$exhibitor->locale == 'it' ? 'Italiano' : 'Inglese'}}</strong> 
                    </div>
                    <form>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6">
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
                                <div class="form-group">
                                    <label for="company">* {{__('forms.exhibitor_form.exhibitor.company.name')}}</label>
                                    <input type="text" name="company" class="form-control w-100" value="{{ $exhibitor->company }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="address">* {{__('forms.exhibitor_form.exhibitor.company.address')}}</label>
                                    <input type="text" name="address" class="form-control w-100" value="{{ $exhibitor->address }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="civic_number">* {{__('forms.exhibitor_form.exhibitor.company.civic_number')}}</label>
                                    <input type="text" name="civic_number" class="form-control w-100" value="{{ $exhibitor->civic_number }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="city">* {{__('forms.exhibitor_form.exhibitor.company.city')}}</label>
                                    <input type="text" name="city" class="form-control w-100" value="{{ $exhibitor->city }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="cap">* {{__('forms.exhibitor_form.exhibitor.company.postal_code')}}</label>
                                    <input type="text" name="cap" class="form-control w-100" value="{{ $exhibitor->cap }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="province">* {{__('forms.exhibitor_form.exhibitor.company.province')}}</label>
                                    <input type="text" name="province" class="form-control w-100" value="{{ $exhibitor->province }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="phone">* {{__('forms.exhibitor_form.exhibitor.company.phone')}}</label>
                                    <input type="text" name="phone" class="form-control w-100" value="{{ $exhibitor->phone }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="fax">{{__('forms.exhibitor_form.exhibitor.company.fax')}}</label>
                                    <input type="text" name="fax" class="form-control w-100" value="{{ $exhibitor->fax }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="web">{{__('forms.exhibitor_form.exhibitor.company.web')}}</label>
                                    <input type="text" name="web" class="form-control w-100" value="{{ $exhibitor->web }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="responsible">* {{__('forms.exhibitor_form.exhibitor.company.responsible')}}</label>
                                    <input type="text" name="responsible" class="form-control w-100" value="{{ $exhibitor->responsible }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="phone_responsible">* {{__('forms.exhibitor_form.exhibitor.company.responsible_phone')}}</label>
                                    <input type="text" name="phone_responsible" class="form-control w-100" value="{{ $exhibitor->phone_responsible }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="email_responsible">* {{__('forms.exhibitor_form.exhibitor.company.responsible_email')}}</label>
                                    <input type="email" name="email_responsible" class="form-control w-100" value="{{ $exhibitor->email_responsible }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="fiscal_code">{{__('forms.exhibitor_form.exhibitor.company.fiscal_code')}}</label>
                                    <input type="text" name="fiscal_code" class="form-control w-100" value="{{ $exhibitor->fiscal_code }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="vat_number">* {{__('forms.exhibitor_form.exhibitor.company.vat_number')}}</label>
                                    <input type="text" name="vat_number" class="form-control w-100" value="{{ $exhibitor->vat_number }}" readonly>
                                </div>
                                @if($exhibitor->locale == 'it')
                                <div class="form-group">
                                    <label for="uni_code">* {{__('forms.exhibitor_form.exhibitor.company.uni_code')}}</label>
                                    <input type="text" name="uni_code" class="form-control w-100" value="{{ $exhibitor->uni_code }}" readonly>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label>{{__('forms.exhibitor_form.diff_billing')}}</label>
                                    <select class="form-control" id="diff_billing" name="diff_billing" readonly disabled>
                                        <option value="no" {{ $exhibitor->diff_billing == 0 ? 'selected' : '' }}>{{__('generals.no')}}</option>
                                        <option value="yes" {{ $exhibitor->diff_billing == 1 ? 'selected' : '' }}>{{__('generals.yes')}}</option>
                                    </select>
                                </div>
                                <div class="form-group" data-billing>
                                    <label for="receiver">{{__('forms.exhibitor_form.data_billing.heading')}}</label>
                                    <input type="text" name="receiver" class="form-control w-100" value="{{ $exhibitor->receiver }}" readonly>
                                </div>
                                <div class="form-group" data-billing>
                                    <label for="receiver_address">{{__('forms.exhibitor_form.data_billing.address')}}</label>
                                    <input type="text" name="receiver_address" class="form-control w-100" value="{{ $exhibitor->receiver_address }}" readonly>
                                </div>
                                <div class="form-group" data-billing>
                                    <label for="receiver_civic_number">{{__('forms.exhibitor_form.data_billing.civic_number')}}</label>
                                    <input type="text" name="receiver_civic_number" class="form-control w-100" value="{{ $exhibitor->receiver_civic_number }}" readonly>
                                </div>
                                <div class="form-group" data-billing>
                                    <label for="receiver_city">{{__('forms.exhibitor_form.data_billing.city')}}</label>
                                    <input type="text" name="receiver_city" class="form-control w-100" value="{{ $exhibitor->receiver_city }}" readonly>
                                </div>
                                <div class="form-group" data-billing>
                                    <label for="receiver_cap">{{__('forms.exhibitor_form.data_billing.postal_code')}}</label>
                                    <input type="text" name="receiver_cap" class="form-control w-100" value="{{ $exhibitor->receiver_cap }}" readonly>
                                </div>
                                <div class="form-group" data-billing>
                                    <label for="receiver_province">{{__('forms.exhibitor_form.data_billing.province')}}</label>
                                    <input type="text" name="receiver_province" class="form-control w-100" value="{{ $exhibitor->receiver_province }}" readonly>
                                </div>
                                <div class="form-group" data-billing>
                                    <label for="receiver_fiscal_code">{{__('forms.exhibitor_form.data_billing.fiscal_code')}}</label>
                                    <input type="text" name="receiver_fiscal_code" class="form-control w-100" value="{{ $exhibitor->receiver_fiscal_code }}" readonly>
                                </div>
                                <div class="form-group" data-billing>
                                    <label for="receiver_vat_number">{{__('forms.exhibitor_form.data_billing.vat_number')}}</label>
                                    <input type="text" name="receiver_vat_number" class="form-control w-100" value="{{ $exhibitor->receiver_vat_number }}" readonly>
                                </div>
                                @if($exhibitor->locale == 'it')
                                <div class="form-group" data-billing>
                                    <label for="receiver_uni_code">{{__('forms.exhibitor_form.data_billing.uni_code')}}</label>
                                    <input type="text" name="receiver_uni_code" class="form-control w-100" value="{{ $exhibitor->receiver_uni_code }}" readonly>
                                </div>
                                @endif
                                <div class="form-group">
                                    <h3>{{__('forms.exhibitor_form.privacy_accepted_at', ['hour' => \Carbon\Carbon::parse($exhibitor->created_at)->format('H:i:s'), 'day' => \Carbon\Carbon::parse($exhibitor->created_at)->format('d/m/Y') ])}}</h3>
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
    $(document).ready(function() {
        if($('#diff_billing').val() == 'no') {
            $('[data-billing]').addClass('d-none');
        }

        $('#diff_billing').on('change', function() {
            $('[data-billing]').toggleClass('d-none');
        });
    });
</script>
@endsection