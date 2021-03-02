@extends('mail/layouts/default')

@section('content')
<p>Здравствуйте  {!! $user !!} </p>
<p>Вы зарегистрировались на сайте Nissan209</p>
<p>Для входа в кабинет используйте</p>
<p>login:{!! $login !!} </p>
<p>password:  {!! $pass !!}</p>


@stop
