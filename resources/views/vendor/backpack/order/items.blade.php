@extends('backpack::layout')

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
                
               
    
                <div class="panel-body table-responsive">
                    <table id="orderitems" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Номер детали</th>
                            <th>Название </th>
                            <th>Количество</th>
                            <th>Цена за штуку</th>
                            <th>На складе</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('after_scripts')
@include('footer.script_tecdoc')
<?php $url = '/admin/order/'.$order_id.'/data'  ?>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });
    $(function () {
        $('#orderitems').DataTable({
            language: {
                "url": "/assets/datatables/rus.json"
            },
            paging:false,
            searching:false,
            processing: true,
            serverSide: true,
            ajax: '{!! $url !!}',
            columns: [
                {data: 'orig_number', name: 'orig_number'},
                {data: 'title', name: 'title'},
                {data: 'amount', name: 'amount'},
                {data: 'price', name: 'price'},
                {data: 'ostatok',name: 'ostatok'}
                
            ]
        });
        
    });

</script>
    @endsection