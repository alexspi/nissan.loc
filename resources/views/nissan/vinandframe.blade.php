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
    <div class="container">
        <div class="row">
            <div class="content">
                <div class="col-md-12">
                    
                    
                    <?php
                    if(!empty($aErrors) || !empty($msg) ){
                    if (!is_array($msg)) echo "<h2>" . $msg . "</h2>";
                    else foreach ($msg as $k => $message) {
                        echo "<h2>" . $message . "</h2>";
                    }
                    foreach( $errors AS $sError ){?>
                    <span class="red">Ошибка:<?=$sError?></span></br>
                    <?php }
                    }else{ ?>
                    <table border="1" width="100%">
                        <thead>
                        <tr>
                            <th>Рынок</th>
                            <th>Модель</th>
                            <th>Серия</th>
                            <th>Производство</th>
                            <?foreach ($aFields as $value) {
                                echo '<th>' . $value . '</th>';
                            }?>
                            <th>Другое</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(!empty($aRezult))
                        foreach( $aRezult AS $_v ){
                        //            $nextUrl  = DS.$mark.DS.UTF8::strtolower($_v->market).DS.$_v->modelCode.DS.$_v->compl;
                        $nextUrl = '/podbor/' . $mark . '/' . $_v->market . '/' . $_v->modelCode . '/' . $_v->compl;
                        ?>
                        <tr onclick="window.location.href ='<?=$nextUrl?>'" class="alMid">
                            <td><?=str_replace(" ", "<br/>", $_v->marketRU)?></td>
                            <td><a href="<?=$nextUrl?>"><?=$_v->modelName?></a></td>
                            <td><?=$_v->modelCode?></td>
                            <td><?=$_v->prod?></td>
                            <?foreach ($_v as $key => $value) {
                                //ключи отличаются в разных моделях, не везде двигатель или трансмиссия схожи для сравнения
                                if (!in_array($key, ['market', 'marketRU', 'modelName', 'modelCode', 'compl', 'dir', 'prod', 'other'])) {
                                    echo '<td>' . $_v->$key . '</td>';
                                }
                            }
                            if (!empty($_v->other) && is_array($_v->other))
                                echo '<td>' . implode(' ', $_v->other) . '</td>';
                            elseif (!empty($_v->other) && !is_array($_v->other)) echo '<td>' . $_v->other . '</td>';
                            else echo '<td></td>'; ?>
                        </tr>
                        <?php }?>
                        </tbody>
                    </table>
                    
                    <?if(!empty($aList)){?>
                    <div class="explanation">
                        <span class="cBlue">Расшифровка сокращений</span>
                        <div class="expTable">
                            <?php foreach( $aList AS $n=>$s ){
                            if($s){?>
                            <div class="eTableHead"><?=$n?></div>
                            <div class="eTableBody">
                                <?php foreach( $s AS $k=>$a ){?>
                                <span class="sign"><?=$k?></span> = <span class="desc"><?=$a?></span><br/>
                                <?php }?>
                            </div>
                            <?php }
                            }?>
                        </div>
                    </div>
                    <?}
                    } ?>
                </div>
            </div>
        </div>
    </div>


@stop

{{-- Body Bottom confirm modal --}}
{{-- page level scripts --}}
@section('footer_scripts')
@stop