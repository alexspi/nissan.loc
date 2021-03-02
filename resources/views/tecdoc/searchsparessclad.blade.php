@extends('layouts/app')

{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
@section('header_styles')


@section('breadcrummbs')
    <div class="breadcum">
        <div class="container">
            {{--{!! Breadcrumbs::renderArray('spares',[$marks,$models,$types,$STR_ID]) !!}--}}
        </div>
    </div>
@stop
{{-- Page content --}}
@section('content')


    <div class="container">
        <div class="row">
            <div class="content">
                <div class="col-md-12">
                    <div class="panel panel-primary filterable">
                        <div class="panel-heading clearfix  ">
                            <div class="panel-title pull-left">
                                <div class="caption">
                                    <i class="livicon" data-name="camera-alt" data-size="16" data-loop="true"
                                       data-c="#fff" data-hc="white"></i>
                                    {{--{!! $named !!}--}}
                                </div>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">

                            @if($nalichie->count() != null)
                                <table id="table1" class="table table-striped table-bordered col-md-10">
                                    <thead>
                                    <tr>
                                        <th>Номер</th>
                                        <th>Название</th>
                                        <th>Цена</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach( $nalichie AS $nal )

                                        <tr>
                                            <td>{!! $nal->number!!}</td>
                                            <td>{!! $nal->name!!}</td>
                                            <td>{!! $nal->price!!}</td>
                                            <td>

                                                <form class="form-inline"
                                                      action="{{ action('CartController@postAddToCart') }}"
                                                      name="add_to_cart" method="post" accept-charset="UTF-8">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="title" value="{!! $nal->name !!}"/>
                                                    <input type="hidden" name="orignumber" value="{{$nal->NUMBER}}"/>
                                                    <select name="amount" class="form-control span1 inline">
                                                        <option value="1" selected>1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                    <button class="btn btn-info inline" type="submit">В корзину</button>
                                                </form>

                                            </td>

                                        </tr>


                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                К сожаления на складе нет
                                @if($Spares->count() != null)
                                    <table id="table1" class="table table-striped table-bordered col-md-10">
                                        <thead>
                                        <tr>
                                            <th>Производитель</th>
                                            <th>Номер</th>
                                            <th>Название</th>
                                            <th>Цена(при наличии на складе)</th>
                                            <th></th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                    @foreach( $Spares AS $Spare )
                                        <?php

                                        $TitleSpares = $Spare->ART_COMPLETE;?>
                                        <tr>
                                            <td>{!! $Spare->BRAND!!}</td>
                                            <td>{!! $Spare->NUMBER!!}</td>
                                            <td>{!! $Spare->ART_COMPLETE!!}</td>
                                            <td><?php $InfoPrice = Helper::CatalogItemPrice($Spare->NUMBER);?>
                                                {!!$InfoPrice!!}
                                            </td>
                                            <td>

                                                <form class="form-inline" action="{{ action('CartController@postAddToCart') }}" name="add_to_cart" method="post" accept-charset="UTF-8">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="title" value="{!! $Spare->ART_COMPLETE !!}" />
                                                    <input type="hidden" name="orignumber" value="{{$Spare->NUMBER}}" />
                                                    <select name="amount" class="form-control span1 inline">
                                                        <option value="1" selected>1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                    <button class="btn btn-info inline" type="submit">В корзину</button>
                                                </form>

                                            </td>


                                        </tr>


                                    @endforeach
                                        </tbody>
                                    </table>

                                @endif
                            @endif

                            @if($SparesSovmest !== null)
                                <table id="table1" class="table table-striped table-bordered col-md-10">
                                    <thead>
                                    <tr>
                                        <th>Марка</th>
                                        <th>Модель</th>
                                        <th>Модификация</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach( $SparesSovmest AS $Spare )

                                        <tr>
                                            <td>{!! $Spare->MFA_BRAND!!}</td>
                                            <td>{!! $Spare->MOD_CDS_TEXT!!}</td>
                                            <td>{!! $Spare->TYP_CDS_TEXT!!}</td>


                                        </tr>


                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                По вашему запросу ничего не найдено проверьте правильность написания
                                @include('widgets.serch.tecdocsearchnal')
                            @endif
                            {{--{!! dd(Cache::get('DataAnalog') )!!}--}}
                        </div>
                    </div>

                </div>
                <div class="col-md-4">

                </div>
            </div>
            @stop

            {{-- Body Bottom confirm modal --}}
            {{-- page level scripts --}}
            @section('footer_scripts')
                <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
@stop

