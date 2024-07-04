{{-- @extends('layouts.web')
@section('title', __('generals.form_compile_data'))
@section('title_header', __('generals.form_compile_data'))
@section('sub_header', __('generals.text_compile_data'))
@section('form')
    <form class="p-5 bg-white w-100">
        @csrf
        <input type="hidden" name="locale" value="{{ $locale }}">
        <div class="form-group">
            <h3>{{ __('forms.exhibitor_form.required_title') }}</h3>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{ __('forms.exhibitor_form.company_data') }}</h5>
            </div>
            <div class="card-body">
                <div class="row form-inline my-3">
                    <div class="form-group col-md-12">
                        <input type="text" name="company" class="form-control w-100"
                            placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.name') }}" required>
                    </div>
                </div>
                <div class="row form-inline mb-3">
                    <div class="form-group col-md-10">
                        <input type="text" name="address" class="form-control w-100"
                            placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.address') }}" required>
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" name="civic_number" class="form-control w-100"
                            placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.civic_number') }}" required>
                    </div>
                </div>
                <div class="row form-inline mb-3">
                    <div class="form-group col-md-6">
                        <input type="text" name="city" class="form-control w-100"
                            placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.city') }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" name="cap" class="form-control w-100"
                            placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.postal_code') }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" name="province" class="form-control w-100"
                            placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.province') }}" required>
                    </div>
                </div>
                <div class="row form-inline mb-3">
                    <div class="form-group col-md-3">
                        <input type="text" name="phone" class="form-control w-100"
                            placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.phone') }}" required>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" name="fax" class="form-control w-100"
                            placeholder="{{ __('forms.exhibitor_form.exhibitor.company.fax') }}">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" name="web" class="form-control w-100"
                            placeholder="{{ __('forms.exhibitor_form.exhibitor.company.web') }}">
                    </div>
                </div>
                <div class="row form-inline mb-3">
                    <div class="form-group col-md-6">
                        <input type="text" name="responsible" class="form-control w-100"
                            placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.responsible') }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" name="phone_responsible" class="form-control w-100"
                            placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.responsible_phone') }}" required>
                    </div>
                </div>
                <div class="row form-inline mb-3">
                    <div class="form-group col-md-4">
                        <input type="text" name="fiscal_code" class="form-control w-100"
                            placeholder="{{ __('forms.exhibitor_form.exhibitor.company.fiscal_code') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" name="vat_number" class="form-control w-100"
                            placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.vat_number') }}" required>
                    </div>
                    <div class="form-group col-md-4 {{ $locale == 'en' ? 'd-none' : '' }}">
                        <input type="text" name="uni_code" class="form-control w-100"
                            placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.uni_code') }}" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="diff_billing">{{ __('forms.exhibitor_form.diff_billing') }}</label>
            <select class="form-control" id="diff_billing" name="diff_billing">
                <option value="no" selected>{{ __('generals.no') }}</option>
                <option value="yes">{{ __('generals.yes') }}</option>
            </select>
        </div>
        <div class="card d-none" data-billing>
            <div class="card-header">
                <h5 class="card-title">{{ __('forms.exhibitor_form.data_billing.title') }}</h5>
            </div>
            <div class="card-body">
                <div class="row form-inline my-3">
                    <div class="form-group col-md-12">
                        <input type="text" name="receiver" class="form-control w-100"
                            placeholder="{{ __('forms.exhibitor_form.data_billing.heading') }}">
                    </div>
                </div>
                <div class="row form-inline mb-3">
                    <div class="form-group col-md-10">
                        <input type="text" name="receiver_address" class="form-control w-100"
                            placeholder="{{ __('forms.exhibitor_form.data_billing.address') }}">
                    </div>
                    <div class="form-group col-md-2">
                        <input type="text" name="receiver_civic_number" class="form-control w-100"
                            placeholder="{{ __('forms.exhibitor_form.data_billing.civic_number') }}">
                    </div>
                </div>
                <div class="row form-inline mb-3">
                    <div class="form-group col-md-6">
                        <input type="text" name="receiver_city" class="form-control w-100"
                            placeholder="{{ __('forms.exhibitor_form.data_billing.city') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" name="receiver_cap" class="form-control w-100"
                            placeholder="{{ __('forms.exhibitor_form.data_billing.postal_code') }}">
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" name="receiver_province" class="form-control w-100"
                            placeholder="{{ __('forms.exhibitor_form.data_billing.province') }}">
                    </div>
                </div>
                <div class="row form-inline mb-3">
                    <div class="form-group col-md-4">
                        <input type="text" name="receiver_fiscal_code" class="form-control w-100"
                            placeholder="{{ __('forms.exhibitor_form.data_billing.fiscal_code') }}">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" name="receiver_vat_number" class="form-control w-100"
                            placeholder="* {{ __('forms.exhibitor_form.data_billing.vat_number') }}">
                    </div>
                    <div class="form-group col-md-4 {{ $locale == 'en' ? 'd-none' : '' }}">
                        <input type="text" name="receiver_uni_code" class="form-control w-100"
                            placeholder="* {{ __('forms.exhibitor_form.data_billing.uni_code') }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-end">
            <button class="btn btn-primary btn-lg d-none spinner" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </button>
            <button type="submit" class="btn btn-primary btn-lg">{{ __('generals.save') }}</button>
        </div>
    </form>

@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            //console.log("{{ App::getLocale() }}")
            // let selected_lang = "{{ App::getLocale() }}"//$('a.nav-link.dropdown-toggle.text-uppercase').text();
            const selected_lang = $('input[name="locale"]').val()
            if (selected_lang.trim() == 'it') {
                $('input[name="uni_code"]').attr('required', true)
            } else {
                $('input[name="uni_code"]').removeAttr('required')
            }

            $('#diff_billing').on('change', function() {
                let $this = $(this)
                if ($this.val() == 'no') {
                    $.each($('[data-billing]').find('input'), function(index, element) {
                        $(element).val('')
                    })
                }
                // let selected_lang = "{{ App::getLocale() }}"//$('a.nav-link.dropdown-toggle.text-uppercase').text();
                $('[data-billing]').toggleClass('d-none');
                if ($(this).val() == 'yes') {
                    $('input[name="receiver_vat_number"]').attr('required', true)
                    if (selected_lang.trim() == 'it') {
                        $('input[name="receiver_uni_code"]').attr('required', true)
                    }
                } else {
                    $('input[name="receiver_vat_number"]').removeAttr('required')
                    if (selected_lang.trim() == 'it') {
                        $('input[name="receiver_uni_code"]').removeAttr('required')
                    }
                }
            });
            /* send form */
            $('form').on('submit', function(e) {
                e.preventDefault();
                $('form').find('button[type="submit"]').toggleClass('d-none');
                $('form').find('.spinner').toggleClass('d-none');
                // let selected_lang = "{{ App::getLocale() }}"//$('a.nav-link.dropdown-toggle.text-uppercase').text();
                common_request.post('/admin/exhibitors/compile-data', {
                        company: $('input[name="company"]').val(),
                        address: $('input[name="address"]').val(),
                        civic_number: $('input[name="civic_number"]').val(),
                        city: $('input[name="city"]').val(),
                        cap: $('input[name="cap"]').val(),
                        province: $('input[name="province"]').val(),
                        phone: $('input[name="phone"]').val(),
                        fax: $('input[name="fax"]').val(),
                        web: $('input[name="web"]').val(),
                        responsible: $('input[name="responsible"]').val(),
                        phone_responsible: $('input[name="phone_responsible"]').val(),
                        fiscal_code: $('input[name="fiscal_code"]').val(),
                        vat_number: $('input[name="vat_number"]').val(),
                        uni_code: $('input[name="uni_code"]').val(),
                        diff_billing: $('#diff_billing').val() == 'yes' ? 1 : 0,
                        receiver: $('input[name="receiver"]').val(),
                        receiver_address: $('input[name="receiver_address"]').val(),
                        receiver_civic_number: $('input[name="receiver_civic_number"]').val(),
                        receiver_city: $('input[name="receiver_city"]').val(),
                        receiver_cap: $('input[name="receiver_cap"]').val(),
                        receiver_province: $('input[name="receiver_province"]').val(),
                        receiver_fiscal_code: $('input[name="receiver_fiscal_code"]').val(),
                        receiver_vat_number: $('input[name="receiver_vat_number"]').val(),
                        receiver_uni_code: $('input[name="receiver_uni_code"]').val(),
                        accept_stats: 1, //$('input[name="accept_stats"]:checked').val() == 'yes' ? 1 : 0,
                        accept_marketing: 1, //$('input[name="accept_marketing"]:checked').val() == 'yes' ? 1 : 0,
                        locale: selected_lang.trim()
                    })
                    .then(response => {
                        let data = response.data
                        if (data.status) {
                            Swal.fire({
                                icon: 'success',
                                title: data.message
                            }).then(() => {
                                $('form').find('button[type="submit"]').remove();
                                $('form').find('.spinner').remove();
                                window.location = "{{ route('login') }}"
                            })
                        } else {
                            $('form').find('button[type="submit"]').toggleClass('d-none');
                            $('form').find('.spinner').toggleClass('d-none');
                            toastr.error(data.message, {
                                allowHtml: true
                            })
                        }
                    })
                    .catch(error => {
                        $('form').find('button[type="submit"]').toggleClass('d-none');
                        $('form').find('.spinner').toggleClass('d-none');
                        toastr.error(error)
                        console.log(error)
                    })

            });
        });
    </script>
@endsection
 --}}

@extends('layouts/webLayout')
@section('title', __('generals.form_compile_data'))
@section('title_header', __('generals.form_compile_data'))
@section('sub_header', __('generals.text_compile_data'))
@section('form')
    <div class="row">
        <div class="col">
            <div class="card pb-3">
                <form class="">
                    @csrf
                    <input type="hidden" name="locale" value="{{ $locale }}">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('forms.exhibitor_form.company_data') }}</h3>
                        <h5 class="card-subtitle text-muted">{{ __('forms.exhibitor_form.required_title') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row form-inline my-3">
                            <div class="form-group col-md-12">
                                <input type="text" name="company" class="form-control w-100"
                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.name') }}" required>
                            </div>
                        </div>
                        <div class="row form-inline mb-3">
                            <div class="form-group col-md-10">
                                <input type="text" name="address" class="form-control w-100"
                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.address') }}" required>
                            </div>
                            <div class="form-group col-md-2">
                                <input type="text" name="civic_number" class="form-control w-100"
                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.civic_number') }}"
                                    required>
                            </div>
                        </div>
                        <div class="row form-inline mb-3">
                            <div class="form-group col-md-6">
                                <input type="text" name="city" class="form-control w-100"
                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.city') }}" required>
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" name="cap" class="form-control w-100"
                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.postal_code') }}" required>
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" name="province" class="form-control w-100"
                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.province') }}" required>
                            </div>
                        </div>
                        <div class="row form-inline mb-3">
                            <div class="form-group col-md-3">
                                <input type="text" name="phone" class="form-control w-100"
                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.phone') }}" required>
                            </div>
                            <div class="form-group col-md-3">
                                <input type="text" name="fax" class="form-control w-100"
                                    placeholder="{{ __('forms.exhibitor_form.exhibitor.company.fax') }}">
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="web" class="form-control w-100"
                                    placeholder="{{ __('forms.exhibitor_form.exhibitor.company.web') }}">
                            </div>
                        </div>
                        <div class="row form-inline mb-3">
                            <div class="form-group col-md-6">
                                <input type="text" name="responsible" class="form-control w-100"
                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.responsible') }}"
                                    required>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" name="phone_responsible" class="form-control w-100"
                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.responsible_phone') }}"
                                    required>
                            </div>
                        </div>
                        <div class="row form-inline mb-3">
                            <div class="form-group col-md-4">
                                <input type="text" name="fiscal_code" class="form-control w-100"
                                    placeholder="{{ __('forms.exhibitor_form.exhibitor.company.fiscal_code') }}">
                            </div>
                            <div class="form-group col-md-4">
                                <input type="text" name="vat_number" class="form-control w-100"
                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.vat_number') }}" required>
                            </div>
                            <div class="form-group col-md-4 {{ $locale == 'en' ? 'd-none' : '' }}">
                                <input type="text" name="uni_code" class="form-control w-100"
                                    placeholder="* {{ __('forms.exhibitor_form.exhibitor.company.uni_code') }}" required>
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="diff_billing">{{ __('forms.exhibitor_form.diff_billing') }}</label>
                        <select class="form-control" id="diff_billing" name="diff_billing">
                            <option value="no" selected>{{ __('generals.no') }}</option>
                            <option value="yes">{{ __('generals.yes') }}</option>
                        </select>
                    </div>
                    <div class="d-none" data-billing>
                        <div class="card-header pyt-1">
                            <h5 class="card-title">{{ __('forms.exhibitor_form.data_billing.title') }}</h5>
                        </div>
                        <div class="card-body pt-1">
                            <div class="row form-inline my-3">
                                <div class="form-group col-md-12">
                                    <input type="text" name="receiver" class="form-control w-100"
                                        placeholder="{{ __('forms.exhibitor_form.data_billing.heading') }}">
                                </div>
                            </div>
                            <div class="row form-inline mb-3">
                                <div class="form-group col-md-10">
                                    <input type="text" name="receiver_address" class="form-control w-100"
                                        placeholder="{{ __('forms.exhibitor_form.data_billing.address') }}">
                                </div>
                                <div class="form-group col-md-2">
                                    <input type="text" name="receiver_civic_number" class="form-control w-100"
                                        placeholder="{{ __('forms.exhibitor_form.data_billing.civic_number') }}">
                                </div>
                            </div>
                            <div class="row form-inline mb-3">
                                <div class="form-group col-md-6">
                                    <input type="text" name="receiver_city" class="form-control w-100"
                                        placeholder="{{ __('forms.exhibitor_form.data_billing.city') }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" name="receiver_cap" class="form-control w-100"
                                        placeholder="{{ __('forms.exhibitor_form.data_billing.postal_code') }}">
                                </div>
                                <div class="form-group col-md-3">
                                    <input type="text" name="receiver_province" class="form-control w-100"
                                        placeholder="{{ __('forms.exhibitor_form.data_billing.province') }}">
                                </div>
                            </div>
                            <div class="row form-inline mb-3">
                                <div class="form-group col-md-4">
                                    <input type="text" name="receiver_fiscal_code" class="form-control w-100"
                                        placeholder="{{ __('forms.exhibitor_form.data_billing.fiscal_code') }}">
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="text" name="receiver_vat_number" class="form-control w-100"
                                        placeholder="* {{ __('forms.exhibitor_form.data_billing.vat_number') }}">
                                </div>
                                <div class="form-group col-md-4 {{ $locale == 'en' ? 'd-none' : '' }}">
                                    <input type="text" name="receiver_uni_code" class="form-control w-100"
                                        placeholder="* {{ __('forms.exhibitor_form.data_billing.uni_code') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="d-flex align-items-center justify-content-end">
                                <button class="btn btn-primary btn-lg d-none spinner" type="button" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                </button>
                                <button type="submit"
                                    class="btn btn-primary btn-lg me-sm-3 me-1">{{ __('generals.save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const selectedLang = document.querySelector('input[name="locale"]').value.trim();

            if (selectedLang === 'it') {
                document.querySelector('input[name="uni_code"]').required = true;
            } else {
                document.querySelector('input[name="uni_code"]').required = false;
            }

            document.querySelector('#diff_billing').addEventListener('change', (e) => {
                const $this = e.target;
                if ($this.value === 'no') {
                    Array.prototype.forEach.call(document.querySelectorAll('[data-billing] input'), (
                        element) => {
                        element.value = '';
                    });
                }
                document.querySelector('[data-billing]').classList.toggle('d-none');
                if ($this.value === 'yes') {
                    document.querySelector('input[name="receiver_vat_number"]').required = true;
                    if (selectedLang === 'it') {
                        document.querySelector('input[name="receiver_uni_code"]').required = true;
                    }
                } else {
                    document.querySelector('input[name="receiver_vat_number"]').required = false;
                    if (selectedLang === 'it') {
                        document.querySelector('input[name="receiver_uni_code"]').required = false;
                    }
                }
            });

            const form = document.querySelector('form');
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                form.querySelector('button[type="submit"]').classList.toggle('d-none');
                form.querySelector('.spinner').classList.toggle('d-none');
                const formData = {
                    company: document.querySelector('input[name="company"]').value,
                    address: document.querySelector('input[name="address"]').value,
                    civic_number: document.querySelector('input[name="civic_number"]')
                        .value,
                    city: document.querySelector('input[name="city"]').value,
                    cap: document.querySelector('input[name="cap"]').value,
                    province: document.querySelector('input[name="province"]').value,
                    phone: document.querySelector('input[name="phone"]').value,
                    fax: document.querySelector('input[name="fax"]').value,
                    web: document.querySelector('input[name="web"]').value,
                    responsible: document.querySelector('input[name="responsible"]')
                        .value,
                    phone_responsible: document.querySelector(
                        'input[name="phone_responsible"]').value,
                    fiscal_code: document.querySelector('input[name="fiscal_code"]')
                        .value,
                    vat_number: document.querySelector('input[name="vat_number"]')
                        .value,
                    uni_code: document.querySelector('input[name="uni_code"]').value,
                    diff_billing: document.querySelector('#diff_billing').value ===
                        'yes' ? 1 : 0,
                    receiver: document.querySelector('input[name="receiver"]').value,
                    receiver_address: document.querySelector(
                        'input[name="receiver_address"]').value,
                    receiver_civic_number: document.querySelector(
                        'input[name="receiver_civic_number"]').value,
                    receiver_city: document.querySelector('input[name="receiver_city"]')
                        .value,
                    receiver_cap: document.querySelector('input[name="receiver_cap"]')
                        .value,
                    receiver_province: document.querySelector(
                        'input[name="receiver_province"]').value,
                    receiver_fiscal_code: document.querySelector(
                        'input[name="receiver_fiscal_code"]').value,
                    receiver_vat_number: document.querySelector(
                        'input[name="receiver_vat_number"]').value,
                    receiver_uni_code: document.querySelector(
                        'input[name="receiver_uni_code"]').value,
                    accept_stats: 1, //document.querySelector('input[name="accept_stats"]:checked').value === 'yes'? 1 : 0,
                    accept_marketing: 1, //document.querySelector('input[name="accept_marketing"]:checked').value === 'yes'? 1 : 0,
                    locale: selectedLang
                }
                common_request.post('/admin/exhibitors/compile-data', formData).then(response => {
                    const data = response.data;
                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: data.message
                        }).then(() => {
                            form.querySelector('button[type="submit"]').remove();
                            form.querySelector('.spinner').remove();
                            window.location = "{{ route('login') }}";
                        });
                    } else {
                        form.querySelector('button[type="submit"]').classList.toggle('d-none');
                        form.querySelector('.spinner').classList.toggle('d-none');
                        toastr.error(data.message, {
                            allowHtml: true
                        });
                    }
                }).catch(error => {
                    form.querySelector('button[type="submit"]').classList.toggle('d-none');
                    form.querySelector('.spinner').classList.toggle('d-none');
                    toastr.error(error);
                    console.error(error);
                });
            });
        });
    </script>
@endsection
