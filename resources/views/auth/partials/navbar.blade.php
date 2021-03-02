<!-- Authentication Links -->
@if (Auth::guest())
        <button class="topSignin__btn btn mt-0" type="button" id="log-reg" data-toggle="collapse" data-target="#Signin" aria-controls="Signin" aria-expanded="false" aria-label="Toggle signin"><i class="fa fa-user-o mx-1" aria-hidden="true"></i> Личный кабинет<i class="fa fa-sort-desc mx-2 align-top" aria-hidden="true"></i></button>
        <ul class="topSignin__list collapse px-0" aria-labelledby="log-reg" id="Signin">
            <li class="nav-item"><a href="{{ url('/login') }}" class="nav-link">Вход</a></li>
            <li class="nav-item"><a href="{{ url('/register') }}" class="nav-link">Регистрация</a></li>
        </ul>
@else
    <button class="topSignin__btn btn mt-0" type="button" id="log-reg" data-toggle="collapse" data-target="#Signin" aria-controls="Signin" aria-expanded="false" aria-label="Toggle signin"><i class="fa fa-user-o mx-1" aria-hidden="true"></i> {{ Auth::user()->first_name }}<i class="fa fa-sort-desc mx-2 align-top" aria-hidden="true"></i></button>
    <ul class="topSignin__list collapse px-0" role="menu" aria-labelledby="log-reg" id="Signin">
        @if(Auth::user()->hasRole('administrator'))
            <li class="nav-item"><a href="{{ url('/admin') }}" class="nav-link">Админка</a></li>
        @endif
        <li class="nav-item"><a href="{{ url('/logout') }}" class="nav-link"><i class="fa fa-btn fa-sign-out mx-1"></i>Выйти</a></li>
        <li class="nav-item"><a href="{{ url('/profile') }}" class="nav-link">Профиль</a></li>
    </ul>
@endif