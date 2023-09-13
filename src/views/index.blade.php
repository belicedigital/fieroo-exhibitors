@extends('layouts.app')
@section('title', trans('entities.exhibitors'))
@section('title_header', trans('entities.exhibitors'))
@section('buttons')
<a href="{{url('admin/export/exhibitors')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.export')}}"><i class="fas fa-file-export"></i></a>
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
                                <th>{{trans('tables.company')}}</th>
                                <th>{{trans('tables.email')}}</th>
                                <th>{{trans('tables.n_events')}}</th>
                                <th class="no-sort">{{trans('tables.is_admitted')}}</th>
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
    const admit = (el, id) => {
        common_request.get('/admin/exhibitor/'+id+'/admit')
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
            el.bootstrapToggle('off', true);
        })
    }

    $(document).ready(function() {
        $('table').DataTable({
            processing: true,
            serverSide: true,
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "autoWidth": false,
            "responsive": false,
            ajax: {
                url: "{{url('admin/exhibitors/getAjaxList')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
            },
            drawCallback: function(){
                $('[data-toggle="tooltip"]').tooltip()
                $('input[data-toggle="toggle"]').bootstrapToggle()
                $('input[type="checkbox"]').on('change.bootstrapSwitch', function(e) {
                    let $this = $(this)
                    let name = $(this).attr('name')
                    if(name  == 'is_admitted') {
                        let exhibitor_id = $(this).closest('tr').data('exhibitor-id')
                        Swal.fire({
                            icon: 'info',
                            title: "{!! trans('generals.confirm_admit') !!}",
                            showCancelButton: true,
                            confirmButtonText: "{{ trans('generals.confirm') }}",
                            cancelButtonText: "{{ trans('generals.cancel') }}",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                admit($this, exhibitor_id)
                            } else {
                                $this.bootstrapToggle('off', true);
                            }
                        })
                    }
                });

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
                    'data-id': data['id'],
                    'data-exhibitor-id': data['exhibitor_id']
                })
            },
            columns: [
                { data: 'company' },
                { data: 'email' },
                { data: 'n_events' },
                { 
                    data: null,
                    render: function(data,type,row){
                        let is_admitted = parseInt(row['is_admitted'])
                        let yes = "{{trans('generals.yes')}}"
                        let no = "{{trans('generals.no')}}"
                        return '<input name="is_admitted" type="checkbox" ' + (is_admitted ? 'checked' : '') + ' data-toggle="toggle" data-on="'+yes+'" data-style="ios" data-off="'+no+'" data-onstyle="success" data-offstyle="danger" data-size="sm" ' + (is_admitted ? 'disabled' : '') + '>';
                    },
                    visible: $('input[name="visible"]').val()
                },
                {
                    data: null,
                    render: function(data,type,row){
                        let edit_href = "{{url('admin/exhibitors/')}}/"+row['id']+'/edit'
                        let brands_href = "{{url('admin/exhibitor/')}}/"+row['exhibitor_id']+'/brands'
                        let stands_href = "{{url('admin/exhibitor/')}}/"+row['exhibitor_id']+'/stands'
                        let events_href = "{{url('admin/exhibitor/')}}/"+row['exhibitor_id']+'/events'
                        let pdf_href = "{{url('admin/exhibitor/')}}/"+row['exhibitor_id']+'/send-pdf'
                        let furnishings_href = "{{url('admin/exhibitor/')}}/"+row['exhibitor_id']+'/send-prompt-furnishings'
                        let catalog_href = "{{url('admin/exhibitor/')}}/"+row['exhibitor_id']+'/send-prompt-catalog'
                        let show_href = "{{url('admin/exhibitors/')}}/"+row['id']+'/show'
                        let destroy_href = '{{ route("exhibitors.destroy", ":id") }}';
                        destroy_href = destroy_href.replace(':id', row['id']);
                        let show_event_btn = row['n_events'] > 0 ? '' : 'd-none'
                        return `
                        <div class="btn-group" role="group">
                            <div class="btn-group">
                                @if(auth()->user()->roles->first()->name == 'super-admin')

                                <a data-toggle="tooltip" data-placement="top" title="{{trans('generals.edit')}}" href=${edit_href} class="btn btn-default"><i class="fa fa-edit"></i></a>
                                <a data-toggle="tooltip" data-placement="top" title="{{trans('entities.events')}}" href=${events_href} class="btn btn-default ${show_event_btn}"><i class="fas fa-calendar-check"></i></a>
                                
                                @elseif(auth()->user()->roles->first()->name == 'amministrazione')
                                <a href=${show_href} class="btn btn-default"><i class="fa fa-eye"></i></a>
                                @endif
                            </div>
                            @if(auth()->user()->roles->first()->name == 'super-admin')
                            <form action=${destroy_href} method="POST">
                                @csrf
                                @method('DELETE')
                                <button data-toggle="tooltip" data-placement="top" title="{{trans('generals.delete')}}" class="btn btn-default" type="submit"><i class="fa fa-trash"></i></button>
                            </form>
                            @endif
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