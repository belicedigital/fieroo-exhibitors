@extends('layouts.web')
@section('title', __('generals.form_compile_data'))
@section('title_header', __('generals.form_compile_data'))
@section('sub_header', __('generals.text_compile_data'))
@section('form')
<form class="p-5 bg-white w-100">
    @csrf
    <div class="form-group">
        <h3>{{__('forms.exhibitor_form.required_title')}}</h3>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">{{__('forms.exhibitor_form.company_data')}}</h5>
        </div>
        <div class="card-body">
            <div class="row form-inline my-3">
                <div class="form-group col-md-12">
                    <input type="text" name="company" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.name')}}" required>
                </div>
            </div>
            <div class="row form-inline mb-3">
                <div class="form-group col-md-10">
                    <input type="text" name="address" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.address')}}" required>
                </div>
                <div class="form-group col-md-2">
                    <input type="text" name="civic_number" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.civic_number')}}" required>
                </div>
            </div>
            <div class="row form-inline mb-3">
                <div class="form-group col-md-6">
                    <input type="text" name="city" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.city')}}" required>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" name="cap" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.postal_code')}}" required>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" name="province" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.province')}}" required>
                </div>
            </div>
            <div class="row form-inline mb-3">
                <div class="form-group col-md-3">
                    <input type="text" name="phone" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.phone')}}" required>
                </div>
                <div class="form-group col-md-3">
                    <input type="text" name="fax" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.exhibitor.company.fax')}}">
                </div>
                <div class="form-group col-md-6">
                    <input type="text" name="web" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.exhibitor.company.web')}}">
                </div>
            </div>
            <div class="row form-inline mb-3">
                <div class="form-group col-md-6">
                    <input type="text" name="responsible" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.responsible')}}" required>
                </div>
                <div class="form-group col-md-6">
                    <input type="text" name="phone_responsible" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.responsible_phone')}}" required>
                </div>
            </div>
            <div class="row form-inline mb-3">
                <div class="form-group col-md-4">
                    <input type="text" name="fiscal_code" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.exhibitor.company.fiscal_code')}}">
                </div>
                <div class="form-group col-md-4">
                    <input type="text" name="vat_number" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.vat_number')}}" required>
                </div>
                <div class="form-group col-md-4 {{ App::getLocale() == 'en' ? 'd-none' : '' }}">
                    <input type="text" name="uni_code" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.exhibitor.company.uni_code')}}" required>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label for="diff_billing">{{__('forms.exhibitor_form.diff_billing')}}</label>
        <select class="form-control" id="diff_billing" name="diff_billing">
            <option value="no" selected>{{__('generals.no')}}</option>
            <option value="yes">{{__('generals.yes')}}</option>
        </select>
    </div>
    <div class="card d-none" data-billing>
        <div class="card-header">
            <h5 class="card-title">{{__('forms.exhibitor_form.data_billing.title')}}</h5>
        </div>
        <div class="card-body">
            <div class="row form-inline my-3">
                <div class="form-group col-md-12">
                    <input type="text" name="receiver" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.heading')}}">
                </div>
            </div>
            <div class="row form-inline mb-3">
                <div class="form-group col-md-10">
                    <input type="text" name="receiver_address" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.address')}}">
                </div>
                <div class="form-group col-md-2">
                    <input type="text" name="receiver_civic_number" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.civic_number')}}">
                </div>
            </div>
            <div class="row form-inline mb-3">
                <div class="form-group col-md-6">
                    <input type="text" name="receiver_city" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.city')}}">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" name="receiver_cap" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.postal_code')}}">
                </div>
                <div class="form-group col-md-3">
                    <input type="text" name="receiver_province" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.province')}}">
                </div>
            </div>
            <div class="row form-inline mb-3">
                <div class="form-group col-md-4">
                    <input type="text" name="receiver_fiscal_code" class="form-control w-100" placeholder="{{__('forms.exhibitor_form.data_billing.fiscal_code')}}">
                </div>
                <div class="form-group col-md-4">
                    <input type="text" name="receiver_vat_number" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.data_billing.vat_number')}}">
                </div>
                <div class="form-group col-md-4 {{ App::getLocale() == 'en' ? 'd-none' : '' }}">
                    <input type="text" name="receiver_uni_code" class="form-control w-100" placeholder="* {{__('forms.exhibitor_form.data_billing.uni_code')}}">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group mb-5">
        <h3>{{__('forms.exhibitor_form.terms_conditions.consent_personal_data')}} & Privacy Policy</h3>
        <div class="icheck-primary d-inline">
            <input type="checkbox" class="form-check-input" id="privacy_policy" required>
            <label class="form-check-label" for="privacy_policy">* {{__('forms.exhibitor_form.terms_conditions.accept')}} <a href="javascript:void(0);" data-toggle="modal" data-target="#modalPrivacy">Privacy Policy</a></label>
        </div>
    </div>
    <blockquote class="blockquote">
        <div class="mb-0">{!! $form_radio_text_1 !!}</div>
        <footer class="blockquote-footer">
            <div>
                <div class="form-group">
                    <div class="icheck-primary d-inline">
                        <input class="form-check-input" type="radio" name="accept_stats" id="accept_stats_yes" value="yes" required>
                        <label class="form-check-label" for="accept_stats_yes">{{__('forms.exhibitor_form.terms_conditions.yes')}}</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="icheck-primary d-inline">
                        <input class="form-check-input" type="radio" name="accept_stats" id="accept_stats_no" value="no">
                        <label class="form-check-label" for="accept_stats_no">{{__('forms.exhibitor_form.terms_conditions.no')}}</label>
                    </div>
                </div>
            </div>
        </footer>
    </blockquote>
    <blockquote class="blockquote">
        {{--<p class="mb-0">{{__('forms.exhibitor_form.terms_conditions.marketing')}}</p>--}}
        <div class="mb-0">{!! $form_radio_text_2 !!}</div>
        <footer class="blockquote-footer">
            <div>
                <div class="form-group">
                    <div class="icheck-primary d-inline">
                        <input class="form-check-input" type="radio" name="accept_marketing" id="accept_marketing_yes" value="yes" required>
                        <label class="form-check-label" for="accept_marketing_yes">{{__('forms.exhibitor_form.terms_conditions.yes')}}</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="icheck-primary d-inline">
                        <input class="form-check-input" type="radio" name="accept_marketing" id="accept_marketing_no" value="no">
                        <label class="form-check-label" for="accept_marketing_no">{{__('forms.exhibitor_form.terms_conditions.no')}}</label>
                    </div>
                </div>
            </div>
        </footer>
    </blockquote>
    <div class="d-flex align-items-center justify-content-end">
        <button class="btn btn-primary btn-lg d-none spinner" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>
        <button type="submit" class="btn btn-primary btn-lg" disabled>{{__('generals.save')}}</button>
    </div>
</form>

<div class="modal fade" id="modalPrivacy" tabindex="-1" role="dialog" aria-labelledby="modalPrivacyLabeL" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPrivacyLabeL">Privacy Policy</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! $privacy_policy_text !!}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        //console.log("{{App::getLocale()}}")
        let selected_lang = "{{App::getLocale()}}"//$('a.nav-link.dropdown-toggle.text-uppercase').text();
        if(selected_lang.trim() == 'it') {
            $('input[name="uni_code"]').attr('required', true)
        } else {
            $('input[name="uni_code"]').removeAttr('required')
        }

        $('#diff_billing').on('change', function() {
            let selected_lang = "{{App::getLocale()}}"//$('a.nav-link.dropdown-toggle.text-uppercase').text();
            $('[data-billing]').toggleClass('d-none');
            if($(this).val() == 'yes') {
                $('input[name="receiver_vat_number"]').attr('required', true)
                if(selected_lang.trim() == 'it') {
                    $('input[name="receiver_uni_code"]').attr('required', true)
                }
            } else {
                $('input[name="receiver_vat_number"]').removeAttr('required')
                if(selected_lang.trim() == 'it') {
                    $('input[name="receiver_uni_code"]').removeAttr('required')
                }
            }
        });
        /* send form */
        $('form').on('submit', function(e) {
            e.preventDefault();
            $('form').find('button[type="submit"]').toggleClass('d-none');
            $('form').find('.spinner').toggleClass('d-none');
            let selected_lang = "{{App::getLocale()}}"//$('a.nav-link.dropdown-toggle.text-uppercase').text();
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
                accept_stats: $('input[name="accept_stats"]:checked').val() == 'yes' ? 1 : 0,
                accept_marketing: $('input[name="accept_marketing"]:checked').val() == 'yes' ? 1 : 0,
                locale: selected_lang.trim()
            })
            .then(response => {
                let data = response.data
                if(data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: data.message
                    }).then(() => {
                        $('form').find('button[type="submit"]').remove();
                        $('form').find('.spinner').remove();
                        window.location = "{{route('login')}}"
                    })
                } else {
                    $('form').find('button[type="submit"]').toggleClass('d-none');
                    $('form').find('.spinner').toggleClass('d-none');
                    toastr.error(data.message)
                }
            })
            .catch(error => {
                $('form').find('button[type="submit"]').toggleClass('d-none');
                $('form').find('.spinner').toggleClass('d-none');
                toastr.error(error)
                console.log(error)
            })
            
        });
        /* end send form */
        /* validate data required */
        $(window).scroll(function() {
            var top_of_element = $('form').find('button[type="submit"]').offset().top;
            var bottom_of_element = $('form').find('button[type="submit"]').offset().top + $('form').find('button[type="submit"]').outerHeight();
            var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
            var top_of_screen = $(window).scrollTop();

            if ((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element)){
                $.each($('form').find('[required]'), (index, value) => {
                    let type = $(value)[0].type
                    if((type != 'checkbox' && $(value).val().length > 0) || (type == 'checkbox' && $(value).is(':checked'))) {
                        $('form').find('button[type="submit"]').removeAttr('disabled');
                    } else {
                        $('form').find('button[type="submit"]').attr('disabled', true);
                    }
                });
            } else {
                $('form').find('button[type="submit"]').attr('disabled', true);
            }
        });
        /* end validation */
    });
</script>
@endsection