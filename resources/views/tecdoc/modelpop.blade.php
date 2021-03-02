@extends('layouts/app')

{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop

@include('header.styles_tecdoc')

@section('breadcrummbs')
    <div class="breadcum">
        {{--{!! Breadcrumbs::render() !!}--}}
    </div>
@stop

{{-- Page content --}}
@section('content')
            <div class="content">
                    <div class="panel panel-primary filterable">
                        <div class="panel-heading clearfix  ">
                            <div class="panel-title pull-left">
                                <div class="caption">
                                    <i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                    Модельный ряд
                                </div>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">
                            <table id="table1" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Номер модели</th>
                                    <th>Название модели</th>
                                    <th>Начало Выпуска</th>
                                    <th>Конец выпуска</th>
            
                                </tr>
                                </thead>
                                <tbody>
                                @foreach( $Models AS $Model )
                                    <tr onclick="window.location.href ='{!!url($Model->URL) !!}'">
                                        <td><a href="{!!url($Model->URL) !!}">{!!$Model->MOD_ID!!}</a></td>
                                        <td>{!!$Model->MOD_CDS_TEXT!!}</td>
                                        <td>{!!$Model->MOD_PCON_START!!}</td>
                                        <td>{!!$Model->MOD_PCON_END!!}</td>
                
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
            </div>

@stop
@section('footer_scripts')
    {{--@include('footer.script_tecdoc')--}}
@stop


