<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27.12.2016
 * Time: 10:55
 */?>
@if(session()->has('above-navbar-message') && auth()->check())
    <div class="alert alert-info" role="alert" style="margin-bottom:0px;background-color:#000;border-color:#000;color:#fff;">
        <button type="button" class="close" data-dismiss="alert" style="color:#fff;">×</button>
        {!! session()->get('above-navbar-message') !!}
    </div>
@endif
