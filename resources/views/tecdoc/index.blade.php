@extends('layouts/app')

@include('header.header_yamaps')
{{-- Page title --}}
@section('title')
   Каталог TecDoc
    @parent
@stop

@section('header_styles')
    
@stop
@section('breadcrummbs')
    <div class="breadcum">
        {!! Breadcrumbs::render('podbortecdoc') !!}
    </div>
@stop


{{-- Page content --}}
@section('content')
            <div class="content">
                <h3 class="inner-main-title">Запчасти ниссан и инфинити (каталог TecDoc)</h3>
                <div class="brands-area clearfix">
                    <div class="col-sm-6">
                        <a href="/podbortecdoc/558"><img src="images/nissan_logo.png"><span>Ниссан (каталог TecDoc)</span></a>
                    </div>
                    <div class="col-sm-6">
                        <a href="/podbortecdoc/1234"><img src="images/infiniti_logo.png"><span>Инфинити (каталог TecDoc)</span></a>
                    </div>
                </div>
                <!--<div class="brands-area clearfix">
                        @foreach($Marks as $Mark)
                        <div class="col-sm-6">
                            <a href="{{ url('podbortecdoc/'.$Mark->MFA_ID) }}">{!!$Mark->MFA_BRAND  !!} </a>
                        </div>
                        @endforeach
                    {{--@foreach($Marks as $mark)--}}
                        {{--<div>--}}
                            {{--{!! $mark->MFA_ID !!}--}}
                            {{--{!! $mark->MFA_BRAND !!}--}}
                        {{--</div>--}}
                    {{--@endforeach--}}
                </div>-->
                <article class="page-description">
                    <p>В каталоге интернет-магазина, представлен большой ассортимент запчастей для ТО (техническое обслуживание), как: тормозные колодки, масленые,
                        топливные и воздушные фильтры, свечи для системы зажигания и лампы освещения, сертифицированные для автомобилей Ниссан, различных производителей 
                        и ценовых категорий.
                    </p>
                    <p>У нас вы сможете выбрать любые моторные масла — от спортивной синтетики, применяемой на скоростных Nissan 370Z, до масел с повышенным содержанием 
                        очищающих веществ, которые необходимы для внедорожников с дизельными двигателями Patrol, Armada и Navara.
                    </p>
                    <p>Кузовные автозапчасти: капоты, бампера и фары в нашеи интернет-магазине постоянно в наличии для всего модельного ряда Nissan, 
                        включая такие новинки как Juke и GT-R.
                    </p>
                </article>
                <!--<div class="col-md-4">
                    <h3 class="inner-col-title">Нужна помощь в подборе?</h3>
                    <p>Заполните заявку, и мы с легкостью подберем для вас нужную деталь!</p>
                    <a href="" class="btn btn-default" rolu="button">Заполнить заявку на подбор детали</a>
                </div>-->
            </div>
    </div>
@stop

{{-- Body Bottom confirm modal --}}
{{-- page level scripts --}}
@section('footer_scripts')
