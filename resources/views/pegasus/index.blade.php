@extends('layouts/app')
{{-- Page title --}}
@section('title')
    Каталог TecDoc
    @parent
@stop
@section('header_styles')

@stop
@section('breadcrumbs')
    <div class="breadcum">
        {!! Breadcrumbs::render('pegasus') !!}
    </div>
@stop
{{-- Page content --}}
@section('content')
    <section class="section-1 container px-3 py-5 my-3">
        <h1>Каталог TecDoc</h1>
        <hr>
        <div class="catLink d-flex flex-column flex-md-row justify-content-around my-5">
            <div class="catLink--nissan d-flex flex-row mx-auto">
                <a href="/podbortecdoc/80" class="catLink__link"><img class="catLink__img align-middle" src="images/nissan_logo.png" alt="nissan_logo"> Каталог запчастей Nissan</a>
            </div>
            <div class="catLink--infinity d-flex flex-row mx-auto">
                <a href="/podbortecdoc/1526" class="catLink__link"><img class="catLink__img align-middle" src="images/infiniti_logo.png" alt="infinity_logo"> Каталог запчастей Infinity</a>
            </div>
        </div>
    </section>
    <section class="section-2 container px-3 pt-3 pb-5">
        <p>В каталоге интернет-магазина, представлен большой ассортимент запчастей для ТО (техническое обслуживание),
            как: тормозные колодки, масленые, топливные и воздушные фильтры, свечи для системы зажигания и лампы
            освещения, сертифицированные для автомобилей Ниссан, различных производителей и ценовых категорий. <br>У нас вы
            сможете выбрать любые моторные масла — от спортивной синтетики, применяемой на скоростных Nissan 370Z, до
            масел с повышенным содержанием очищающих веществ, которые необходимы для внедорожников с дизельными
            двигателями Patrol, Armada и Navara. <br>Кузовные автозапчасти: капоты, бампера и фары в нашеи интернет-магазине
            постоянно в наличии для всего модельного ряда Nissan, включая такие новинки как Juke и GT-R.</p>
    </section>
@stop

{{-- Body Bottom confirm modal --}}
{{-- page level scripts --}}
@section('footer_scripts')
