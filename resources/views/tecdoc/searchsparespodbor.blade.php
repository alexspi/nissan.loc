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
                <div class="col-md-8">
                    <div class="panel panel-primary filterable">
                        <div class="panel-heading clearfix  ">
                            <div class="panel-title pull-left">
                                <div class="caption">
                                    <i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                    {!! $named !!}
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
                                    <th>Статус</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach( $SparesAnalogRezult AS $Spare )

                                        <tr>
                                            <td>{!! $Spare->BRAND!!}</td>
                                            <td>{!! $Spare->NUMBER!!}</td>
                                            <td><?php $InfoPrice = Helper::CatalogItemPrice($Spare->NUMBER);?>
                                                {!!$InfoPrice!!}
                                            </td>
                                            <td>
    
                                                <form class="form-inline" action="{{ action('CartController@postAddToCart') }}" name="add_to_cart" method="post" accept-charset="UTF-8">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="title" value="{!! $named !!}" />
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

