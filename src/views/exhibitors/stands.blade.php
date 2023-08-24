@extends('layouts.app')
@section('title', trans('entities.stands').' '.$exhibitor_data->company)
@section('title_header', trans('entities.stands').' '.$exhibitor_data->company)
@section('buttons')
<a href="{{url('admin/exhibitors')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.back')}}"><i class="fas fa-chevron-left"></i></a>
@if(hasOrder($exhibitor_data->email_responsible))
<a href="{{url('admin/export/exhibitor/'.$exhibitor_data->exhibitor_id.'/orders')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.export')}}"><i class="fas fa-file-export"></i></a>
@endif
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @if(hasOrder($exhibitor_data->email_responsible))
            <input type="hidden" name="exhibitor_id" value="{{$exhibitor_data->exhibitor_id}}">
            <div class="callout callout-warning">
                <p class="m-0 lead"><strong>{!! trans('messages.reset_order_txt') !!}</strong></p>
                <p class="mt-3"><a href="javascript:void(0)" onclick="resetOrder()" class="btn btn-warning" style="text-decoration:none;">{{trans('generals.reset_order')}}</a></p>
            </div>
            @endif
            <div class="callout callout-info">
                <p class="m-0"><strong>{{trans('forms.exhibitor_form.exhibitor.company.responsible')}}</strong>: {{$exhibitor_data->responsible}}</p>
                <p class="m-0"><strong>{{trans('forms.exhibitor_form.exhibitor.company.responsible_email')}}</strong>: {{$exhibitor_data->email_responsible}}</p>
                <p class="m-0"><strong>{{trans('forms.exhibitor_form.interested_brand')}}</strong>: {{$stand}}</p>
                @if(hasOrder($exhibitor_data->email_responsible))
                <p class="m-0"><strong>{{trans('generals.total')}}</strong>: {{$total}} €</p>
                @endif
            </div>
        </div>
    </div>
    @if (Session::has('success'))
    @include('admin.partials.success')
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{trans('tables.code')}}</th>
                                <th>{{trans('tables.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(hasOrder($exhibitor_data->email_responsible))
                            @foreach($list as $l)
                            <tr>
                                <td>{{$l->code ? $l->code : 'N/A'}}</td>
                                <td>
                                    <div class="btn-group btn-group" role="group">
                                        <a class="btn btn-default" href="{{ url('admin/exhibitor/'.$l->exhibitor_id.'/stands/'.$l->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-default" href="{{ url('admin/exhibitor/'.$l->exhibitor_id.'/stands/'.$l->id.'/show') }}"><i class="fas fa-shapes"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            @foreach($list as $l)
                            <tr>
                                <td>{{$l->code ? $l->code : 'N/A'}}</td>
                                <td>
                                    <div class="btn-group btn-group" role="group">
                                        <a class="btn btn-default" href="{{ url('admin/exhibitor/'.$l->exhibitor_id.'/stands/'.$l->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $('form button').on('click', function(e) {
        var $this = $(this);
        e.preventDefault();
        Swal.fire({
            title: "{!! trans('generals.confirm_remove') !!}",
            showCancelButton: true,
            confirmButtonText: "{{ trans('generals.confirm') }}",
            cancelButtonText: "{{ trans('generals.cancel') }}",
        }).then((result) => {
            if (result.isConfirmed) {
                $this.closest('form').submit();
            }
        })
    });
    const resetOrder = () => {
        Swal.fire({
            icon: 'info',
            title: "{!! trans('generals.confirm_reset_order') !!}",
            html: "{!! trans('generals.confirm_reset_order_text') !!}",
            showCancelButton: true,
            confirmButtonText: "{{ trans('generals.confirm') }}",
            cancelButtonText: "{{ trans('generals.cancel') }}",
        }).then((result) => {
            if (result.isConfirmed) {
                let exhibitor_id = $('input[name="exhibitor_id"]').val()
                common_request.get('/admin/exhibitor/'+exhibitor_id+'/reset-order')
                .then(response => {
                    let data = response.data
                    if(data.status) {
                        toastr.success(data.message, '', {
                            onShown: function() {
                                setTimeout(function(){
                                    window.location.reload()
                                }, 1000);
                            }
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
        })
    }
</script>
@endsection