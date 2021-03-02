@extends('layouts/app')

{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
@section('header_styles')


@section('breadcrummbs')
    <div class="breadcum">
        {{--{!! Breadcrumbs::renderArray('spares',[$marks,$models,$types,$STR_ID]) !!}--}}
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
                <?php
                Cache::pull('DataAnalog');
                $Analog = [];
                ?>
                <table id="table1" class="table table-striped table-bordered col-md-10">
                    <thead>
                    <tr>
                        <th>Производитель</th>
                        <th>Номер</th>
                        <th>Название</th>
                        <th>Цена(при наличии на складе)</th>
                        <th></th>
                        {{--<th></th>--}}
                    </tr>
                    </thead>
                    <tbody>

                    @foreach( $Spares AS $Spare )
                        @if($Spare->BRAND == 'NISSAN' || $Spare->BRAND == 'INFINITI')
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
                                {{--<td><a href="{!!route('search.podbor',[$Spare->BRAND,$Spare->NUMBER,$Spare->ART_COMPLETE])!!}">Посмотреть аналоги</a> </td>--}}

                            </tr>
                        @endif

                    @endforeach
                    </tbody>
                </table>

                {{--{!! dd(Cache::get('DataAnalog') )!!}--}}
            </div>
        </div>
        <div class="panel panel-primary filterable">
            <div class="panel-heading clearfix  ">
                <div class="panel-title pull-left">
                    <div class="caption">
                        <i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Применимость
                    </div>
                </div>
            </div>
            <div class="panel-body table-responsive">

                <table id="table1" class="table table-striped table-bordered ">
                    <thead>
                    <tr>
                        <th>Марка</th>
                        <th>Модель</th>
                        <th>Модификация</th>
                        <th>Двигатель</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach( $prim AS $pri )

                        <tr>
                            <td>{!! $pri['MFA_BRAND']!!}</td>
                            <td>{!! $pri['MOD_CDS_TEXT']!!}</td>
                            <td>{!!$pri['TYP_CDS_TEXT']!!}  </td>
                            <td>{!!$pri['ENG_CODE']!!}  </td>
                        </tr>


                    @endforeach
                    </tbody>
                </table>

                {{--{!! dd(Cache::get('DataAnalog') )!!}--}}
            </div>
        </div>

        <div class="panel panel-primary filterable">
            <div class="panel-heading clearfix  ">
                <div class="panel-title pull-left">
                    <div class="caption">
                        <i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                        Аналоги  {!! $named !!}
                    </div>
                </div>
            </div>
            <div class="panel-body table-responsive">

                <table id="table1" class="table table-striped table-bordered ">
                    <thead>
                    <tr>
                        <th>Производитель</th>
                        <th>Номер</th>
                        <th>Цена</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach( $analog AS $Spare )

                        <tr>
                            <td>{!! $Spare['BRAND']!!}</td>
                            <td>{!! $Spare['NUMBER']!!}</td>
                            <td>{!!$Spare['price']!!}  </td>
                            <td>

                                <form class="form-inline" action="{{ action('CartController@postAddToCart') }}" name="add_to_cart" method="post" accept-charset="UTF-8">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="title" value="{!! $named !!}" />
                                    <input type="hidden" name="orignumber" value="{{$Spare['NUMBER']}}" />
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

                {{--{!! dd(Cache::get('DataAnalog') )!!}--}}
            </div>
        </div>

        @stop

        {{-- Body Bottom confirm modal --}}
        {{-- page level scripts --}}
        @section('footer_scripts')
            <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
@stop

