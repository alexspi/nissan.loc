@extends('layouts/app')
{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
{{--@include('header.styles_tecdoc')--}}
@section('header_styles')

@stop
@section('breadcrumbs')
    <div class="breadcum">
        {{--{!! dd($mark,$model,$modifs,$maintree)  !!}--}}
        {!! Breadcrumbs::render('subtree',$mark,$model,$modifs,$maintree) !!}
    </div>
@stop
{{-- Page content --}}
@section('content')
    <!---------------TECDOC NISSAN/INFINITY model list(4th page)--------------->
    <section class="section-1 container px-3 py-5 my-3">
        <h1>Категории запчастей</h1>
        <div class="card w-100 d-block p-3">
            <div class="card-body">
                @foreach($subtree as $tree)
                    <ul class="catLink__list">
                        @if($tree['hasChilds'] == false)
                            <li class="my-2"><a class="catLink__link" href="{!!route('pgspares',[$mark,$model,$modifs,$tree['assemblyGroupNodeId']])!!}">{!!$tree['assemblyGroupName']!!}/ {!!$tree['assemblyGroupNodeId']!!}</a></li>
                        @else
                            <li class="my-2"><i class="fa fa-folder-o mr-1" aria-hidden="true"></i><a class="catLink__link" href="{!!route('subtree1',[$mark,$model,$modifs,$maintree,$tree['assemblyGroupNodeId']])!!}">{!!$tree['assemblyGroupName']!!} / {!!$tree['assemblyGroupNodeId']!!}</a></li>

                        @endif
                    </ul>
                @endforeach
            </div>
        </div>
    </section>
@stop
@section('footer_scripts')
    @include('footer.script_tecdoc')
@stop

