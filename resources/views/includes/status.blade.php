<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 27.12.2016
 * Time: 11:03
 */?>
@if(Session::has('message'))
    <div class="alert alert-{{ Session::get('status') }} status-box">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        {{ Session::get('message') }}
    </div>
@endif
