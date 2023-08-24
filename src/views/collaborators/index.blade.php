@extends('layouts.app')
@section('title', trans('entities.collaborators'))
@section('title_header', trans('entities.collaborators'))
@section('buttons')
<a href="{{url('admin/collaborators/create')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.add')}}"><i class="fas fa-plus"></i></a>
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
                                <th>{{trans('tables.name')}}</th>
                                <th>{{trans('tables.email')}}</th>
                                <th>{{trans('tables.brand')}}</th>
                                <th class="no-sort">{{trans('tables.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $l)
                            <tr>
                                <td>{{$l->name}}</td>
                                <td>{{$l->email}}</td>
                                <td>{{$l->brand}}</td>
                                <td>
                                    <div class="btn-group btn-group" role="group">
                                        <a data-toggle="tooltip" data-placement="top" title="{{trans('generals.edit')}}" class="btn btn-default" href="{{ url('admin/collaborators/'.$l->id.'/edit') }}"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('collaborators.destroy', $l->user_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button data-toggle="tooltip" data-placement="top" title="{{trans('generals.delete')}}" class="btn btn-default" type="submit"><i class="fa fa-trash"></i></button>
                                        </form>
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
    });
</script>
@endsection