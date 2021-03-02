<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 22.12.2016
 * Time: 17:03
 */
?>
{{--Ошибки --}}

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-danger" role="alert">
                <button class="close" aria-label="Close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">×</span>
                </button>
                Please activate your email. <a href="'route('authenticated.activation-resend') '">Resend</a> activation email.
            </div>
        </div>
    </div>
