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

            <i class="livicon icon3" data-name="edit" data-size="20" data-loop="true" data-c="#3d3d3d"
               data-hc="#3d3d3d"></i> Каталог
        </div>
    </div>
@stop

{{-- Page content --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="content">
                <div class="col-md-12">


                    @if($msg !== null){
                    <h2>{{$msg}}</h2>

                    @else
                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th>Рынок</th>
                                <th>Марка</th>
                                <th>Модель</th>
                                <th>Год</th>
                                <th>Название</th>
                                <th>Ссылка</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $Result AS $item )
                                <tr>
                                    <td>{!! $item['market']!!}</td>
                                    <td>{!! $item['mark'] !!}</td>
                                    <td>{!! $item['model'] !!}</td>
                                    <td>{!! $item['date'] !!} </td>
                                    <td>{!! $item['partname'] !!} </td>
                                    <td><a href=" {!! $item['url'] !!}">Перейти</a> </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>


@stop

{{-- Body Bottom confirm modal --}}
{{-- page level scripts --}}
@section('footer_scripts')
@stop