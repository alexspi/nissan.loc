@extends('layouts/app')
{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
@section('header_styles')

    {{--<script src="{{asset("assets/js/cookie.js")}}"></script>--}}

@stop
{{--@section('breadcrummbs')--}}
    {{--<div class="breadcum">--}}
        {{--{!! Breadcrumbs::render('cart') !!}--}}
    {{--</div>--}}
{{--@stop--}}
{{-- Page content --}}
@section('content')
    <section class="section-1 container px-3 py-5 my-3">
        <h1>Мои покупки</h1>
        <hr>
    {{--@php $id = Auth::id();Cart::instance('shopping')->restore($id); @endphp--}}
    {{--Cart::instance('shopping')->restore($id);--}}
        <table class="table mt-5 w-100">
            <thead>
                <tr>
                    <th class="bordered align-middle">Название детали</th>
                    <th class="bordered align-middle">Номер детали</th>
                    <th class="bordered align-middle">Количество</th>
                    <th class="bordered align-middle">Цена за шт.</th>
                    <th class="bordered align-middle">Цена позиции</th>
                </tr>
            </thead>
            <tbody>
                @foreach( Cart::instance('shopping')->content() as $row)
                    <tr>
                        <td>{{$row->name}}</td>
                        <td>{{$row->options->number}}</td>
                        <td>{{$row->qty}}</td>
                        <td>{{$row->price}}</td>
                        <td>{{$row->total}}</td>
                        <td style="text-align: right;"><a href="{{URL::route('delete_book_from_cart',$row->rowId)}}"><i class="fa fa-times" aria-hidden="true"></i> Удалить</a></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">&nbsp;</td>
                    <td>Total</td>
                    <td><?php echo Cart::total(); ?></td>
                </tr>
            </tfoot>
        </table>
    </section>
    <section class="section-2 container px-3 py-3 my-3">
        <p class="h3">Ваши данные для заказа</p>
    @if(Auth::user())
        <form action="/order" method="post" accept-charset="UTF-8">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label for="name">Ваше имя</label>
                <input type="text" value="{!! array_get($UserProf, 'first_name')!!} " name="first_name"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="text" value="{!! array_get($UserProf, 'email')!!}" name="email" class="form-control">

            </div>
            <div class="form-group">
                <label for="phone">Телефон</label>
                <input type="text" value="{!! array_get($UserProf, 'phone')!!}" name="phone" class="form-control">

            </div>
            <div class="form-group">
                <label for="adress">Адрес</label>
                <input type="text" value=" " name="adress" class="form-control">

            </div>

            <button onclick="notifyMe()" class="btn btn-block btn-primary btn-large">Заказать</button>
        </form>
    @else
            <p>для продолжения заказа вам необходимо войти или зарегистрироваться</p>
            <div class="btn-group">
                <a href="{{ url('/login') }}" class="btn but__link but--reg mt-3 ml-2">Войти</a>
                <a href="{{ url('/register') }}" class="btn but__link but--reg mt-3 mr-2">Зарегестрироваться</a>
            </div>
    @endif
        </section>
@stop

{{-- Body Bottom confirm modal --}}
{{-- page level scripts --}}


@section('footer_scripts')

@stop