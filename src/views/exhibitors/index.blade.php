@extends('layouts.app')
@section('title', trans('entities.exhibitors'))
@section('title_header', trans('entities.exhibitors'))
@section('buttons')
{{--
@if(auth()->user()->roles->first()->name == 'super-admin')
<a href="{{url('admin/exhibitors/create')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.add')}}"><i class="fas fa-plus"></i></a>
@endif
--}}
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
                                <th class="no-sort">{{trans('tables.is_admitted')}}</th>
                                {{--
                                <th class="no-sort">{{trans('tables.active_furnishings')}}</th>
                                <th class="no-sort">{{trans('tables.active_catalog')}}</th>
                                <th class="no-sort">{{trans('tables.invoice_sent')}}</th>
                                <th class="no-sort">{{trans('tables.deposit_received')}}</th>
                                <th class="no-sort">{{trans('tables.invoice_tot_sent')}}</th>
                                <th class="no-sort">{{trans('tables.balance_received')}}</th>
                                --}}
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
                    } /*else {
                        let id = $(this).closest('tr').data('id')
                        let base_url = '/admin/exhibitor/'+id+'/change/'+name.replace('_','-')
                        common_request.post(base_url, {
                            value: $(this).is(':checked') ? 1 : 0
                        })
                        .then(response => {
                            let data = response.data
                            if(data.status) {
                                toastr.success(data.message)
                                if(name == 'credentials') {
                                    $this.attr('disabled', 'disabled')
                                }
                            } else {
                                toastr.error(data.message)
                                $this.bootstrapToggle('off', true);
                            }
                        })
                        .catch(error => {
                            toastr.error(error)
                            console.log(error)
                            $this.bootstrapToggle('off', true);
                        })
                    }*/
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
                /*
                { 
                    data: null,
                    render: function(data,type,row){
                        let is_admitted = parseInt(row['is_admitted'])
                        let furnishings = parseInt(row['furnishings'])
                        let close_furnishings = parseInt(row['close_furnishings'])
                        let yes = "{{trans('generals.yes')}}"
                        let no = "{{trans('generals.no')}}"
                        return '<input name="furnishings" type="checkbox" ' + (furnishings ? 'checked' : '') + ' data-toggle="toggle" data-on="'+yes+'" data-off="'+no+'" data-onstyle="success" data-offstyle="danger" data-size="sm" ' + (is_admitted ? '' : 'disabled') + '>'
                            + '<span class="ml-1 ' + (close_furnishings ? 'text-success' : '') + '"><i class="fas fa-' + (close_furnishings ? 'check' : 'times') + '-circle fa-lg"></i></span>'
                    },
                    visible: $('input[name="visible"]').val()
                },
                { 
                    data: null,
                    render: function(data,type,row){
                        let is_admitted = parseInt(row['is_admitted'])
                        let catalog = parseInt(row['catalog'])
                        let yes = "{{trans('generals.yes')}}"
                        let no = "{{trans('generals.no')}}"
                        return '<input name="catalog" type="checkbox" ' + (catalog ? 'checked' : '') + ' data-toggle="toggle" data-on="'+yes+'" data-off="'+no+'" data-onstyle="success" data-offstyle="danger" data-size="sm" ' + (is_admitted ? '' : 'disabled') + '>';
                    },
                    visible: $('input[name="visible"]').val()
                },
                { 
                    data: null,
                    render: function(data,type,row){
                        let is_admitted = parseInt(row['is_admitted'])
                        let invoice_sent = parseInt(row['invoice_sent'])
                        let yes = "{{trans('generals.yes')}}"
                        let no = "{{trans('generals.no')}}"
                        return '<input name="invoice_sent" type="checkbox" ' + (invoice_sent ? 'checked' : '') + ' data-toggle="toggle" data-on="'+yes+'" data-off="'+no+'" data-onstyle="success" data-offstyle="danger" data-size="sm" ' + (is_admitted ? '' : 'disabled') + '>';
                    }
                },
                { 
                    data: null,
                    render: function(data,type,row){
                        let is_admitted = parseInt(row['is_admitted'])
                        let deposit_received = parseInt(row['deposit_received'])
                        let yes = "{{trans('generals.yes')}}"
                        let no = "{{trans('generals.no')}}"
                        return '<input name="deposit_received" type="checkbox" ' + (deposit_received ? 'checked' : '') + ' data-toggle="toggle" data-on="'+yes+'" data-off="'+no+'" data-onstyle="success" data-offstyle="danger" data-size="sm" ' + (is_admitted ? '' : 'disabled') + '>';
                    }
                },
                { 
                    data: null,
                    render: function(data,type,row){
                        let is_admitted = parseInt(row['is_admitted'])
                        let invoice_tot_sent = parseInt(row['invoice_tot_sent'])
                        let yes = "{{trans('generals.yes')}}"
                        let no = "{{trans('generals.no')}}"
                        return '<input name="invoice_tot_sent" type="checkbox" ' + (invoice_tot_sent ? 'checked' : '') + ' data-toggle="toggle" data-on="'+yes+'" data-off="'+no+'" data-onstyle="success" data-offstyle="danger" data-size="sm" ' + (is_admitted ? '' : 'disabled') + '>';
                    }
                },
                { 
                    data: null,
                    render: function(data,type,row){
                        let is_admitted = parseInt(row['is_admitted'])
                        let balance_received = parseInt(row['balance_received'])
                        let yes = "{{trans('generals.yes')}}"
                        let no = "{{trans('generals.no')}}"
                        return '<input name="balance_received" type="checkbox" ' + (balance_received ? 'checked' : '') + ' data-toggle="toggle" data-on="'+yes+'" data-off="'+no+'" data-onstyle="success" data-offstyle="danger" data-size="sm" ' + (is_admitted ? '' : 'disabled') + '>';
                    }
                },
                */
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
                        return `
                        <div class="btn-group" role="group">
                            <div class="btn-group">
                                @if(auth()->user()->roles->first()->name == 'super-admin')

                                <a data-toggle="tooltip" data-placement="top" title="{{trans('generals.edit')}}" href=${edit_href} class="btn btn-default"><i class="fa fa-edit"></i></a>
                                <a data-toggle="tooltip" data-placement="top" title="{{trans('entities.events')}}" href=${events_href} class="btn btn-default"><i class="fas fa-calendar-check"></i></a>
                                {{--
                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a class="dropdown-item" href=${events_href}>{{trans('entities.events')}}</a>
                                    </li>
                                    
                                    <li>
                                        <a class="dropdown-item" href=${brands_href}>{{trans('entities.brands')}}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href=${stands_href}>{{trans('entities.stands')}}</a>
                                    </li>
                                    
                                    <li>
                                        <a class="dropdown-item" href=${pdf_href}>{{trans('generals.send')}} PDF</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href=${furnishings_href}>{{trans('generals.send')}} {{trans('generals.prompt')}} {{ trans('entities.furnishings') }}</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href=${catalog_href}>{{trans('generals.send')}} {{trans('generals.prompt')}} {{ trans('entities.catalog') }}</a>
                                    </li>
                                    
                                </ul>
                                --}}
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