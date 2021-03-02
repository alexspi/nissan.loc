@extends('layouts/app')

{{-- Page title --}}
@section('title')
    Список найденных запчастей
    @parent
@stop

@include('header.styles_tecdoc')
@section('header_styles')


@section('breadcrummbs')
    <div class="breadcum">
        <div class="container">
            {!! Breadcrumbs::renderArray('spares',[$marks,$models,$types,$STR_ID,$STR_ID1,$STR_ID2]) !!}
        </div>
    </div>
@stop
{{-- Page content --}}
@section('content')
    <?php
    $data = Cache::get('DataTree');
    $treet = $data[$STR_ID2];
    ?>
    
    
    <div class="container">
        <div class="row">
            <div class="content">
                
                @if($Spares->count() == 0 )
                    <p>К сожалению на данный момент деталей не найдено в базе заполните форму заявки</p>
                    @include('widgets.pomogi')
                @else
                    <div class="col-md-12">
                        <div class="panel panel-primary filterable">
                            <div class="panel-heading clearfix  ">
                                <div class="panel-title pull-left">
                                    <div class="caption">
                                        <i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                        Запчасти
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                                <?php
                                //                           Cache::pull('DataAnalog');
                                $data = Cache::get('DataTree');
                                $treet = $data[$STR_ID2];
                                ?>
                                <table id="table1" class="table table-striped table-bordered col-md-10">
                                    <thead>
                                    <tr>
                                        <th>Номер</th>
                                        <th>Производитель</th>
                                        <th>Название</th>
                                        <th>Описание</th>
                                        <th>Статус</th>
                                    
                                    </tr>
                                    </thead>
                                    <tbody>
                                    
                                    @foreach( $Spares AS $Spare )
                                        
                                        <?php
                                        $Analog = [];
                                        $SpareN = $Spare->LA_ART_ID;
                                        $InfoDetails = Helper::GetSparesName($SpareN);
                                        $InfoCriterias = Helper::GetSparesNameCrit($SpareN);
                                        $InfoAnalogs = Helper::GetSparesAnalog($SpareN, $Analog);?>
                                        @foreach($InfoDetails as $InfoDetail)
                                            
                                            <tr>
                                                <td>{!! $InfoDetail->ART_ARTICLE_NR!!}</td>
                                                <td>{!! $InfoDetail->SUP_BRAND!!}</td>
                                                <td>{!! $InfoDetail->ART_COMPLETE_TEXT!!}</td>
                                                <td> @if($InfoCriterias->count() != 0)
                                                        
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#{!! $SpareN !!}">Инфо</button>
                                                        
                                                        <div id="{!! $SpareN !!}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title" id="myModalLabel">Описание детали</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <table class="table table-striped table-bordered">
                                                                            @foreach($InfoCriterias as $InfoCriteria)
                                                                                <tr>
                                                                                    <td>{!! $InfoCriteria->CRITERIA_DES_TEXT!!}</td>
                                                                                    <td>{!! $InfoCriteria->CRITERIA_VALUE_TEXT!!}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </table>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                    
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{!! $InfoDetail->ART_STATUS_TEXT!!}</td>
                                            
                                            </tr>
                                        
                                        @endforeach
                                    @endforeach
                                    </tbody>
                                </table>
                            
                            </div>
                        </div>
                    
                    </div>
                    <div class="col-md-12">
                        <div class="panel panel-primary filterable">
                            <div class="panel-heading clearfix  ">
                                <div class="panel-title pull-left">
                                    <div class="caption">
                                        <i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                        Номера оригиналов
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body table-responsive">
                               
                                
                                @if($InfoAnalogs == null)
                                    В базе не наидено оригинала
                                @else
                                    
                                    <table class="table table-striped table-bordered">
                                        
                                        @foreach($InfoAnalogs as $key=>$value)
                                            @if( is_array($value) == false)
                                                <tr>
                                                    <td>{!! $key!!}</td>
                                                    <td>{!! $value!!}</td>
                                                    <td><?php $InfoPrice = Helper::CatalogItemPrice($key);?>
                                                        {!!$InfoPrice!!}
                                                    </td>
                                                    <td>
                                                        <form class="form-inline" action="{{ action('CartController@postAddToCart') }}" name="add_to_cart" method="post" accept-charset="UTF-8">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <input type="hidden" name="title" value="{!! $treet !!}"/>
                                                            <input type="hidden" name="orignumber" value="{{$key}}"/>
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
                                            @endif
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
            </div>
    @endif
@stop

@include('footer.script_tecdoc')
