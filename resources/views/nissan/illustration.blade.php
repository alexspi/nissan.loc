@extends('layouts/app')

{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
@include('header.script_api')
@include('header.styles_api')
@section('breadcrummbs')
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
                    @include('nissan._illu')
                    <div id="detailsMap">


                        <? if(!empty($aErrors) || !empty($msg)){?>
                        <h2>{{$msg}}</h2>
                        <? }else{ ?>

                        <div id="tabs">
                            @php
                            $i = 0;
                            if ($aTCount <= 4) $widthTabs = 24.5;
                            else            $widthTabs = (100 / $aTCount) - 0.5;
                            if ($subFlag) $tabsKeys = array_keys((array)$aTabs);
                            foreach( $aTabs AS $t ){
                            foreach($t as $k=>$tab){ $i++;
                            if ($subFlag && $subfig && $pic) $class = ($subfig == $tab->figure && $pic == $tab->secno) ? " class='activeTab cBlue'" : "";
                            else $class = ($pic == $tab->secno || (!$subfig && !$pic && $i == 1)) ? " class='activeTab cBlue'" : "";  @endphp
                            <a style="width:{{$widthTabs}}%"
                               href="{{$nextSecUrl }}&subfig={{$tab->figure}}&sec={{$tab->secno}}"{{$class}}>Вид {{$i}} </a>
                            @php
                            if (empty($subfig) && (int)$k == 1) $currfig = $tab->figure;
                            if (empty($pic) && (int)$k == 1) $secno = $tab->secno;
                            }
                            if (empty($currfig)) $currfig = $tab->figure; if (empty($secno)) $secno = $tab->secno; //вдруг пусто, встречал такое
                            }
                            //для таблицы адрес нужен, а подфигура и секция в другом массиве(не с деталями)
                            if (empty($subfig)) $subfig = $currfig; if (empty($pic)) $pic = $secno;
                            $nextUrl .= $subfig . '&sec=' . $pic;
                            @endphp
                        </div>

                        <?php $px = 5; $py = 5; ?>

                        <div class="defBorder imgArea mb30" id="imageArea">

                            <div id="imageLayout"
                                 style="position:absolute;left:0;top:0;width:<?=$width?>px;height:<?=$height?>px">
                                <canvas id="canvas" <?=$attrs?>style="margin:0;padding:0;"></canvas>
                                <?php
                                $prevNamber = FALSE;

                                foreach ($aD AS $_v) {
                                /** у инфинити бывает такое, что на последнем уровне с изобр есть еще "секция"*/
                                $title = (strtoupper($market) == 'JP' || empty($_v->desc_en)) ? $_v->number : "$_v->number - $_v->desc_en";
                                $lLeft = $_v->x1 * $prc - $px * $prc;
                                $lTop = $_v->y1 * $prc - $py * $prc;
                                $lWidth = ($_v->x2 * $prc - $lLeft) + $px * $prc * 2;
                                $lHeight = ($_v->y2 * $prc - $lTop) + $py * $prc * 2 - 10;

                                $currNumber = $_v->number;
//                                $number = ($currNumber == $prevNamber) ? $currNumber : $currNumber;
                                $prevNamber = $currNumber;
                                ?>
                                <div id="l{{$_v->number}}" class="l{{$_v->number}} mapLabel"
                                     title="<?= $title ?>"
                                     style="
                                             position:absolute;
                                             left:<?= $lLeft ?>px;
                                             top:<?= $lTop ?>px;
                                             min-width:<?= $lWidth ?>px;
                                             min-height:<?= $lHeight ?>px;
                                             padding:<?= $py ?>px <?= $px ?>px;
                                             "
                                     onclick="labelClick(this,false)"
                                     ondblclick="labelClick(this,true)"
                                >
                                </div>
                                <?php }
                                ?>
                            </div>
                            @include('nissan._zoom')
                        </div>

                        <div id="detailsList">
                            <table class="simpleTable">
                                <thead>
                                <tr>
                                    <th class="NisBttnInfo"></th>
                                    <th class="NisDetailNumber">Номер детали</th>
                                    <th colspan="3">Наименование</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($aD as $item)


                                    @if ($item->type == 0)
                                        <tr id="d{{$item->number}}"
                                            data-position="{{$item->number}}"
                                            class="none anime pointer"
                                            ondblclick="trClick(this,1)"
                                            onclick="
                                                        trClick(this,0);

                                            ">

                                            <td><a class="btn btn-primary" role="button" data-toggle="collapse"
                                                   href="#{{$item->number}}" aria-expanded="false"
                                                   aria-controls="collapseExample{{$item->number}}">
                                                    +
                                                </a></td>

                                            <td>{{$item->number}}</td>
                                            <td></td>
                                            <td colspan="3">{!!$item->desc_en !!}</td>

                                        </tr>
                                        <tr class="collapse" id="{{$item->number}}">
                                            <td colspan="6">
                                                <table class="innerTable">
                                                    <thead>
                                                    <tr>
                                                        <th>Номер детали</th>
                                                        <th>Производство</th>
                                                        <th>Применяемость</th>
                                                        <th>Цена</th>
                                                        <th>аналог</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <?php $InfoDetails = Helper::DetailInfoNiss($market, $model, $modif, $group, $figure, $subfig, $item->secno, $item->number);?>
                                                     @foreach($InfoDetails as $InfoDetail)

                                                        <tr>
                                                            <td>{!! $InfoDetail->serialNumber !!}</td>
                                                            <td>{!! $InfoDetail->Date !!}</td>
                                                            <td>{!! $InfoDetail->analog !!}</td>
                                                            <td><?php $InfoPrice = Helper::CatalogItemPrice($InfoDetail->serialNumber);?>
                                                                {!!$InfoPrice!!}
                                                            </td>


                                                            <td>
                                                                <form class="form-inline"
                                                                      action="{{ action('CartController@postAddToCart') }}"
                                                                      name="add_to_cart" method="post"
                                                                      accept-charset="UTF-8">
                                                                    <input type="hidden" name="_token"
                                                                           value="{{ csrf_token() }}">
                                                                    <input type="hidden" name="title"
                                                                           value="{!! $_v->desc_en !!}"/>
                                                                    <input type="hidden" name="orignumber"
                                                                           value="{{$InfoDetail->serialNumber}}"/>
                                                                    <select name="amount"
                                                                            class="form-control span1 inline">
                                                                        <option value="1" selected>1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                    </select>
                                                                    <button class="btn btn-info inline"
                                                                            type="submit">В корзину
                                                                    </button>
                                                                </form>

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>

                                    @else
                                        <tr>

                                            <td></td>

                                            <td>{{$item->number}}</td>
                                            <td>{!! $item->desc_en !!}</td>
                                            <td><?php $InfoPrice = Helper::CatalogItemPrice($item->number);?>
                                                {!!$InfoPrice!!}
                                            </td>
                                            <td>
                                                <form class="form-inline"
                                                      action="{{ action('CartController@postAddToCart') }}"
                                                      name="add_to_cart" method="post" accept-charset="UTF-8">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="hidden" name="title" value="{!! $_v->desc_en !!}"/>
                                                    <input type="hidden" name="orignumber"
                                                           value="{{$oNIS->repl($_v->number)}}"/>
                                                    <select name="amount" class="form-control span1 inline">
                                                        <option value="1" selected>1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                    <button class="btn btn-info inline" type="submit">В корзину
                                                    </button>
                                                </form>

                                            </td>

                                        </tr>
                                    @endif
                                    @endforeach



                                </tbody>
                            </table>
                        </div>
                        <? } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('footer_scripts')
    <meta name="_token" content="{!! csrf_token() !!}"/>

@stop
