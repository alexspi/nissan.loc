@extends('layouts/app')

{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
@section('header_styles')

@stop
@section('top')
    <div class="breadcum">
        <div class="container">
         
                <i class="livicon icon3" data-name="edit" data-size="20" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i> Каталог
            
        </div>
    </div>
@stop

{{-- Page content --}}
@section('content')


    <section class="section-1 container px-3 py-5 my-3">
        <h1>Выберите страну производителя</h1>
        <hr>
        <div class="catLink catLink--country d-flex flex-column flex-md-row justify-content-around my-5">
            <?php foreach( $NISMarkets AS $market=>$v ){ ?>
                <a class="catLink__link" href="{{$url}}/{{$market}}">
                    <img src="{{ URL::to('/images/nissan/markets/'.$market.'.png')}}" alt="country" class="catLink__img align-middle"/><span>{!! $v !!}</span>
                </a>
                <?php } ?>
        </div>
    </section>
@stop

{{-- Body Bottom confirm modal --}}
{{-- page level scripts --}}
@section('footer_scripts')
