@extends('mail/layouts/default')

@section('content')
    <p>Hello ,</p>

    <p>We have received a new contact mail.</p>

    <p>The provided details are:</p>

{!! $Order_catalog !!}

@stop
