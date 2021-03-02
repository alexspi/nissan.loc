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
        <h1>Список моделей</h1>
        <div class="table__wrapper">
            <table class="table table-bordered mx-0">
                <thead>
                    <tr>
                        <th>Модель</th>
                        <th>Модификации</th>
                        <th>Период производства</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $aModels AS $_v )
                        <tr onclick="window.location.href ='{{$url}}/{{$_v->series}}';">
                            <td><a class="catLink__link" href="{{$url}}/{{$_v->series}}">{{$_v->model}}</a></td>
                            <td><a class="catLink__link" href="{{$url}}/{{$_v->series}}">{{$_v->series}}</a></td>
                            <td>{!! $_v->date !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@stop
{{-- Body Bottom confirm modal --}}
{{-- page level scripts --}}
@section('footer_scripts')

@stop