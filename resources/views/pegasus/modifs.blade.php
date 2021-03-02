@extends('layouts/app')
{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
{{--@include('header.styles_tecdoc')--}}
@section('breadcrumbs')
    <div class="breadcum">
        {!! Breadcrumbs::render('modif',$mark,$model) !!}
    </div>
@stop
{{-- Page content --}}
@section('content')
    <!---------------TECDOC NISSAN/INFINITY model list(2nd page)--------------->
    <section class="section-1 container px-3 py-5 my-3">
        <h1>Список моделей</h1>
        <div class="card card--scroll w-100 d-block px-0 py-3">
            <div class="card-body px-0">
                <table class="table table--group mx-0 mx-xl-auto">
                    <thead>
                        <tr>
                            <th class="d-block d-lg-none"></th>
                            <th class="align-middle">Модель</th>
                            <th class="align-middle">Кузов</th>
                            <th class="align-middle">Привод</th>
                            <th class="align-middle">Двигатель</th>
                            <th class="align-middle">Объем <br>дв</th>
                            <th class="align-middle">Кол-во <br>цилиндров</th>
                            <th class="align-middle">Мощность</th>
                            <th class="align-middle">Год <br>выпуска</th>
                            <th class="d-none d-lg-block"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $modifs AS $modif )
                            <tr>
                                <td class="d-block d-lg-none"><a class="catLink__link" href="{!!route('maintree',['manuId'=>$mark,'modId'=>$model,'carId'=>$modif['carId']]) !!}">запчасти</a></td>
                                <td>  {!! $modif['manuName'] !!}   {!!$modif['modelName'] !!}{!!$modif['typeName'] !!}  </td>
                                <td>  {!! $modif['constructionType'] !!}</td>
                                <td>  {!! $modif['impulsionType'] !!}</td>
                                <td>  {!! $modif['motorType'] !!}</td>
                                <td>  {!! $modif['cylinderCapacityCcm'] !!}</td>
                                <td>  {!! $modif['cylinder'] !!}</td>
                                <td>  {!! $modif['powerHpFrom'] !!}/{!! $modif['powerHpTo'] !!}</td>
                                <td>  {!! $rest = substr($modif['yearOfConstrFrom'], 0, 4) !!}</td>
                                <td class="d-none d-lg-block"><a class="catLink__link" href="{!!route('maintree',['manuId'=>$mark,'modId'=>$model,'carId'=>$modif['carId']]) !!}">запчасти</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@stop
@section('footer_scripts')
    {{--@include('footer.script_tecdoc')--}}
@stop


