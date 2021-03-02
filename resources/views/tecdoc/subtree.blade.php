@extends('layouts/app')

{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
@include('header.styles_tecdoc')
@section('header_styles')

@stop
@section('breadcrummbs')
    <div class="breadcum">
        {{--{!! Breadcrumbs::renderArray('subtree',[$marks,$models,$types,$STR_ID]) !!}--}}
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
                                    Категории запчастей

                                </div>
                            </div>
                        </div>
                        <div class="panel-body table-responsive">

                            @foreach($Trees as $tree)
                                <ul style="list-style:none;">
                                    @if($tree->DESCENDANTS == '0')
                                     
                                        <li ><a href="{!!route('spares',[$marks,$models,$types,$tree->STR_ID])!!}">{!!$tree->STR_DES_TEXT!!}</a></li>
                                        
                                    @else

                                        <li><i class="fa fa-folder-o" aria-hidden="true"></i><a href="{!!route('subtree1',[$marks,$models,$types,$STR_ID,$tree->STR_ID])!!}">  {!!$tree->STR_DES_TEXT!!}  </a></li>

                                    @endif

                                </ul>


                            @endforeach

                        </div>
                    </div>
            </div>
        @stop
@section('footer_scripts')
    @include('footer.script_tecdoc')
@stop

