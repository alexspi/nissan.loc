@extends('layouts.app')

@section('header.header_styles')
    @include('header.header_yamaps')
@stop

@section('content')
    <section class="section-1 p-3 my-3 mx-auto">
        <div>
            <h1>Запчасти Nissan и Infinity в <span class="nowrap">Санкт-Петербурге</span></h1>
            <h3 class="d-none d-lg-block my-3">Каталог запчастей ниссан и инфинити. <br>Оригинальные и неоригинальные запчасти. <br>Всегда в наличии.</h3>
        </div>
        <div class="partbtn d-flex flex-row justify-content-between my-3 my-md-5">
            <div class="d-flex flex-column">
                <p class="partbtn__title">Каталоги автозапчастей</p>
                <button class="partbtn__btn btn navbar-toggler" type="button" data-toggle="collapse" data-target="#nissan" aria-controls="nissan" aria-expanded="false" aria-label="Toggle catalog"><a href="#"><img src="/images/nissan_logo.png" alt="nissan" class="align-middle"> Запчасти ниссан <i class="fa fa-sort-desc mx-2 align-top" aria-hidden="true"></i></a></button>
                <ul class="subSignin__list collapse px-1" id="nissan">
                        <li class="nav-item m-1 py-2"><a href="/podbor/nissan" class="partbtn__link">Оригинальный каталог</a></li>
                        <li class="nav-item m-1 py-2"><a href="/podbortecdoc/80" class="partbtn__link">Неоригинальный каталог</a></li>
                </ul>
                <button class="partbtn__btn btn navbar-toggler" type="button" data-toggle="collapse" data-target="#infinity" aria-controls="infinity" aria-expanded="false" aria-label="Toggle catalog"><a href="#"><img src="/images/infiniti_logo.png" alt="infinity" class="align-middle"> Запчасти инфинити <i class="fa fa-sort-desc mx-2 align-top" aria-hidden="true"></i></a></button>
                <ul class="subSignin__list collapse px-1 mx-0" id="infinity">
                    <li class="nav-item m-1 py-2"><a href="/podbor/infinity" class="partbtn__link">Оригинальный каталог</a></li>
                    <li class="nav-item m-1 py-2"><a href="/podbortecdoc/1526" class="partbtn__link">Неоригинальный каталог</a></li>
                </ul>
            </div>
            <div class="cars"><img src="images/cars.png" alt="cars"></div>
        </div>
        <h3 class="d-lg-none my-3">Каталог запчастей ниссан и инфинити. <br>Оригинальные и неоригинальные запчасти. <br>Всегда в наличии.</h3>
    </section>
    <section class="section-2 px-3 pt-5 mx-auto my-3">
        <div id="qsearch">
            <ul class="nav nav-tabs d-flex flex-row nav-justified" role="tablist">
                <li class="nav-item align-middle">
                    <a class="nav-link search-tabs active" href="#vin" aria-controls="home" role="tab" data-toggle="tab">Поиск по VIN</a>
                </li>
                <li class="nav-item align-middle">
                    <a class="nav-link search-tabs" href="#orig" aria-controls="home" role="tab" data-toggle="tab">Поиск в <span class="d-none d-sm-inline">оригинальном</span> каталоге</a>
                </li>
                <li class="nav-item align-middle">
                    <a class="nav-link search-tabs" href="#nalichie" aria-controls="nalichie" role="tab" data-toggle="tab">Поиск по номеру <span class="d-none d-sm-inline">(применимость, аналоги)</span></a>
                </li>
                <!--<li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Поиск в
                        TecDoc</a></li>-->
                <!--<li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Помощь в подборе</a></li>-->
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="vin">
                    <h3 class="search-title">Поиск запчастей по VIN-номеру</h3>
                    @include('widgets.serch.vinsearch')
                </div>
                <div role="tabpanel" class="tab-pane" id="orig">
                    <h3 class="search-title">Поиск запчастей в оригинальном каталоге</h3>
                    @include('widgets.serch.numbersearch')
                </div>
                <div role="tabpanel" class="tab-pane" id="nalichie">
                    <h3 class="search-title">Поиск запчастей в общем каталоге</h3>
                    @include('widgets.serch.tecdocsearchnal')
                </div>
            <!--<div role="tabpanel" class="tab-pane" id="profile">
                    <legend class="top-form-title">Поиск запчастей в общем каталоге</legend>
                    @include('widgets.serch.tecdocsearch')
                    </div>-->
            <!--<div role="tabpanel" class="tab-pane" id="messages">
                    <legend class="top-form-title">Нужна помощь в подборе?</legend>
                    @include('widgets.pomogi')
                    </div>-->
            </div>
        </div>
    </section>
    <section class="section-3 px-3 py-5 my-3 text-center" id="about">
        <div class="d-flex flex-row justify-content-around my-5 mx-0">
            <div class="advantage d-flex flex-column">
                <img src="images/ad1.png" alt="advantage" class="advantage__img mx-auto">
                <p class="advantage__text">Более 100 позиций товаров продаётся ежедневно</p>
            </div>
            <div class="advantage d-flex flex-column">
                <img src="images/ad2.png" alt="advantage" class="advantage__img mx-auto">
                <p class="advantage__text">300 000 запчастей продано за 11 лет нашей работы</p>
            </div>
            <div class="advantage d-flex flex-column">
                <img src="images/ad3.png" alt="advantage" class="advantage__img mx-auto">
                <p class="advantage__text">70% клиентов приходят к нам по рекомендациям</p>
            </div>
            <div class="advantage d-flex flex-column">
                <img src="images/ad4.png" alt="advantage" class="advantage__img mx-auto">
                <p class="advantage__text">3 магазина на Севере и Юге Санкт-Петербурга</p>
            </div>
        </div>
    </section>
    <section class="section-4 section4--gradient d-flex flex-row py-5 my-3" id="trigger">
        <div class="consultation px-3">
            <div class="consultation__title">
                <h3>Нужна консультация по подбору запчастей для Вашего авто?</h3>
                <p>Спрашивайте! Мы с радостью Вам поможем!</p>
            </div>
            <form class="d-flex flex-column" action="{{ action('UserAttachController@Attach') }}" method="post" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="d-flex flex-row">
                <input class="form-control consultation__field" type="text" name="name" placeholder="Ваше имя">
                <input class="form-control consultation__field" type="email" name="email" placeholder="Ваш Email">
            </div>
                <textarea class="form-control consultation__text" name="q" id="subject" rows="3" placeholder="Ваш вопрос"></textarea>
            <div class="g-recaptcha mini consultation__captcha" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
                <button class="btn submit consultation__btn" id="message" type="submit">Отправить</button>
            </form>
        </div>
        <div class="photo d-none d-md-flex flex-row">
            <img src="images/petia.png" alt="photo">
            <small class="photo--comment">Петр Шерстюков. <br>Руководитель отдела продаж.</small>
        </div>
    </section>
    <section class="section-5 px-3 pt-3 my-5" id="shop_map">
        <h1>Наши магазины в <span class="nowrap">Санкт-Петербурге</span></h1>
        <div class="wrap">
            <ul class="nav nav-tabs d-flex flex-row justify-content-between" role="tablist">
                <li class="nav-item w-50 ">
                    <a class="nav-link search-tabs active" href="#map-1" role="tab" data-toggle="tab">На Северном проспекте</a>
                </li>
                <li class="nav-item w-50">
                    <a class="nav-link search-tabs" href="#map-2" role="tab" data-toggle="tab">На <span class="d-none d-sm-inline">проспекте </span>Маршала Жукова</a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="map-1">
                    <div class="wrap d-flex flex-column flex-lg-row">
                        <div class="map-info m-3">
                            <h3 class="map-title">Контактная информация</h3>
                            <p>Адрес: Санкт-Петербург, Северный пр-т, д.5, кор.3, АЦ «Маршал», 2 этаж, секция 209</p>
                            <p>Адрес: Санкт-Петербург, Северный пр-т, д.7, АЦ «Маршал», 1 этаж, секция 54</p>
                            <p>Телефоны: 347-76-09, 972-00-59, 655-06-90</p>
                        </div>
                        <div class="map w-100 w-lg-50 mx-0 my-3 m-lg-3">
                            <iframe class="w-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1993.0893296150523!2d30.332192316397116!3d60.03017198190957!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46963a59355fa6a3%3A0xb30c9b25b4d55833!2z0JzQsNGA0YjQsNC7!5e0!3m2!1sru!2sru!4v1516806253222" height="450" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="map-2">
                    <div class="wrap d-flex flex-column-reverse flex-lg-row">
                        <div class="map w-100 w-lg-50 mx-0 my-3 m-lg-3">
                            <iframe class="w-100" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127881.1928868754!2d30.226926589182497!3d59.946351122000465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46963a5eb5c078d1%3A0xcbaa35808ce65341!2z0JDQstGC0L7RhtC10L3RgtGAICLQnNCw0YDRiNCw0Lsi!5e0!3m2!1sru!2sru!4v1516806044952" height="450" style="border:0" allowfullscreen></iframe>
                        </div>
                        <div class="map-info m-3">
                            <h3 class="map-title">Контактная информация</h3>
                            <p>Адрес: Санкт-Петербург, пр-т Маршала Жукова, д.21, АЦ «Маршал», 1 этаж, секция 18</p>
                            <p>Телефоны: 347-86-87, +7(921) 922-07-39</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Видео о компании -->
    {{--<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">--}}
        {{--<div class="modal-dialog" role="document">--}}
            {{--<div class="modal-content">--}}
                {{--<div class="modal-header">--}}
                    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span--}}
                                {{--aria-hidden="true">&times;</span></button>--}}
                    {{--<h4 class="modal-title" id="myModalLabel">Посмотрите видео нашем магазине</h4>--}}
                {{--</div>--}}
                {{--<div class="modal-body">--}}
                    {{--<iframe width="560" height="315" src="https://www.youtube.com/embed/nQQfNtE9VlE" frameborder="0"--}}
                            {{--allowfullscreen></iframe>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
@endsection

@section('footer.after_scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endsection
