@extends('layouts.app')
@section('header.header_styles')
    @include('header.header_yamaps')
@stop

@section('content')
<section id="shop_map">
        <h3>Наши магазины в Санкт-Петербурге</h3>
        <div class="bs-example bs-example-tabs" data-example-id="togglable-tabs">
            <ul class="nav nav-tabs nav-justified" id="myTabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#shop1" id="shop1-tab" role="tab" data-toggle="tab" aria-controls="shop1" aria-expanded="true">На Северном проспекте</a>
                </li> 
                <li role="presentation" class="">
                    <a href="#shop2" role="tab" id="shop2-tab" data-toggle="tab" aria-controls="shop2" aria-expanded="false">На проспекте Маршала Жукова</a>
                </li> 
            </ul> 
            <div class="tab-content" id="myTabContent"> 
                <div class="tab-pane fade active in clearfix" role="tabpanel" id="shop1" aria-labelledby="shop1-tab">
                    <div class="col-sm-6">
                        <div id="map"></div>
                    </div>
                    <div class="col-sm-6">
                        <h4>Контактная информация</h3>
                        <p><b>Адрес:</b>&nbsp;Санкт-Петербург, Северный пр-т, д.5, кор.3, АЦ &laquo;Маршал&raquo;, 2 этаж, секция 209</p>
                        <p><b>Адрес:</b>&nbsp;Санкт-Петербург, Северный пр-т, д.7, АЦ &laquo;Маршал&raquo;, 1 этаж, секция 54</p>
                        <p><b>Телефоны:</b>&nbsp;347-76-09, 972-00-59, 655-06-90</p>
                    </div>
                </div> 
                <div class="tab-pane fade clearfix" role="tabpanel" id="shop2" aria-labelledby="shop2-tab">
                    <div class="col-sm-6">
                        <div id="map2"></div>
                    </div>
                    <div class="col-sm-6">
                        <h4>Контактная информация</h3>
                        <p><b>Адрес:</b>&nbsp;Санкт-Петербург, пр-т Маршала Жукова, д.21, АЦ &laquo;Маршал&raquo;, 1 этаж, секция 18</p>
                        <p><b>Телефоны:</b>&nbsp;347-86-87, +7(921) 922-07-39</p>
                    </div>
                </div>
            </div> 
        </div>
    </section>
@endsection
@section('footer_scripts')

@stop