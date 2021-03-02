@extends('layouts/app')
{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
{{--@include('header.styles_tecdoc')--}}
@section('breadcrumbs')
    <div class="breadcum">
        {!! Breadcrumbs::render('tree',$mark,$model,$modifs) !!}
    </div>
@stop

{{-- Page content --}}
@section('content')
    <!---------------TECDOC NISSAN/INFINITY model list(3rd page)--------------->
    <section class="section-1 container px-3 py-5 my-3">
        <h1>Категории запчастей</h1>
        <div class="card w-100 d-block p-3">
            <div class="card-body">
                @foreach($maintree as $tree)
                    <ul class="catLink__list">
                        <li class="my-2">
                            <a href="{!!route('subtree',[$mark,$model,$modifs,$tree['shortCutId']])!!}" class="catLink__link">
                                <i class="fa fa-folder-o mr-2" aria-hidden="true"></i>
                                {!!$tree['shortCutName']!!}
                            </a>
                        </li>
                    </ul>
                @endforeach
            </div>
        </div>
    </section>
@stop

@section('footer_scripts')
    @include('footer.script_tecdoc')
@stop

