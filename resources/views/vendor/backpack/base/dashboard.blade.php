@extends('backpack::layout')
@section('after_styles')
    
    {!! Charts::assets() !!}
@endsection
@section('header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::base.dashboard') }}<small>{{ trans('backpack::base.first_page_you_see') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix', 'admin')) }}">{{ config('backpack.base.project_name') }}</a></li>
            <li class="active">{{ trans('backpack::base.dashboard') }}</li>
        </ol>
    </section>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <div class="box-title">{{ trans('backpack::base.login_status') }}</div>
                </div>
                
                <div class="box-body">{{ trans('backpack::base.logged_in') }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <span class="info-box-number">{!! $attach->render() !!}</span>
                </div>
                
                <div class="clearfix visible-sm-block"></div>
                
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <span class="info-box-number">{!! $order->render() !!}</span>
                
                </div>
                
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <span class="info-box-number">{!! $user->render() !!}</span>
                </div>
                <!-- /.col -->
            </div>
        
        </div>
    </div>
@endsection
