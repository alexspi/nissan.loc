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
        <h1 class="h3">{!! $h1 !!}</h1>
        <div class="table__wrapper">
            <table class="table table-bordered mx-0">
                <thead>
                    <tr>
                        <th>Производство</th>
                        <th>Комплектация</th>
                        <th>Двигатель</th>
                        <th>Другое</th>
                    </tr>
                </thead>
                <tbody>
                {{--{{dd($aModifs)}}--}}
                    @foreach( $aModifs AS $aModif )
                        <?php $_url = $url . "/{$aModif->compl}"?>
                            <tr onclick="window.location.href ='<?=$_url?>'">
                                <td><a class="catLink__link" href="{!! $_url !!}" >{!! $aModif->prod !!}</a></td>
                                @foreach($aModif as $key =>$value)
                                    @if(!in_array($key,['compl','code','prod','other']))
                                        <td>{!! $aModif->$key!!}</td>
                                    @endif
                                @endforeach
                                @if(!empty($aModif->other) && is_array($aModif->other))
                                    <td class="d-none">{!! implode(' ',$aModif->other)!!}</td>
                                    @elseif(empty($aModif->other) && !is_array($aModif->other))
                                        <td>{!! $aModif->other !!}</td>
                                        @else
                                        <td></td>
                                @endif
                            </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
    <section class="section-2 container px-1 px-sm-3 pt-1 pb-5 my-3">
        <div class="card card--big">
            <div class="card-header d-inline pl-2">
                <h5 class="card-title my-auto">Расшифровка сокращений</h5>
            </div>
            <div class="card-body d-flex flex-column py-3 pl-2 pr-0 mt-2 justify-content-around">
                <?php foreach( $aList AS $n=>$s ){
                    if($s){?>
                        <div><p class="h6"><?=$n?></p></div>
                        <div>
                            <?php foreach( $s AS $k=>$a ){?><span><?=$k?></span> = <span><?=$a?></span><br/><?php }?>
                        </div>
                            <?php }
                }?>
            </div>
        </div>
    </section>
@stop

{{-- Body Bottom confirm modal --}}
{{-- page level scripts --}}
@section('footer_scripts')

@stop

