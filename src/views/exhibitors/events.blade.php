{{-- @extends('layouts.app')
@section('title', trans('entities.exhibitor_events', ['exhibitor' => $exhibitor_data->company]))
@section('title_header', trans('entities.exhibitor_events', ['exhibitor' => $exhibitor_data->company]))
@section('buttons')
<a href="{{url('admin/exhibitors')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.back')}}"><i class="fas fa-chevron-left"></i></a>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{trans('tables.event_name')}}</th>
                                <th>{{trans('tables.start')}}</th>
                                <th>{{trans('tables.end')}}</th>
                                <th>{{trans('tables.furnished')}}</th>
                                <th class="no-sort">{{trans('tables.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $l)
                            <tr>
                                <td>{{$l->title}}</td>
                                <td>{{\Carbon\Carbon::parse($l->start)->format('d/m/Y')}}</td>
                                <td>{{\Carbon\Carbon::parse($l->end)->format('d/m/Y')}}</td>
                                <td>{{!userEventIsNotFurnished($user_id, $l->id, $exhibitor_data->exhibitor_id) ? trans('generals.yes') : trans('generals.no')}}</td>
                                <td>
                                    <a class="btn btn-default" data-toggle="tooltip" data-placement="top" title="{{trans('generals.recap')}}" href="{{url('admin/exhibitor/'.$exhibitor_data->exhibitor_id.'/event/'.$l->id.'/recap')}}"><i class="far fa-list-alt"></i></a>
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
@endsection --}}

@extends('layouts/layoutMaster')
@section('title', trans('entities.exhibitor_events', ['exhibitor' => $exhibitor_data->company]))
@section('title_header', trans('entities.exhibitor_events', ['exhibitor' => $exhibitor_data->company]))

@section('button')
    <a href="{{ url('admin/exhibitors') }}" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="bottom"
        data-bs-original-title="{{ trans('generals.back') }}"><i class="fas fa-chevron-left"></i></a>
    {{-- <a href="{{ url('admin/exhibitors') }}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom"
        title="{{ trans('generals.back') }}"><i class="fas fa-chevron-left"></i></a> --}}
@endsection

@section('path', trans('entities.exhibitors'))
@section('current', trans('entities.exhibitor_events', ['exhibitor' => $exhibitor_data->company]))

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-3">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{ trans('tables.event_name') }}</th>
                                <th>{{ trans('tables.start') }}</th>
                                <th>{{ trans('tables.end') }}</th>
                                <th>{{ trans('tables.furnished') }}</th>
                                <th class="no-sort">{{ trans('tables.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $l)
                                <tr>
                                    <td>{{ $l->title }}</td>
                                    <td>{{ \Carbon\Carbon::parse($l->start)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($l->end)->format('d/m/Y') }}</td>
                                    <td>{{ !userEventIsNotFurnished($user_id, $l->id, $exhibitor_data->exhibitor_id) ? trans('generals.yes') : trans('generals.no') }}
                                    </td>
                                    <td>
                                        <a class="btn btn-default" data-toggle="tooltip" data-placement="top"
                                            title="{{ trans('generals.recap') }}"
                                            href="{{ url('admin/exhibitor/' . $exhibitor_data->exhibitor_id . '/event/' . $l->id . '/recap') }}"><i
                                                class="far fa-list-alt"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <!-- Table -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endsection

@section('page-script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('table');

            const dataTable = new DataTable(table, {
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
                    "sSearch": "{{ trans('generals.search') }}",
                    "oPaginate": {
                        "sFirst": "{{ trans('generals.start') }}", // This is the link to the first page
                        "sPrevious": "«", // This is the link to the previous page
                        "sNext": "»", // This is the link to the next page
                        "sLast": "{{ trans('generals.end') }}" // This is the link to the last page
                    }
                }
            });
        });
    </script>
@endsection
