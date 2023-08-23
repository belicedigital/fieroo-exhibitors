@extends('layouts.app')
@section('title', trans('entities.brands').' '.$exhibitor_company)
@section('title_header', trans('entities.brands').' '.$exhibitor_company)
@section('buttons')
<a href="{{url('admin/exhibitors')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.back')}}"><i class="fas fa-chevron-left"></i></a>
<a href="{{url('admin/export/exhibitor/'.$exhibitor_id.'/brands')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.export')}}"><i class="fas fa-file-export"></i></a>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{trans('tables.name')}}</th>
                                <th>{{trans('tables.is_admitted')}}</th>
                                <th>{{trans('tables.is_checked')}}</th>
                                <th>{{trans('tables.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $l)
                            <tr data-brand-id="{{$l->id}}">
                                <td>{{$l->name}}</td>
                                <td>
                                    <input name="is_approved" type="checkbox" {{$l->is_approved ? 'checked' : ''}} data-toggle="toggle" data-on="{{trans('generals.yes')}}" data-off="{{trans('generals.no')}}" data-onstyle="success" data-offstyle="danger" data-size="sm">
                                </td>
                                <td>
                                    <input name="is_checked" type="checkbox" {{$l->is_checked ? 'checked' : ''}} data-toggle="toggle" data-on="{{trans('generals.yes')}}" data-off="{{trans('generals.no')}}" data-onstyle="success" data-offstyle="danger" data-size="sm" disabled>
                                </td>
                                <td>
                                    <div class="btn-group btn-group" role="group">
                                        <form action="{{ route('brands.destroy', $l->brand_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-default" type="submit"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (Session::has('success'))
                <div class="card-footer">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{Session::get('success')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                @endif
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
    $(document).ready(function() {
        $('input[type="checkbox"]').change(function() {
            let name = $(this).attr('name')
            let brand_id = $(this).closest('tr').data('brand-id')
            let base_url = '/admin/brand/'+brand_id+'/toggle-status/'+name
            common_request.post(base_url, {
                value: $(this).is(':checked')
            })
            .then(response => {
                let data = response.data
                if(data.status) {
                    toastr.success(data.message)
                } else {
                    toastr.error(data.message)
                }
            })
            .catch(error => {
                toastr.error(error)
                console.log(error)
            })
        });
    });
</script>
@endsection