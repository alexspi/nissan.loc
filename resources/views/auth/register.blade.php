@extends('layouts.app')
@section('header.header_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.1.1/css/mdb.min.css">
@endsection
@section('head')
    <!--<link rel="stylesheet" href="/assets/css/register.css">-->
    <link rel="stylesheet" href="/assets/css/parsley.css">
@stop

@section('content')
    <section class="section-1 container px-0 py-5 my-3">
        <div class="card p-3 mx-auto">
            {{--<div class="panel-heading">Регистрация</div>--}}
            @include('includes.errors')
            <div class="card-header my-0 py-0">
                <h3 class="card-title">Регистрация</h3>
            </div>
            <div class="card-body">
                {!! Form::open(['url' => url('register'), 'class' => 'form-signin', 'data-parsley-validate' ] ) !!}
                <div class="input-group d-flex flex-column mx-2">
                    <label for="inputEmail">Email </label>
                    {!! Form::email('email', null, [
                            'class'                         => 'input-field__input mb-2',
                            'placeholder'                   => '',
                            'required',
                            'id'                            => 'inputEmail',
                            'data-parsley-required-message' => 'Email is required',
                            'data-parsley-trigger'          => 'change focusout',
                            'data-parsley-type'             => 'email'
                        ]) !!}

                    <label for="inputFirstName">Имя</label>
                    {!! Form::text('first_name', null, [
                            'class'                         => 'input-field__input mb-2',
                            'placeholder'                   => '',
                            'required',
                            'id'                            => 'inputFirstName',
                            'data-parsley-required-message' => 'First Name is required',
                            'data-parsley-trigger'          => 'change focusout',
                            'data-parsley-pattern'          => '/^[a-zA-Zа-яА-Я]*$/',
                            'data-parsley-minlength'        => '2',
                            'data-parsley-maxlength'        => '32'
                        ]) !!}

                    <label for="inputLastName">Фамилия</label>
                    {!! Form::text('last_name', null, [
                            'class'                         => 'input-field__input mb-2',
                            'placeholder'                   => '',

                            'id'                            => 'inputLastName',
                            'data-parsley-required-message' => 'Last Name is required',
                            'data-parsley-trigger'          => 'change focusout',
                            'data-parsley-pattern'          => '/^[a-zA-Zа-яА-Я]*$/',
                            'data-parsley-minlength'        => '2',
                            'data-parsley-maxlength'        => '32'
                        ]) !!}


                    <label for="inputPassword">Пароль</label>
                    {!! Form::password('password', [
                            'class'                         => 'input-field__input mb-2',
                            'placeholder'                   => '',
                            'required',
                            'id'                            => 'inputPassword',
                            'data-parsley-required-message' => 'Password is required',
                            'data-parsley-trigger'          => 'change focusout',
                            'data-parsley-minlength'        => '6',
                            'data-parsley-maxlength'        => '20'
                        ]) !!}


                    <label for="inputPasswordConfirm" class="has-warning">Повторите пароль</label>
                    {!! Form::password('password_confirmation', [
                            'class'                         => 'input-field__input mb-2',
                            'placeholder'                   => '',
                            'required',
                            'id'                            => 'inputPasswordConfirm',
                            'data-parsley-required-message' => 'Password confirmation is required',
                            'data-parsley-trigger'          => 'change focusout',
                            'data-parsley-equalto'          => '#inputPassword',
                            'data-parsley-equalto-message'  => 'Not same as Password',
                        ]) !!}

                    <div class="g-recaptcha mini consultation__captcha consultation__captcha--reg" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
                    <button class="btn but but--reg mt-3 mx-2" type="submit">Регистрация</button>
                    <!--<p class="or-social">Or Use Social Login</p>-->
                    @include('_partials.socials')
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer.after_scripts')

    <script type="text/javascript">
        window.ParsleyConfig = {
            errorsWrapper: '<div></div>',
            errorTemplate: '<small class="note--red"><span class="error-text"></span></small>',
            classHandler: function (el) {
                return el.$element.closest('input');
            },
            successClass: 'valid',
            errorClass: 'invalid'
        };
    </script>

    <script src="/assets/plugins/parsley.min.js"></script>

    <script src='https://www.google.com/recaptcha/api.js'></script>

@endsection