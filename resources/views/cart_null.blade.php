@extends('layouts/app')
{{-- Page title --}}
@section('title')
    catalogs List
    @parent
@stop
@section('header_styles')
    {{--<script src="{{asset("assets/js/cookie.js")}}"></script>--}}
@stop
@section('breadcrummbs')
    <div class="breadcum">
        {!! Breadcrumbs::render('cart') !!}
    </div>
@stop
{{-- Page content --}}
@section('content')
            <h3 class="inner-main-title">Мои покупки</h3>

           
               
                        <p>Ваша корзина пуста</p>
            
            
@stop

{{-- Body Bottom confirm modal --}}
{{-- page level scripts --}}

@section('footer.before_scripts')
    <script>
        $('#refresh').on('click',function(){
            var captcha = $('img.captcha-img');
            var config = captcha.data('refresh-config');
            $.ajax({
                method: 'GET',
                url: '/getcaptcha/' + config,
            }).done(function (response) {
                captcha.prop('src', response);
            });
        });
    </script>
    
@endsection
@section('footer_scripts')

@stop