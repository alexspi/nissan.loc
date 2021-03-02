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
                    if($msg !== null){
                            echo "<h2>".$msg."</h2>";

                    }else{
//                               
                    foreach( $aTree AS $mark=>$modifs ){ ?>
             
                    
                    <div class="panel-group inline">
                        
                        <div class="panel panel-default">
                            <div class="panel-heading" onclick="branchToggle('plusBranch<?=$oNIS->replaceSS($mark)?>','itemsBranch<?=$oNIS->replaceSS($mark)?>')">
                                <div id="plusBranch<?=$oNIS->replaceSS($mark)?>" class="plusBranch anime" style="width: 5%; float: left">+</div><div style="width: 85%">
                                    <?=$marks . ' '.$mark ; $forUrl = $modifs->name;unset($modifs->name);?></div></div>
                            <div id="itemsBranch<?=$oNIS->replaceSS($mark)?>" class="panel-collapse collapse" style="display:none">
                                
                                <?php foreach( $modifs AS $model=>$markets ){  $a = '0'; $params = '';?>
                                
                                <div class="panel-heading" onclick="$('#market<?=$oNIS->replaceSS($mark).$model?>').slideToggle(400)" style="padding-left: 10%">
                                    <div style="width: 3%; float: left">+</div><div style="width: 75%">Дата выпуска модели {!! $markets->date !!}</div>
                                    <?php unset($markets->date);?>
                                </div>
                                <div id="market<?=$oNIS->replaceSS($mark) . $model?>" class="panel-collapse collapse" style="display:none">
                                    @php  foreach( $markets AS $market=>$detail){ $b = '' . (($market * 1) - 1) . '';
                                    if ($market > 0 && $markets->$market->secno == $markets->$b->secno && $markets->$market->partcode == $markets->$b->partcode) continue;
                                        $url = '/podbor/'.$marks.'/' . $about->market . '/' . $forUrl . '/' . $model . '/' . $detail->group . '/' . $detail->figure. '?part=' . urlencode($detail->partcode);
                                    $url1 = route('nissan.market.model.groups.illustration',
                                    ['marks' => $marks,
                                    'market'=>$about->market,
                                    'model'=>$forUrl,
                                    'modif'=>$model,
                                    'group'=>$detail->group,
                                    'figure'=>$detail->figure,
                                    'part'=>$detail->partcode]);

                                    @endphp

                                 
                                    <div id="detail<?=$mark . $model . $market?>" class="text-left ml60">
                                        <a href="{{$url}}" target="_blank">
                                            <span class="itemDesc" class="anime"><?=$detail->partcode . ' ' . $detail->partname . ' ( ' . $detail->fullsubgrname . ' )'?></span>
                                        </a><br>
                                    </div>
                                    <?php } ?>
                                </div>
                                
                                <?php }?>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                        
                        <script>
                            function branchToggle(plusBranch,itemsBranch){
                                console.log(plusBranch,itemsBranch);
                                var $plusBranch  = $('#'+plusBranch),
                                        $itemsBranch = $('#'+itemsBranch);
                                if( $plusBranch.html()!='+' ){
                                    $plusBranch.html('+');
                                    $itemsBranch.slideUp(700);
                                }
                                else{
                                    $plusBranch.html('&ndash;');
                                    $itemsBranch.slideDown(700);
                                }
                            }
                        </script>
                        <? } ?>
                </div>
            </div>
        </div>
    </div>


@stop

{{-- Body Bottom confirm modal --}}
{{-- page level scripts --}}
@section('footer_scripts')
@stop