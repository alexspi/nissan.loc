@yield('block.content')
@parent
<div class="row">
    <div class="col-md-4 col-sm-6 col-xs-12">
        <span class="info-box-number">{!! $attach->render() !!}</span>
    </div>
    
    <div class="clearfix visible-sm-block"></div>
    
    <div class="col-md-4 col-sm-6 col-xs-12">
        <span class="info-box-number">{!! $order->render() !!}</span>
    
    </div>
    
    <div class="col-md-4 col-sm-6 col-xs-12">
        <span class="info-box-number">{!! $user->render() !!}</span>
    </div>
    <!-- /.col -->
</div>
<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        {{--<span class="info-box-number">{!! $GeoYandexs->render() !!}</span>--}}
    </div>
    
    <div class="clearfix visible-sm-block"></div>
    
    <div class="col-md-6 col-sm-6 col-xs-12">
        <span class="info-box-number"></span>
    
    </div>
    
   
</div>
   
   