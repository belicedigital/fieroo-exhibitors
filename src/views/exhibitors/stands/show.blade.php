@extends('layouts.app')
@section('title', trans('entities.furnishings'). ' ' . $code)
@section('title_header', trans('entities.furnishings'). ' ' . $code)
@section('buttons')
<a href="{{url('admin/exhibitor/'.$exhibitor_id.'/stands')}}" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{trans('generals.back')}}"><i class="fas fa-chevron-left"></i></a>
@endsection
@section('content')
<input type="hidden" name="code_module" value="{{$code_module}}">

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive p-0 py-3">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>{{trans('tables.description')}}</th>
                                <th>{{trans('tables.is_supplied')}}</th>
                                <th>{{trans('tables.price')}}</th>
                                <th>{{trans('tables.size')}}</th>
                                <th class="no-sort">{{trans('tables.color')}}</th>
                                <th class="no-sort">{{trans('tables.qty_selected')}}</th>
                                <th class="no-sort">{{trans('tables.max_supplied')}}</th>
                                <th class="no-sort">{{trans('tables.image')}}</th>
                                <th class="no-sort">{{trans('tables.total')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($list as $l)
                            <tr data-id="{{$l->order_id}}">
                                <td>{{$l->description}}</td>
                                <td>{{$l->is_supplied ? ($l->extra_price ? trans('generals.no') : trans('generals.yes')) : trans('generals.no')}}</td>
                                <td name="price"><span>{{$l->price}}</span> &euro;</td>
                                <td name="size">{{$l->size}}</td>
                                <td>{{$l->color}}</td>
                                <td>{{$l->qty}}</td>
                                <td>
                                    {{$l->is_supplied ? ($l->extra_price ? 'N/A' : $l->max) : 'N/A'}}
                                </td>
                                <td>
                                    <a href="javascript:void(0);" onclick="assignImg(this)" role="button" data-toggle="modal" data-target="#modalImg"><img src="{{asset('upload/furnishings/'.$l->file_path)}}" class="table-img"></a>
                                </td>
                                <td>
                                    @php
                                    $price = 0;
                                    if($l->extra_price) {
                                        $price = $l->price * $l->qty;
                                    } else {
                                        if($l->is_supplied) {
                                            if($l->qty > $l->max) {
                                                $diff = $l->qty - $l->max;
                                                $price = $l->price * $diff;
                                            }
                                        } else {
                                            $price = $l->price * $l->qty;
                                        }
                                    }
                                    @endphp
                                    {{$price}} €
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>{{trans('generals.total')}}: {{$total}} €</th>
                            </tr>
                        </tfoot>
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
<div class="modal fade" id="modalImg" tabindex="-1" role="dialog" aria-labelledby="modalImgLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" class="w-100">
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    const assignImg = (el) => {
        let src = $(el).find('img').attr('src')
        console.log(src)
        $('#modalImg').find('img').attr('src', src)

    }

    $(document).ready(function() {

        $('table').DataTable({
            "paging": false,
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
                "sSearch": "{{trans('generals.search')}}"
            }
        });
    });
</script>
@endsection