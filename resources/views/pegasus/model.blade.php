@extends('layouts/app')

{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop

@section('breadcrumbs')
    <div class="breadcum">
        {!! Breadcrumbs::render('model',$mark) !!}
    </div>
@stop
@section('content')
    <!---------------TECDOC NISSAN/INFINITY model list--------------->
    <section class="section-1 container px-3 py-5 my-3">
        <h1>Список моделей</h1>
        <div class="card w-100 d-block p-3">
            <div class="card-body text-center">
{{--{!! dd($models); !!}--}}
                <div class="clearfix">
                    @foreach($models as $model)
                        <div class="d-inline-block col-sm-3 col-lg-2 mx-0 px-2 py-1 text-left" >
                            {{--<div style="width: 100%;height: 90px;padding: 5%"> <img src="/images/nissan/{{$model['modelId']}}.png" width="100%"/></div>--}}
                            <a class="catLink catLink__link" href="{{ url('podbortecdoc/'.$mark.'/'.$model['modelId']) }}">{{$model['modelname']}} </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@stop
@section('footer_scripts')
@stop


