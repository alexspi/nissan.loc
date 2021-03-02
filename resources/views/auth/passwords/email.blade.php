@extends('layouts.app')

<!-- Main Content -->
@section('content')
    <section class="section-1 container px-0 py-5 my-3">
        <div class="card p-3 mx-auto">
            <div class="card-header my-0 py-0">
                <h3 class="card-title">Восстановление пароля</h3>
            </div>
            <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}
                        <div class="input-group d-flex flex-column m-2{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">Введите ваш email</label>
                            <input class="input-field__input mb-2" id="email" type="email" name="email" value="{{ old('email') }}" required>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <button class="btn but but--sub mx-2" type="submit">Отправить</button>
                    </form>
            </div>
        </div>
    </section>
@endsection
