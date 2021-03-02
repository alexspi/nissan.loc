@extends('layouts/app')

{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
@include('header.header_yamaps')
@section('header_styles')

@stop
@section('top')
    <div class="breadcum">
        <div class="pull-right">
            <i class="livicon icon3" data-name="edit" data-size="20" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i> Каталог
        </div>
    </div>
@stop

{{-- Page content --}}
@section('content')
            <div class="content">
                    <h3 class="inner-main-title">Каталог неоригинальных запчастей Nissan</h3>
                    <div class="row">
                        <?php $groupe = ""; ?>
                        @foreach($Models as $model)
                            <?php if ($model->groupe == $groupe) continue;
                            
                            if (file_exists('images/nissan/' . $model->MOD_ID . '.png')) {
                                $img = 'images/nissan/' . $model->MOD_ID . '.png';
                            } else {
                                $img = 'images/nissan/Nissan.png';
                            };  ?>
                            <div class="col-md-4 popular-models" style="margin: 30px 0; height: 100px;">
                                <a style="display: block;" href="/nissan/{!! $model->groupe !!}">
                                    <img src="{!! $img!!}">
                                    <span>Nissan {!! $model->groupe !!}</span>
                                </a>
                            </div>
                            <?php $groupe = $model->groupe;?>
                        @endforeach
                    </div>
                            <a class="btn btn-default" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                Показать все модели
                            </a>
                            <div class="collapse" id="collapseExample">
                                <div class="row">
                                    <?php $groupe = ""; ?>
                                    @foreach($Modelns as $modeln)
                                        <?php if ($modeln->groupe == $groupe) continue;
        
                                        if (file_exists('images/nissan/' . $modeln->MOD_ID . '.png')) {
                                            $img = 'images/nissan/' . $modeln->MOD_ID . '.png';
                                        } else {
                                            $img = 'images/nissan/no-car.png';
                                        };  ?>
                                        <div class="col-md-4 popular-models" style="margin: 30px 0; height: 100px;">
                                                <a style="display: block;" href="/nissan/{!! $modeln->groupe !!}">
                                                    <img src="{!! $img!!}">
                                                    <span>Nissan {!! $modeln->groupe !!}</span>
                                                </a>
                                        </div>
                                        <?php $groupe = $modeln->groupe;?>
                                    @endforeach
                                </div>
                            </div>
            </div>
        <div class="row">
        
        </div>
    </div>
@stop

{{-- Body Bottom confirm modal --}}
{{-- page level scripts --}}
@section('footer_scripts')
@stop
