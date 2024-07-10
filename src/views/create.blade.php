{{-- @extends('layouts.app')
@section('title', trans('crud.new', ['obj' => trans('entities.exhibitor')]))
@section('title_header', trans('crud.new', ['obj' => trans('entities.exhibitor')]))
@section('buttons')
<a href="{{url('admin/exhibitors')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.back')}}"><i class="fas fa-chevron-left"></i></a>
@endsection
@section('content')
<div class="container">
    @if ($errors->any())
    @include('admin.partials.errors', ['errors' => $errors])
    @endif
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{route('exhibitors.store')}}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="locale">{{__('forms.locale')}}</label>
                                            <select class="form-control" id="locale" name="locale">
                                                <option value="it" selected>{{__('IT')}}</option>
                                                <option value="en">{{__('EN')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">{{__('forms.exhibitor_form.company_data')}}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row form-inline my-3">
                                            <div class="form-group col-md-12">
                                                <input type="text" name="company" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.name')}}" required value="{{ old('company') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-10">
                                                <input type="text" name="address" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.address')}}" required value="{{ old('address') }}">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input type="text" name="civic_number" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.civic_number')}}" required value="{{ old('civic_number') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-6">
                                                <input type="text" name="city" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.city')}}" required value="{{ old('city') }}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="text" name="cap" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.postal_code')}}" required value="{{ old('cap') }}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="text" name="province" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.province')}}" required value="{{ old('province') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-3">
                                                <input type="text" name="phone" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.phone')}}" required value="{{ old('phone') }}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="text" name="fax" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.exhibitor.company.fax')}}" value="{{ old('fax') }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text" name="web" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.exhibitor.company.web')}}" value="{{ old('web') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-6">
                                                <input type="text" name="responsible" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.responsible')}}" required value="{{ old('responsible') }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text" name="phone_responsible" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.responsible_phone')}}" required value="{{ old('phone_responsible') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-6">
                                                <input type="email" name="email_responsible" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.responsible_email')}}" required value="{{ old('email_responsible') }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="email" name="email_responsible_confirmation" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.responsible_email_confirm')}}" required value="{{ old('email_responsible_confirmation') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-4">
                                                <input type="text" name="fiscal_code" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.exhibitor.company.fiscal_code')}}" value="{{ old('fiscal_code') }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="vat_number" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.vat_number')}}" required value="{{ old('vat_number') }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="uni_code" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.uni_code')}}" required value="{{ old('uni_code') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="diff_billing">{{__('forms.exhibitor_form.diff_billing')}}</label>
                                            <select class="form-control" id="diff_billing" name="diff_billing">
                                                <option value="no" selected>{{__('generals.no')}}</option>
                                                <option value="yes">{{__('generals.yes')}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card d-none" data-billing>
                                    <div class="card-header">
                                        <h5 class="card-title">{{__('forms.exhibitor_form.data_billing.title')}}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row form-inline my-3">
                                            <div class="form-group col-md-12">
                                                <input type="text" name="receiver" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.heading')}}" value="{{ old('receiver') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-10">
                                                <input type="text" name="receiver_address" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.address')}}" value="{{ old('receiver_address') }}">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input type="text" name="receiver_civic_number" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.civic_number')}}" value="{{ old('receiver_civic_number') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-6">
                                                <input type="text" name="receiver_city" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.city')}}" value="{{ old('receiver_city') }}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="text" name="receiver_cap" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.postal_code')}}" value="{{ old('receiver_cap') }}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="text" name="receiver_province" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.province')}}" value="{{ old('receiver_province') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-4">
                                                <input type="text" name="receiver_fiscal_code" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.fiscal_code')}}" value="{{ old('receiver_fiscal_code') }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="receiver_vat_number" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.vat_number')}}" value="{{ old('receiver_vat_number') }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="receiver_uni_code" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.uni_code')}}" value="{{ old('receiver_uni_code') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <blockquote class="blockquote m-0">
                                    <p class="mb-0">{!! $form_radio_text_1 !!}</p>
                                    <footer class="blockquote-footer">
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="accept_stats" id="accept_stats_yes" value="yes" checked>
                                                <label class="form-check-label" for="accept_stats_yes">{{__('forms.exhibitor_form.terms_conditions.yes')}}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="accept_stats" id="accept_stats_no" value="no">
                                                <label class="form-check-label" for="accept_stats_no">{{__('forms.exhibitor_form.terms_conditions.no')}}</label>
                                            </div>
                                        </div>
                                    </footer>
                                </blockquote>
                                <blockquote class="blockquote m-0">
                                    <p class="mb-0">{!! $form_radio_text_2 !!}</p>
                                    <footer class="blockquote-footer">
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="accept_marketing" id="accept_marketing_yes" value="yes" checked>
                                                <label class="form-check-label" for="accept_marketing_yes">{{__('forms.exhibitor_form.terms_conditions.yes')}}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="accept_marketing" id="accept_marketing_no" value="no">
                                                <label class="form-check-label" for="accept_marketing_no">{{__('forms.exhibitor_form.terms_conditions.no')}}</label>
                                            </div>
                                        </div>
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">{{trans('generals.save')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#diff_billing').on('change', function() {
            $('[data-billing]').toggleClass('d-none');
        });
    });
</script>
@endsection --}}

@extends('layouts/layoutMaster')

@section('title', trans('crud.new', ['obj' => trans('entities.exhibitor')]))
@section('title_header', trans('crud.new', ['obj' => trans('entities.exhibitor')]))

@section('button')
    <a href="{{ url('admin/exhibitors') }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ trans('generals.back') }}"><i class="fas fa-chevron-left"></i></a>
    {{-- <a href="{{ url('admin/exhibitors') }}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom"
        title="{{ trans('generals.back') }}"><i class="fas fa-chevron-left"></i></a> --}}
@endsection

@section('path', trans('entities.exhibitors'))
@section('current', trans('crud.new', ['obj' => trans('entities.exhibitor')]))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form action="{{ route('exhibitors.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="locale">{{ __('forms.locale') }}</label>
                                            <select class="form-control" id="locale" name="locale">
                                                <option value="it" selected>{{ __('IT') }}</option>
                                                <option value="en">{{ __('EN') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">{{ __('forms.exhibitor_form.company_data') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row form-inline my-3">
                                            <div class="form-group col-md-12">
                                                <input type="text" name="company" class="form-control w-100"
                                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.name') }}"
                                                    required value="{{ old('company') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-10">
                                                <input type="text" name="address" class="form-control w-100"
                                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.address') }}"
                                                    required value="{{ old('address') }}">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input type="text" name="civic_number" class="form-control w-100"
                                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.civic_number') }}"
                                                    required value="{{ old('civic_number') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-6">
                                                <input type="text" name="city" class="form-control w-100"
                                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.city') }}"
                                                    required value="{{ old('city') }}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="text" name="cap" class="form-control w-100"
                                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.postal_code') }}"
                                                    required value="{{ old('cap') }}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="text" name="province" class="form-control w-100"
                                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.province') }}"
                                                    required value="{{ old('province') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-3">
                                                <input type="text" name="phone" class="form-control w-100"
                                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.phone') }}"
                                                    required value="{{ old('phone') }}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="text" name="fax" class="form-control w-100"
                                                    placeholder="{{ __('forms.exhibitor_form.exhibitor.company.fax') }}"
                                                    value="{{ old('fax') }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text" name="web" class="form-control w-100"
                                                    placeholder="{{ __('forms.exhibitor_form.exhibitor.company.web') }}"
                                                    value="{{ old('web') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-6">
                                                <input type="text" name="responsible" class="form-control w-100"
                                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.responsible') }}"
                                                    required value="{{ old('responsible') }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="text" name="phone_responsible" class="form-control w-100"
                                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.responsible_phone') }}"
                                                    required value="{{ old('phone_responsible') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-6">
                                                <input type="email" name="email_responsible" class="form-control w-100"
                                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.responsible_email') }}"
                                                    required value="{{ old('email_responsible') }}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <input type="email" name="email_responsible_confirmation"
                                                    class="form-control w-100"
                                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.responsible_email_confirm') }}"
                                                    required value="{{ old('email_responsible_confirmation') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-4">
                                                <input type="text" name="fiscal_code" class="form-control w-100"
                                                    placeholder="{{ __('forms.exhibitor_form.exhibitor.company.fiscal_code') }}"
                                                    value="{{ old('fiscal_code') }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="vat_number" class="form-control w-100"
                                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.vat_number') }}"
                                                    required value="{{ old('vat_number') }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="uni_code" class="form-control w-100"
                                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.uni_code') }}"
                                                    required value="{{ old('uni_code') }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label
                                                for="diff_billing">{{ __('forms.exhibitor_form.diff_billing') }}</label>
                                            <select class="form-control" id="diff_billing" name="diff_billing">
                                                <option value="no" selected>{{ __('generals.no') }}</option>
                                                <option value="yes">{{ __('generals.yes') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card d-none" data-billing>
                                    <div class="card-header">
                                        <h5 class="card-title">{{ __('forms.exhibitor_form.data_billing.title') }}
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row form-inline my-3">
                                            <div class="form-group col-md-12">
                                                <input type="text" name="receiver" class="form-control w-100"
                                                    placeholder="{{ __('forms.exhibitor_form.data_billing.heading') }}"
                                                    value="{{ old('receiver') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-10">
                                                <input type="text" name="receiver_address" class="form-control w-100"
                                                    placeholder="{{ __('forms.exhibitor_form.data_billing.address') }}"
                                                    value="{{ old('receiver_address') }}">
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input type="text" name="receiver_civic_number"
                                                    class="form-control w-100"
                                                    placeholder="{{ __('forms.exhibitor_form.data_billing.civic_number') }}"
                                                    value="{{ old('receiver_civic_number') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-6">
                                                <input type="text" name="receiver_city" class="form-control w-100"
                                                    placeholder="{{ __('forms.exhibitor_form.data_billing.city') }}"
                                                    value="{{ old('receiver_city') }}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="text" name="receiver_cap" class="form-control w-100"
                                                    placeholder="{{ __('forms.exhibitor_form.data_billing.postal_code') }}"
                                                    value="{{ old('receiver_cap') }}">
                                            </div>
                                            <div class="form-group col-md-3">
                                                <input type="text" name="receiver_province" class="form-control w-100"
                                                    placeholder="{{ __('forms.exhibitor_form.data_billing.province') }}"
                                                    value="{{ old('receiver_province') }}">
                                            </div>
                                        </div>
                                        <div class="row form-inline mb-3">
                                            <div class="form-group col-md-4">
                                                <input type="text" name="receiver_fiscal_code"
                                                    class="form-control w-100"
                                                    placeholder="{{ __('forms.exhibitor_form.data_billing.fiscal_code') }}"
                                                    value="{{ old('receiver_fiscal_code') }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="receiver_vat_number"
                                                    class="form-control w-100"
                                                    placeholder="{{ __('forms.exhibitor_form.data_billing.vat_number') }}"
                                                    value="{{ old('receiver_vat_number') }}">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <input type="text" name="receiver_uni_code" class="form-control w-100"
                                                    placeholder="{{ __('forms.exhibitor_form.data_billing.uni_code') }}"
                                                    value="{{ old('receiver_uni_code') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <blockquote class="blockquote m-0">
                                    <p class="mb-0">{!! $form_radio_text_1 !!}</p>
                                    <footer class="blockquote-footer">
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="accept_stats"
                                                    id="accept_stats_yes" value="yes" checked>
                                                <label class="form-check-label"
                                                    for="accept_stats_yes">{{ __('forms.exhibitor_form.terms_conditions.yes') }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="accept_stats"
                                                    id="accept_stats_no" value="no">
                                                <label class="form-check-label"
                                                    for="accept_stats_no">{{ __('forms.exhibitor_form.terms_conditions.no') }}</label>
                                            </div>
                                        </div>
                                    </footer>
                                </blockquote>
                                <blockquote class="blockquote m-0">
                                    <p class="mb-0">{!! $form_radio_text_2 !!}</p>
                                    <footer class="blockquote-footer">
                                        <div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="accept_marketing"
                                                    id="accept_marketing_yes" value="yes" checked>
                                                <label class="form-check-label"
                                                    for="accept_marketing_yes">{{ __('forms.exhibitor_form.terms_conditions.yes') }}</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="accept_marketing"
                                                    id="accept_marketing_no" value="no">
                                                <label class="form-check-label"
                                                    for="accept_marketing_no">{{ __('forms.exhibitor_form.terms_conditions.no') }}</label>
                                            </div>
                                        </div>
                                    </footer>
                                </blockquote>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                <button type="submit" class="btn btn-primary">{{ trans('generals.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('page-script')
    <script>
        $(document).ready(function() {
            $('#diff_billing').on('change', function() {
                $('[data-billing]').toggleClass('d-none');
            });
        });
    </script>
@endsection
