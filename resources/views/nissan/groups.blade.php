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
        <h1>Группы</h1>
                    <?php if(strtolower($market) != 'jp') { ?>
                    <img class="w-100 mx-auto" src="<?=$srcImg?>" USEMAP='#groupmap' border='1'>
                    <? } ?>
    </section>
    <section class="section-2 container px-3 pt-1 pb-5 my-3">
        <table border="1" id="dataTable" class="dataTable table table--group table-bordered">
            <thead>
                <tr>
                    <th>Группа</th>
                    <th>Название</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach( $oGroups AS $k=>$p ):$_url = $url . "/".$p->Group;
                    if($k == 0) $map_content = '';//контейнер для точек
                    if(strtolower($market) != 'jp') {//у японцев на этом уровне нет изображения
                        $map_content .= "<AREA SHAPE='RECT' COORDS='$p->X,$p->Y,$p->X2,$p->Y2' TITLE='$p->GroupName' id='Group$p->Group' HREF='" . $_url . "'> </AREA>\n";
                    }?>
                    <tr onclick="window.location.href ='<?=$_url?>';">
                        <td><a class="catLink__link" href="{{$url}}/{{$p->Group}}"><?=strtoupper($p->Group)?></a></td>
                        <td><a class="catLink__link" href="<?=$_url?>"><?=$p->GroupName?></a></td>
                    </tr>
                <?php endforeach?>
            </tbody>
        </table>
        <!--отрисовываю все точки-->
        <MAP NAME='groupmap' ><?=$map_content?></MAP>
    </section>
@stop

{{-- Body Bottom confirm modal --}}
{{-- page level scripts --}}
@section('footer_scripts')
@stop