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
                    <h3>Заказ №{!! $order->id !!}</h3>    На сумму:  {!! $order->total !!}
                    <div id="_token" class="hidden" data-token="{{ csrf_token() }}"></div>
                    <p>Статус заказа
                        <a class="pUpdate" data-pk="{{ $order->id }}" data-url='/admin/order/updatestatus/{{ $order->id }}'>
                            @if($order->status==0) Новый
                            @elseif($order->status==1)В работе
                            @elseif($order->status==2)Закрыт
                            @else Отказ
                            @endif
                       </a>
                    </p>
                </div>
                
                <div class="panel-body table-responsive">
                    <table id="orderitems" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Номер детали</th>
                            <th>Название</th>
                            <th>Количество</th>
                            <th>Цена за штуку</th>
                            <th>На складе</th>
                        </tr>
                        </thead>
                       
                            @foreach($orderitems as $orderitem)
                            <tr>
                                <td>{{$orderitem->orig_number}}</td>
                                <td>{{$orderitem->title}}</td>
                                <td><div id="_token{{ $orderitem->id }}" class="hidden" data-token="{{ csrf_token() }}"></div>
                                    <a class="amountUpdate" data-pk="{{ $orderitem->id }}" data-url='/admin/order/updateamount/{{ $orderitem->id }}'>
                                        {!! $orderitem->amount!!}
                                    </a></td>
        
                                <td><div id="_token{{ $orderitem->id }}" class="hidden" data-token="{{ csrf_token() }}"></div>
                                    <a class="priceUpdate" data-pk="{{ $orderitem->id }}" data-url='/admin/order/updateprice/{{ $orderitem->id }}'>
                                        {!! $orderitem->price!!}
                                </a></td>

                              <td>{{$orderitem->ostatok}}</td>
                            </tr>
                                                           
                            @endforeach
                       
                    </table>
                    
                    <button class="alert">Обновить данные</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('after_scripts')
    <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
    <script>
        $(function () {

            $.fn.editable.defaults.params = function (params) {
                params._token = $("#_token").data("token");
                return params;
            };
            $.fn.editable.defaults.mode = 'inline';
            $('.pUpdate').editable({
                validate: function (value) {
                    if ($.trim(value) == '')
                        return 'Value is required.';
                },
                type: 'select',
                url: '/admin/order/updatestatus',
                source: [
                    {value: 0, text: 'Новый'},
                    {value: 1, text: 'В работе'},
                    {value: 2, text: 'Закрыт'},
                    {value: 3, text: 'Отказ'}
                ],
                title: 'Edit Status',
                placement: 'top',
                send: 'always',
                ajaxOptions: {
                    dataType: 'json'
                }
            });
        });
        $(function(){
            //edit form style - popup or inline
            $.fn.editable.defaults.params = function (params) {
                params._token = $("#_token{{ $orderitem->id }}").data("token");
                return params;
            };
            $.fn.editable.defaults.mode = 'inline';
            $('.priceUpdate').editable({
                validate: function(value) {
                    if($.trim(value) == '')
                        return 'Value is required.';
                },
                type: 'text',
                url:'/admin/order/updateprice',
                title: 'Edit Status',
                placement: 'top',
                send:'always',
                ajaxOptions: {
                    dataType: 'json'
                }
            });
        });
        $(function(){
            //edit form style - popup or inline
            $.fn.editable.defaults.params = function (params) {
                params._token = $("#_token{{ $orderitem->id }}").data("token");
                return params;
            };
            $.fn.editable.defaults.mode = 'inline';
            $('.amountUpdate').editable({
                validate: function (value) {
                    if ($.trim(value) == '')
                        return 'Value is required.';
                },
                type: 'select',
                source: [
                    {value: 1, text: '1'},
                    {value: 2, text: '2'},
                    {value: 3, text: '3'},
                    {value: 4, text: '4'}
                ],
                title: 'Edit Status',
                placement: 'top',
                send: 'always',
                ajaxOptions: {
                    dataType: 'json'
                }
            });
        });
    </script>

@endsection