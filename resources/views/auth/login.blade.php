@extends('layouts.app')
@section('header.header_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.1.1/css/mdb.min.css">
    @endsection
@section('content')
    <section class="section-1 container px-0 py-5 my-3">
        <div class="card p-3 mx-auto">
            <div class="card-header my-0 py-0">
                <h3 class="card-title">Вход</h3>
            </div>
            <div class="card-body">
                <form role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}
                    <div class="input-group d-flex flex-column mx-2">
                        <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email">Email</label>
                                    <input class="input-field__input form-control mb-2" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                        @endif
                                </div>
                        <div class="{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password">Пароль</label>
                                    <input class="input-field__input form-control mb-2" type="password" id="password" name="password" required>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                </div>
                    </div>
                    <div class="d-flex flex-row mx-2">
                        <input class="input-field__check mr-1" type="checkbox" name="remember" id="remember">
                        <label for="remember"><small>Запомнить</small></label>
                    </div>
                    <button class="btn but but--sub mx-2" type="submit">Войти</button>
                    <a href="{{ url('/password/reset') }}"><small>Забыли пароль?</small></a>
                    @include('_partials.socials')
                </form>
            </div>
        </div>
    </section>
@endsection
