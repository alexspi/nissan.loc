@extends('backpack::layout')
@section('after_styles')
    {{--<link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/datatables/dataTables.bootstrap.css">--}}
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/') }}/plugins/datatables/jquery.dataTables.min.css">
@endsection
@section('header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::base.dashboard') }}
            <small>{{ trans('backpack::base.first_page_you_see') }}</small>
        </h1>
        {{--<ol class="breadcrumb">--}}
        {{--<li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>--}}
        {{--<li class="active">{{ trans('backpack::base.dashboard') }}</li>--}}
        {{--</ol>--}}
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                
               
    
                <div class="panel-body dataTables_wrapper form-inline dt-bootstrap">
                    <table id="orders-table" class="table table-bordered table-striped dataTable hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th>№ заказа</th>
                            <th>Пользователь</th>
                            <th>Сумма</th>
                            <th>Создан</th>
                            <th>Статус</th>
                            <th></th>
                        </tr>
                        </thead>
                    </table>
                    <script id="details-template" type="text/x-handlebars-template">
                        <div class="label label-info">Состав заказа</div>
                        <table class="table details-table" id="posts-@{{id}}">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Title</th>
                                <th>Id</th>
                                <th>Title</th>
                            </tr>
                            </thead>
                        </table>
                    </script>
                </div>
                
            </div>
        </div>
    </div>
@endsection


@section('after_scripts')
@include('footer.script_tecdoc')
<?php $url = '/admin/order/data'  ?>
<script type="text/javascript">
    var template = Handlebars.compile($("#details-template").html());
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var table = $('#orders-table').DataTable({
        language: {
            "url": "/assets/datatables/rus.json"
        },
        paging:true,
        searching:false,
        processing: true,
        serverSide: true,
        ajax: '{!! $url !!}',
        columns: [
            {
                "className":      'details-control',
                "orderable":      false,
                "searchable":      false,
                "data":       null,
                "defaultContent": '<i class="fa fa-plus-square-o" aria-hidden="true"></i>'
            },
            {data: 'id', name: 'id'},
            {data: 'order_users', name: 'order_users'},
            {data: 'total', name: 'total'},
            {data: 'created_at', name: 'created_at'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        order: [[1, 'asc']]
    });
    
    // Add event listener for opening and closing details
    $('#users-table tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);
        var tableId = 'posts-' + row.data().id;
        
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(template(row.data())).show();
            initTable(tableId, row.data());
            tr.addClass('shown');
            tr.next().find('td').addClass('no-padding bg-gray');
        }
    });
    
    function initTable(tableId, data) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#' + tableId).DataTable({
            language: {
                "url": "/assets/datatables/rus.json"
            },
            paging:false,
            searching:false,
            processing: false,
            ordering:false,
            serverSide: true,
            ajax: data.details_url,
            columns: [
                { data: 'orig_number', name: 'orig_number' },
                { data: 'title', name: 'title' },
                { data: 'amount', name: 'amount' },
                { data: 'price', name: 'price' }
            ]
        })
    }
</script>

    @endsection