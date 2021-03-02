@extends('layouts/app')

{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
{{--@include('header.script_api')--}}
@include('header.styles_api')
{{--@section('breadcrummbs')--}}
    {{--<div class="breadcum">--}}
        {{--<div class="container">--}}

            {{--<i class="livicon icon3" data-name="edit" data-size="20" data-loop="true" data-c="#3d3d3d"--}}
               {{--data-hc="#3d3d3d"></i> Каталог--}}

        {{--</div>--}}
    {{--</div>--}}
{{--@stop--}}

{{-- Page content --}}
@section('content')



    <section class="section-1 container px-3 pt-5 pb-1 my-3 w-100">
        <div class="movable-img mx-auto w-100">
                    @include('nissan._illu')
                    <div id="detailsMap">


                        <? if(!empty($aErrors) || !empty($msg)){?>
                        <h2>{{$msg}}</h2>
                        <? }else{ ?>

                        <div id="tabs">
                            <?php $i = 0;
                            if ($aTCount <= 4) $widthTabs = 24.5;
                            else            $widthTabs = (100 / $aTCount) - 0.5;
                            if ($subFlag) $tabsKeys = array_keys((array)$aTabs);
                            foreach( $aTabs AS $t ){
                            foreach($t as $k=>$tab){ $i++;
                            if ($subFlag && $subfig && $pic) $class = ($subfig == $tab->figure && $pic == $tab->secno) ? " class='activeTab cBlue'" : "";
                            else $class = ($pic == $tab->secno || (!$subfig && !$pic && $i == 1)) ? " class='activeTab cBlue'" : ""; ?>
                            <a class="catLink__link py-1 px-3"
                               href="<?=$nextSecUrl . '&subfig=' . $tab->figure . '&sec=' . $tab->secno?>"<?=$class?>>Вид <?=$i?> </a>
                            <?php
                            if (empty($subfig) && (int)$k == 1) $currfig = $tab->figure;
                            if (empty($pic) && (int)$k == 1) $secno = $tab->secno;
                            }
                            if (empty($currfig)) $currfig = $tab->figure; if (empty($secno)) $secno = $tab->secno; //вдруг пусто, встречал такое
                            }
                            //для таблицы адрес нужен, а подфигура и секция в другом массиве(не с деталями)
                            if (empty($subfig)) $subfig = $currfig;
                            if (empty($pic)) $pic = $secno;
                            $nextUrl .= $subfig . '&sec=' . $pic;
                            ?>
                        </div>

                        <?php $px = 5; $py = 5; ?>
                        {{--<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>--}}
                        <div class="defBorder imgArea w-100 d-flex flex-column" id="imageArea">

                            <?php }?>
                            <div id="imageLayout"
                                 style="position:absolute;left:0;top:0;width:<?=$width?>px;height:<?=$height?>px">
                                <canvas id="canvas" <?=$attrs?>style="margin:0;padding:0;"></canvas>
                                <?php
                                $prevNamber = FALSE;
                                foreach($aDetails as $aDetail) {
                                foreach ($aDetail AS $_v) {
                                /** у инфинити бывает такое, что на последнем уровне с изобр есть еще "секция"*/
                                $title = (strtoupper($market) == 'JP' || empty($_v->desc_en)) ? $_v->number : "$_v->number - $_v->desc_en";
                                $lLeft = $_v->x1 * $prc - $px * $prc;
                                $lTop = $_v->y1 * $prc - $py * $prc;
                                $lWidth = ($_v->x2 * $prc - $lLeft) + $px * $prc * 2;
                                $lHeight = ($_v->y2 * $prc - $lTop) + $py * $prc * 2 - 10;

                                $currNumber = $_v->number;
                                $number = ($currNumber == $prevNamber) ? $currNumber : $currNumber;
                                $prevNamber = $currNumber;
                                ?>
                                <div id="l<?= $oNIS->repl($number) ?>" class="l<?= $oNIS->repl($number) ?> mapLabel"
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
                                }?>
                            </div>
                            @include('nissan._zoom')
                        </div>
                        {{--{{dump($aD)}}--}}

                        <div id="detailsList">
                            <table class="table table-responsive">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Наименование</th>
                                    <th>Номер</th>
                                    <th>Цена <span class="d-none d-md-inline">(при наличии на складе)</span></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($fulldetails as $fulldetail)
                                    @if($fulldetail['number'] !=='')
                                        <tr id="d{{$fulldetail['anum']}}"
                                            @if($fulldetail['anum'] =='****')
                                            data-position="{{$fulldetail['number']}}"
                                            @else
                                            data-position="{{$fulldetail['anum']}}"
                                            @endif
                                            class="none anime pointer"
                                            ondblclick="trClick(this,1)"
                                            onclick="trClick(this,0);">
                                            <td>{!! $fulldetail['anum']!!}</td>
                                            <td>{!! $fulldetail['desc'] !!}</td>
                                            <td>{!! $fulldetail['number'] !!}</td>
                                            <td>{!!$fulldetail['price'] !!} </td>


                                            <td>
                                                <form class="form-inline"
                                                      action="{{ action('CartController@postAddToCart') }}"
                                                      name="add_to_cart" method="post"
                                                      accept-charset="UTF-8">
                                                    <input type="hidden" name="_token"
                                                           value="{{ csrf_token() }}">
                                                    <input type="hidden" name="title"
                                                           value="{!! $fulldetail['desc'] !!}"/>
                                                    <input type="hidden" name="orignumber"
                                                           value="{{$fulldetail['number']}}"/>
                                                    <select name="amount"
                                                            class="custom-select mx-auto">
                                                        <option value="1" selected>1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                    <button class="btn but but--sub mx-auto"
                                                            type="submit">В корзину
                                                    </button>
                                                </form>

                                            </td>
                                        </tr>
                                    @else
                                        <tr id="d{{$fulldetail['anum']}}"
                                            @if($fulldetail['anum'] =='****')
                                            data-position="{{$fulldetail['number']}}"
                                            @else
                                            data-position="{{$fulldetail['anum']}}"
                                            @endif
                                            class="none anime pointer"
                                            ondblclick="trClick(this,1)"
                                            onclick="trClick(this,0);">
                                            <td><a href="{{route('nissan.market.model.groups.illustration',
                                                                ['marks' => $mark,
                                                                'market'=>$market,
                                                                'model'=>$model,
                                                                'modif'=>$modif,
                                                                'group'=>$group,
                                                                'figure'=>$fulldetail['anum']
                                                                ])}}">{!! $fulldetail['anum']!!}</a></td>
                                            <td><a href="{{route('nissan.market.model.groups.illustration',
                                                                ['marks' => $mark,
                                                                'market'=>$market,
                                                                'model'=>$model,
                                                                'modif'=>$modif,
                                                                'group'=>$group,
                                                                'figure'=>$fulldetail['anum']
                                                                ])}}">{!! $fulldetail['desc'] !!}</a></td>
                                            <td>{!! $fulldetail['number'] !!}</td>
                                            <td>{!!$fulldetail['price'] !!}
                                            </td>


                                            <td>

                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                </tbody>

                                <script>
                                    $(window).load(function () {
                                        trClick($('#d'.$fulldetail['number'].
                                        ''
                                    ),
                                        0
                                    )
                                    });
                                </script>
                            </table>
                        </div>

                    </div>
                </div>
    </section>
@endsection

{{-- Body Bottom confirm modal --}}
{{-- page level scripts --}}

@section('footer_scripts')


@endsection