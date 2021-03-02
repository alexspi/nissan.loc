@extends('layouts/app')
{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
{{--@include('header.styles_tecdoc')--}}

@section('breadcrumbs')
    <div class="breadcum">
        {{--{!! dd($mark,$model,$modifs,$maintree,$parentNodeId,$GroupNodeId) !!}--}}

        {!! Breadcrumbs::render('pgspares',$mark,$model,$modifs,$maintree,$parentNodeId,$GroupNodeId) !!}
    </div>
@stop

{{-- Page content --}}
@section('content')
    <!---------------TECDOC NISSAN/INFINITY model list(5th page)--------------->
    <section class="section-1 container px-3 py-5 my-3">
        <h1>Категории запчастей</h1>
        <div class="card card--scroll w-100 d-block py-3 px-0">
            <div class="card-body mx-0 px-0">
                <table class="table table--group mx-0 mx-xl-auto">
                    <thead>
                    <tr>
                        <th class="align-middle">Номер</th>
                        <th class="align-middle">Производитель</th>
                        <th class="align-middle">Название</th>
                        <th class="align-middle">Описание</th>
                        <th class="align-middle">Статус</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach( $Spares AS $Spare )
                            <tr>
                                <td>{!! $Spare['articleNo']!!}</td>
                                <td>{!! $Spare['brandName']!!}</td>
                                <td>{!! $Spare['genericArticleName']!!}</td>
                                <td> <a class="catLink__link" href="{!!route('pgsparesinfo',[$mark,$model,$modifs,$maintree,$parentNodeId,$GroupNodeId,$Spare['articleId'],$Spare['articleLinkId'],$Spare['brandName']])!!}">Подробности </a> </td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{--{!! dd(Cache::get('DataAnalog') )!!}--}}
            </div>
        </div>
    </section>
@stop
@section('footer_scripts')
    @include('footer.script_tecdoc')
@stop