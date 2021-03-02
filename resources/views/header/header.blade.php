@include('_partials.above-navbar-alert')
<nav class="navbar navbar-expand-lg navbar-dark d-block sticky-top p-0 mx-0">
    <div class="topSingin d-none d-lg-flex  flex-row-reverse justify-content-between ml-3 mr-0 mt-0">
        @include('auth.partials.navbar')
        @if(!Auth::check())
            <p class="topSignin__warn my-auto">Следите за своими покупками в личном кабинете. Регистрируйтесь</p>
        @endif
    </div>
    <div class="infotop d-none d-lg-flex justify-content-between mx-0 p-3">
        <div class="d-flex flex-row">
            <i class="infotop__marker fa fa-3x fa-map-marker" aria-hidden="true"></i>
            <p class="infotop__text">Северный пр-т, д.5., <br>
                2 этаж, секция 209</p>
        </div>
        <div class="d-flex flex-row">
            <i class="infotop__marker fa fa-3x fa-map-marker" aria-hidden="true"></i>
            <p class="infotop__text">Северный пр-т, д.7., <br>
                1 этаж, секция 54</p>
        </div>
        <div class="d-flex flex-row">
            <i class="infotop__marker fa fa-3x fa-map-marker" aria-hidden="true"></i>
            <p class="infotop__text">Пр-т. М.Жукова, д.21., <br>
                1 этаж, секция 18</p>
        </div>
        <div class="d-flex flex-row">
            <i class="infotop__marker fa fa-3x fa-clock-o" aria-hidden="true"></i>
            <p class="infotop__text">Пн-Пт: 10<sup>00</sup>-19<sup>00</sup> <br>
                Cб-Вс: 10<sup>00</sup>-18<sup>00</sup></p>
        </div>
        <div>
            <p class="infotop__text infotop__text--tel">+7(812) 347-76-09 <br>
                +7(812) 972-00-59 <br>
                +7(812) 347-86-87</p>
        </div>
    </div>
    <!--OLD MENU-->
    <button class="navbar-toggler m-1" type="button" data-toggle="collapse" data-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
    <div class="menu collapse navbar-collapse d-lg-flex flex-column flex-lg-row justify-content-between" id="menu">
        <ul class="navbar-nav d-lg-flex flex-column flex-lg-row my-auto">
            <li class="nav-item subSignin__btn d-block d-lg-none mt-3 mt-lg-auto" data-toggle="collapse" data-target="#subSignin" aria-controls="Signin" aria-expanded="false" aria-label="Toggle signin"><a class="nav-link mt-0 ml-1"><i class="fa fa-user-o mx-1" aria-hidden="true"></i> Личный кабинет<i class="fa fa-sort-desc mx-2 align-top" aria-hidden="true"></i></a>
                <ul class="subSignin__list collapse mx-0" id="subSignin">
                    @if (Auth::guest())
                    <li class="nav-item"><a href="{{ url('/login') }}" class="nav-link">Войти</a></li>
                    <li class="nav-item"><a href="{{ url('/register') }}" class="nav-link">Регистрация</a></li>
                    @else
                        @if(Auth::user()->hasRole('administrator'))
                            <li class="nav-item"><a href="{{ url('/admin') }}" class="nav-link">Админка</a></li>
                        @endif
                        <li class="nav-item"><a href="{{ url('/logout') }}" class="nav-link"><i class="fa fa-btn fa-sign-out mx-1"></i>Выйти</a></li>
                        <li class="nav-item"><a href="{{ url('/profile') }}" class="nav-link">Профиль</a></li>
                    @endif
                </ul>
            </li>
                    @if ($menu_items->count())
                        @foreach ($menu_items as $k=>$menu_item)
                            @include('layouts.inc.partials.menu', $menu_item)
                        @endforeach
                    @endif
            <li class="nav-item d-block d-lg-none px-2"><a href="{{ url('/cart') }}" class="nav-link"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Корзина <span>{!! Cart::instance('shopping')->count() !!}</span></a></li>

        </ul>
        <a href="{{ url('/cart') }}" class="cart nav-link d-none d-lg-block"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Корзина <span>{!! Cart::instance('shopping')->count() !!}</span></a>

    </div><!--NEW MENU-->

    </nav>
