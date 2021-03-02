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
            
            <i class="livicon icon3" data-name="edit" data-size="20" data-loop="true" data-c="#3d3d3d" data-hc="#3d3d3d"></i> Каталог
        </div>
    </div>
@stop
{{-- Page content --}}
@section('content')

    <section class="section-1 container px-3 pt-5 pb-1 my-3">
                    <h1>{{--подГруппа--}} </h1>
                    <?php if(strtolower($market) != 'jp') { ?>
                    <img class="w-100 mx-auto" src="{!!$srcImg!!}" USEMAP='#groupmap' border='1'>
    </section>
    <section class="section-2 container px-3 pt-1 pb-5 my-3">
        <table class="dataTable tabGroups table table--group table-bordered" id="dataTable">
            <thead>
                <tr>
                    <th class="w-25 nowrap">№ фигуры</th>
                    <th>Название</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $nc = [];
                    //                        dd($aGroups,$oGroups);
                foreach( $aGroups AS $k=>$p ){
                    if ($k == 0) $map_content = '';//контейнер для точек
                //пишем все точки в контейнер
                //                                dump($p);
                $map_content .= "<AREA SHAPE='RECT' COORDS='$p->X,$p->Y,$p->X2,$p->Y2' TITLE='$p->PName' HREF='" . $url . "/" . $p->figure . "'> </AREA>\n";
                //если повторяется - пропускаем в таблице, на рисунке должны быть все точки
                if (array_key_exists($k + 1, $aGroups) && ($p->figure == $aGroups[$k + 1]->figure) && ($p->PName == $aGroups[$k + 1]->PName)) continue;
                ?>
                <tr onclick="window.location.href ='<?=$url . "/" . $p->figure?>';">
                    <td><a class="catLink__link" href="<?=$url . "/" . $p->figure?>"><?=strtoupper($p->figure)?></a></td>
                    <td><a class="catLink__link" href="<?=$url . "/" . $p->figure?>"><?=$p->PName?></a></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </section>
        <!--отрисовываю все точки-->
        <MAP NAME='groupmap'><?=$map_content?></MAP>
        <?php
        //ЭТО ЯПОНСКАЯ СИСТЕМА (несколько изображений на 1 группу)
        }else{ ?>
        {{--{!! dump($aGroups) !!}--}}
    <div id="detailsMap">
        <div>
            <ul id="myTabs" class="nav nav-tabs" role="tablist">
                <?php foreach($aGroups as $key => $group){?>
                <?php $active = '';if ($key == 1){$active = 'active';}  ?>
                <li role="presentation" class="<?=$active?>"><a href="#<?=$key?>" aria-controls="<?=$key?>" role="tab" data-toggle="tab<?=$key?>">Часть <?=$key?></a></li>
                    <?php } ?>
            </ul>
        </div>
        <div class="tab-content">
            <?php foreach($aGroups as $key => $group){?>
            <?php $active = '';if ($key == 1){$active = 'active';}  ?>
            <?php $figures = $group->figures;?>
            <?php $displ = ($key > 1) ? "style=\"display:none;\"" : ''; ?>
            <div role="tabpanel" class="table-responsive tab-pane <?=$active?>" id="<?=$key?>">
                <img src="<?=$group->Img?>" USEMAP='#groupmap<?=$key?>' id="mapImg_<?=$key?> mapImg" border='1' class="jpPartImg mapImg_<?=$key?>">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>№ Фигуры</th>
                            <th>Название</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach( $figures AS $k => $p )
                        <?php $_url = $url . "/" . $p->figure;
                        if ($k == 0) $map_content = '';//чистка, т.к. карт больше 2 на каждую группу
                        //пишу все точки
                        $map_content .= "<AREA SHAPE='RECT' COORDS='$p->X,$p->Y,$p->X2,$p->Y2' TITLE='$p->PName' HREF='" . $_url . "'> </AREA>\n";
                        ?>
                        <tr onclick="window.location.href ='{!! $_url !!}';">
                            <td><a class="catLink__link" href="{!! $_url !!}">{!! strtoupper($p->figure) !!}</a></td>
                            <td><a class="catLink__link" href="{!!$_url!!}">{!!$p->PName!!}</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <!--отрисовываю все точки-->
                <MAP NAME='groupmap<?=$key?>' <?=$displ?> class="mapCord" id="mapCord_<?=$key?>"><?=$map_content?></MAP>
            </div>
                <?php } ?>
        </div>
    </div>
    <?php } ?>
@stop
{{-- Body Bottom confirm modal --}}
{{-- page level scripts --}}
@section('footer_scripts')
    <script>
        $(function () {

            $('#myTabs a').click(function (e) {
                e.preventDefault()
                $(this).tab('show')
            })
        })
    </script>
@stop