@extends('layouts.app')
@section('title', trans('entities.exhibitors_incomplete'))
@section('title_header', trans('entities.exhibitors_incomplete'))
@section('buttons')
<a href="{{url('admin/export/exhibitors-incomplete')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.export')}}"><i class="fas fa-file-export"></i></a>
@endsection
@section('content')
<div class="container-fluid">
    <input type="hidden" name="visible" value="{{ auth()->user()->roles->first()->name == 'super-admin' ? true : false }}">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{trans('tables.email')}}</th>
                                <th class="no-sort">{{trans('tables.actions')}}</th>
                            </tr>
                        </thead>
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
    const sendRemarketing = (id) => {
        Swal.fire({
            title: "{!! trans('generals.confirm_remarketing') !!}",
            showCancelButton: true,
            confirmButtonText: "{{ trans('generals.confirm') }}",
            cancelButtonText: "{{ trans('generals.cancel') }}",
        }).then((result) => {
            if (result.isConfirmed) {
                common_request.post('/admin/exhibitors-incomplete/send-remarketing', {
                    id: id,
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
            }
        })
    }
    
    $(document).ready(function() {
        $('table').DataTable({
            processing: true,
            serverSide: true,
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": false,
            ajax: {
                url: "{{url('admin/exhibitors/getAjaxListIncompleted')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
            },
            drawCallback: function(){
                $('[data-toggle="tooltip"]').tooltip()
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
            },
            createdRow: function(row, data, index) {
                $(row).attr({
                    'data-id': data['id']
                })
            },
            columns: [
                { data: 'email' },
                {
                    data: null,
                    render: function(data,type,row){
                        let destroy_href = '{{ route("exhibitors-incomplete.destroy", ":id") }}';
                        destroy_href = destroy_href.replace(':id', row['id']);
                        return `
                        <div class="btn-group" role="group">
                            <a data-toggle="tooltip" data-placement="top" title="{{trans('generals.send_remarketing')}}" onclick="sendRemarketing(${row['id']})" href="javascript:void(0);" class="btn btn-default"><i class="far fa-paper-plane"></i></a>
                            <form action=${destroy_href} method="POST">
                                @csrf
                                @method('DELETE')
                                <button data-toggle="tooltip" data-placement="top" title="{{trans('generals.delete')}}" class="btn btn-default" type="submit"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                        `
                    }
                }

            ],
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