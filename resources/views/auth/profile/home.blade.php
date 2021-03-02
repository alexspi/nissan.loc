@extends('layouts.app')

@section('content')
    <section class="section-1 container d-flex flex-column flex-md-row-reverse px-0 py-5 my-3 justify-content-between">
        <div class="card p-1 mx-1 my-3 mx-sm-3" id="my-profile">
            <div class="card-header my-0 py-0">
                <h3 class="card-title">Мой профиль</h3>
            </div>
            <div class="card-body">
                <ul>
                    <li>
                        <strong>Имя:</strong>
                        <p><i>{!! $first_name !!}</i></p>
                    </li>
                    <li>
                        <strong>Фамилия:</strong>
                        <p><i>{!! $second_name !!}</i></p>
                    </li>
                    <li>
                        <strong>Почта:</strong>
                        <p><i>{!! $email !!}</i></p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="profile-block p-1 mx-3">
            <h3>Мои заказы</h3>

            @if(Auth::user()->activated == false)
                <div class="alert alert-danger" role="alert">
                    <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                    Please activate your email. <a href="{{route('authenticated.activation-resend')}}">Resend</a>
                    activation email.
                </div>
            @elseif($count == 0)
                <p>{{$message}}</p>
            @else

                <p class="h6">{{$message}}</p>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="m-3 active"><a class="catLink__link" href="#home" aria-controls="home" role="tab"
                                                              data-toggle="tab">Новые</a></li>
                    <li role="presentation" class="m-3"><a class="catLink__link" href="#profile" aria-controls="profile" role="tab"
                                               data-toggle="tab">В работе</a></li>
                    <li role="presentation" class="m-3"><a class="catLink__link" href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Законченные</a>
                    </li>
                    <li role="presentation" class="m-3"><a class="catLink__link" href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Отказ </a>
                    </li>
                </ul>

                <div class="tab-content mx-0">
                    <div role="tabpanel" class="tab-pane mx-auto active" id="home">
                        @foreach($orderItems as $orderItem)
                            @if($orderItem['status']=='0')
                                <div class="panel panel-default">
                                    <!-- Default panel contents -->
                                    <div class="panel-heading">Заказ №{{$orderItem['id']}} Создан
                                        : {{$orderItem['data']}} <a class="catLink__link mx-3" role="button"
                                                                    href="{{ url('/profile/order/'.$orderItem['id']) }}">Отменить</a>
                                    </div>
                                {{--{{dump($orderItem)}}--}}
                                <!-- Table -->
                                    <table class="table table-responsive w-100 py-3 mb-5">
                                        <tbody>
                                        <tr>
                                            <td><strong>Название детали</strong></td>
                                            <td><strong>Номер детали</strong></td>
                                            <td><strong>Количество</strong></td>
                                            <td><strong>Цена за шт.</strong></td>
                                        </tr>
                                        @foreach(last($orderItem) as $item)

                                            {{--{{dd($item)}}--}}
                                            <tr>
                                                <td>{{$item->title}}</td>
                                                <td>
                                                    {{$item->orig_number}}
                                                </td>
                                                <td>
                                                    {{$item->amount}}
                                                </td>
                                                <td>
                                                    {{$item->price}}

                                                </td>
                                                <td>
                                                    {{$item->total}}
                                                </td>

                                            </tr>
                                        @endforeach

                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div role="tabpanel" class="tab-pane mx-auto" id="profile">
                        @foreach($orderItems as $orderItem)
                            @if($orderItem['status']=='1')
                                <div class="panel panel-default">
                                    <!-- Default panel contents -->
                                    <div class="panel-heading">Заказ №{{$orderItem['id']}} Создан
                                        : {{$orderItem['data']}} </div>
                                {{--{{dump($orderItem)}}--}}
                                <!-- Table -->
                                    <table class="table table-responsive w-100 py-3 mb-5">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <b>Название детали</b>
                                            </td>
                                            <td>
                                                <b>Номер детали</b>
                                            </td>
                                            <td>
                                                <b>Количество</b>
                                            </td>
                                            <td>
                                                <b>Цена за шт.</b>
                                            </td>

                                        </tr>
                                        @foreach(last($orderItem) as $item)

                                            {{--{{dd($item)}}--}}
                                            <tr>
                                                <td>{{$item->title}}</td>
                                                <td>
                                                    {{$item->orig_number}}
                                                </td>
                                                <td>
                                                    {{$item->amount}}
                                                </td>
                                                <td>
                                                    {{$item->price}}

                                                </td>
                                                <td>
                                                    {{$item->total}}
                                                </td>

                                            </tr>
                                        @endforeach

                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div role="tabpanel" class="tab-pane mx-auto" id="messages">
                        @foreach($orderItems as $orderItem)
                            @if($orderItem['status']=='2')
                                <div class="panel panel-default">
                                    <!-- Default panel contents -->
                                    <div class="panel-heading">Заказ №{{$orderItem['id']}} Создан
                                        : {{$orderItem['data']}} </div>
                                {{--{{dump($orderItem)}}--}}
                                <!-- Table -->
                                    <table class="table table-responsive w-100 py-3 mb-5">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <b>Название детали</b>
                                            </td>
                                            <td>
                                                <b>Номер детали</b>
                                            </td>
                                            <td>
                                                <b>Количество</b>
                                            </td>
                                            <td>
                                                <b>Цена за шт.</b>
                                            </td>

                                        </tr>
                                        @foreach(last($orderItem) as $item)

                                            {{--{{dd($item)}}--}}
                                            <tr>
                                                <td>{{$item->title}}</td>
                                                <td>
                                                    {{$item->orig_number}}
                                                </td>
                                                <td>
                                                    {{$item->amount}}
                                                </td>
                                                <td>
                                                    {{$item->price}}

                                                </td>
                                                <td>
                                                    {{$item->total}}
                                                </td>

                                            </tr>
                                        @endforeach

                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div role="tabpanel" class="tab-pane mx-auto" id="settings">@foreach($orderItems as $orderItem)
                            @if($orderItem['status']=='3')
                                <div class="panel panel-default">
                                    <!-- Default panel contents -->
                                    <div class="panel-heading">Заказ №{{$orderItem['id']}} Создан
                                        : {{$orderItem['data']}} <a class="catLink__link mx-3" role="button"
                                                                    href="{{ url('/profile/order/d/'.$orderItem['id']) }}">Удалить</a>
                                    </div>
                                {{--{{dump($orderItem)}}--}}
                                <!-- Table -->
                                    <table class="table table-responsive w-100 py-3 mb-5">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <b>Название детали</b>
                                            </td>
                                            <td>
                                                <b>Номер детали</b>
                                            </td>
                                            <td>
                                                <b>Количество</b>
                                            </td>
                                            <td>
                                                <b>Цена за шт.</b>
                                            </td>

                                        </tr>
                                        @foreach(last($orderItem) as $item)

                                            {{--{{dd($item)}}--}}
                                            <tr>
                                                <td>{{$item->title}}</td>
                                                <td>
                                                    {{$item->orig_number}}
                                                </td>
                                                <td>
                                                    {{$item->amount}}
                                                </td>
                                                <td>
                                                    {{$item->price}}

                                                </td>
                                                <td>
                                                    {{$item->total}}
                                                </td>

                                            </tr>
                                        @endforeach

                                    </table>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endif
            {{--{{ dd($orderItems) }}--}}

        </div>
    </section>
@endsection

@section('footer_scripts')

@stop
