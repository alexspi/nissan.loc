@extends('layouts/app')
{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
{{--@include('header.styles_tecdoc')--}}
@section('breadcrumbs')
    <div class="breadcum">
        {!! Breadcrumbs::render('pgsparesfull',$mark,$model,$modifs,$maintree,$parentNodeId, $GroupNodeId,$articleId, $articleLinkId,$brandName) !!}
    </div>
@stop
{{-- Page content --}}
@section('content')
    <!---------------TECDOC NISSAN/INFINITY model list + images(6th page)--------------->
    <section class="section-1 container px-3 py-5 my-3">
        <h3>{!! $assignedArticle['articleName'] !!}</h3>
        <div class="card w-100 d-block p-3">
            <div class="card-body px-0">
                <div class="d-inline-block col-sm-6">
                    @if($articleDocuments !== Null)
                    <img src="http://webservicepilot.tecdoc.net/pegasus-3-0/documents/1111/{{$articleDocuments['0']['docId']}}"
                         alt="" width="100%">
                    @endif
                </div>
                <div class="d-inline-block col-sm-5">
                    Аттрибуты:<br>
                    Производитель: {!! $brandName !!}<br>
                    Номер у производителя :   {!! $assignedArticle['articleNo'] !!}
                    @if($articleAttributes !== Null)
                        <ul class="mx-0 px-0" style="list-style:none;">
                            @foreach($articleAttributes as $Attributes)
                                <li class="mx-0"> {!!$Attributes['attrName']!!} /  @if(array_key_exists('attrValue',$Attributes)){!!$Attributes['attrValue']!!}@endif</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
       
                    @if($oenNumbersf !== Null)
                      <h3> Оригинальные номера</h3>

                <div class="w-100 table__wrapper">
                    <table class="table table-bordered table-condensed table--group mx-0 mx-lg-auto">
                        @foreach($oenNumbersf as $oenNumber)
                            <tr>
                                <td>{!!$oenNumber['oeNumber']!!}</td>
                                <td> {!!$oenNumber['brandName']!!}</td>
                                <td><?php $InfoPrice = Helper::CatalogItemPrice($oenNumber['oeNumber']);?>
                                    {!!$InfoPrice!!}
                                </td>
                                <td>
                                    <form class="form-inline" action="{{ action('CartController@postAddToCart') }}" name="add_to_cart" method="post" accept-charset="UTF-8">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="title" value="{!! $assignedArticle['articleName'] !!}"/>
                                        <input type="hidden" name="number" value="{!! $assignedArticle['articleNo'] !!}"/>
                                        <input type="hidden" name="orignumber" value="{!!$oenNumber['oeNumber']!!}"/>
                                        <select name="amount" class="custom-select mx-auto">
                                            <option value="1" selected>1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                        <button class="btn but but--sub mx-auto" type="submit">В корзину</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
				@endif
                {{--{!! dd(Cache::get('DataAnalog') )!!}--}}
            </div>
        </div>
    </section>
@stop
@section('footer_scripts')
    @include('footer.script_tecdoc')
@stop