@extends('layouts/app')

{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop

@include('header.styles_tecdoc')

@section('breadcrummbs')
    <div class="breadcum">
            {!! Breadcrumbs::renderArray('type',[$marks,$Models]) !!}
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
                                    <th>Название модели</th>
                                    <th>Начало/Конец Выпуска</th>
                                    <th>Объём двигателя (куб.см)</th>
                                    <th>Мощность двигателя (л.с.): ОТ/ДО</th>
                                    <th>Количество цилиндров</th>
                                    <th>Код двигателя</th>
                                    <th>Тип топлива</th>
                                    <th>Вид сборки</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($types AS $type)
                                    {{--{{dd($typemodel)}}--}}
                               <?php $_url =  "/podbortecdoc/{$marks}/{$Models}/{$type->TYP_ID}"?>
                                <tr onclick="window.location.href ='<?=$_url?>'">
                                    <td><a href="<?=$_url?>">{!!$type->MFA_BRAND !!}/{!!$type->MOD_CDS_TEXT !!}/{!!$type->TYP_CDS_TEXT !!}</a></td>
                                    <td><?php $DateStart = Helper::DateModif($type->TYP_PCON_START);?>
                                        {!!$DateStart!!}/<?php $DateEnd = Helper::DateModif($type->TYP_PCON_END);?>
                                        {!!$DateEnd!!}</td>
                                    <td>{!!$type->TYP_CCM !!}</td>
                                    <td>{!!$type->TYP_HP_FROM !!}/{!!$type->TYP_HP_UPTO !!}</td>
                                    <td>{!!$type->TYP_CYLINDERS !!}</td>
                                    <td>{!!$type->ENG_CODE !!}</td>
                                    <td>{!!$type->TYP_ENGINE_DES_TEXT !!}
                                        {{--/{!!$type->TYP_FUEL_DES_TEXT !!}--}}
                                    </td>
                                    <td>{!!$type->TYP_BODY_DES_TEXT !!}</td>

                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <?php echo $types->render(); ?>
                        </div>
                    </div>
            </div>
        @stop

@section('footer_scripts')
    @include('footer.script_tecdoc')
@stop
