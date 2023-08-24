@extends('layouts.app')
@section('title', trans('entities.brands'))
@section('title_header', trans('entities.brands'))
@section('buttons')
@if(!$editable)
<a href="{{url('admin/brands/create')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.add')}}"><i class="fas fa-plus"></i></a>
<a href="{{url('admin/export/brands')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.export')}}"><i class="fas fa-file-export"></i></a>
@endif
@endsection
@section('content')
<div class="container-fluid">
    @if (Session::has('success'))
    @include('admin.partials.success')
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{trans('tables.brand')}}</th>
                                <th>{{trans('tables.company')}}</th>
                                <th class="no-sort">{{trans('tables.is_admitted')}}</th>
                                <th class="no-sort">{{trans('tables.is_edited')}}</th>
                                <th class="no-sort">{{trans('tables.is_checked')}}</th>
                                <th class="no-sort">{{trans('tables.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $l)
                            <tr data-brand-exhibitor-id="{{$l->brand_exhibitor_id}}">
                                <td>{{$l->name}}</td>
                                <td>{{$l->company}}</td>
                                <td>
                                    <input name="is_approved" type="checkbox" {{$l->is_approved ? 'checked' : ''}} data-toggle="toggle" data-on="{{trans('generals.yes')}}" data-off="{{trans('generals.no')}}" data-onstyle="success" data-offstyle="danger" data-size="sm" {{$editable ? 'disabled' : ''}}>
                                </td>
                                <td>
                                    <span class="ml-1"><i class="fas fa-{{ $l->is_edited ? 'check' : 'times' }}-circle fa-lg"></i></span>
                                </td>
                                <td>
                                    <span class="ml-1"><i class="fas fa-{{ $l->is_checked ? 'check' : 'times' }}-circle fa-lg"></i></span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group" role="group">
                                        @if($editable && !$l->is_edited)
                                        <a data-toggle="tooltip" data-placement="top" title="{{trans('generals.edit')}}" class="btn btn-default" href="{{route('brands.edit', $l->brand_exhibitor_id)}}"><i class="fa fa-edit"></i></a>
                                        @endif
                                        @if(!$editable)
                                        <form action="{{ route('brands.destroy', $l->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button data-toggle="tooltip" data-placement="top" title="{{trans('generals.delete')}}" class="btn btn-default" type="submit"><i class="fa fa-trash"></i></button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
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
    $(document).ready(function() {
        $('table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": false,
            columnDefs: [{
                orderable: false,
                targets: "no-sort"
            }],
            "oLanguage": {
                "sSearch": "{{trans('generals.search')}}",
                "oPaginate": {
                    "sFirst": "{{trans('generals.start')}}", // This is the link to the first page
                    "sPrevious": "«", // This is the link to the previous page
                    "sNext": "»", // This is the link to the next page
                    "sLast": "{{trans('generals.end')}}" // This is the link to the last page
                }
            }
        });

        $('input[type="checkbox"]').change(function() {
            let name = $(this).attr('name')
            let brand_exhibitor_id = $(this).closest('tr').data('brand-exhibitor-id')
            let base_url = '/admin/brand/'+brand_exhibitor_id+'/toggle-status/'+name
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