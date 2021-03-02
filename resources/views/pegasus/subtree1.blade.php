@extends('layouts/app')
{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
{{--@include('header.styles_tecdoc')--}}
@section('breadcrumbs')
    <div class="breadcum">
        {!! Breadcrumbs::render('subtree1',$mark,$model,$modifs,$maintree,$parentNodeId) !!}
    </div>
@stop
{{-- Page content --}}
@section('content')
    <section class="section-1 container px-3 py-5 my-3">
        <h1>Категории запчастей</h1>
        <div class="card w-100 d-block p-3">
            <div class="card-body">
                @foreach($subtree as $tree)
                    <ul class="catLink__list">
                        @if($tree['hasChilds'] == false)
                            <li class="my-2"><a class="catLink__link" href="{!!route('pgspares',[$mark,$model,$modifs,$maintree,$parentNodeId,$tree['assemblyGroupNodeId']])!!}">{!!$tree['assemblyGroupName']!!}/ {!!$tree['assemblyGroupNodeId']!!}</a></li>
                        @else
                            <li class="my-2"><i class="fa fa-folder-o mr-1" aria-hidden="true"></i><a class="catLink__link" href="{!!route('subtree2',[$mark,$model,$modifs,$maintree,$parentNodeId,$tree['assemblyGroupNodeId']])!!}">  {!!$tree['assemblyGroupName']!!} / {!!$tree['assemblyGroupNodeId']!!}</a></li>
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

