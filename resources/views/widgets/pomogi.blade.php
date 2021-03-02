<form id="w3" class="d-flex flex-column" action="{{ action('UserAttachController@saveAttach') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h3 class="mx-auto mt-3">Информация о вашем автомобиле</h3>
    <div class="d-flex flex-column flex-lg-row mx-auto">
        <div class="d-flex flex-column mx-2">
            <div class="toggle btn-group" data-toggle="buttons">
                <label class="toggle__btn btn text-center active">
                    <input class="toggle__input" type="radio" name="mark" autocomplete="off" value="Nissan" checked>
                    Nissan
                </label>
                <label class="toggle__btn btn text-center">
                    <input class="toggle__input" type="radio" name="mark" autocomplete="off" value="Infinity">
                    Infinity
                </label>
            </div>
            <div class="toggle btn-group" id="feedback-engine_type" data-toggle="buttons">
                <label class="toggle__btn btn text-center active">
                    <input class="toggle__input" type="radio" name="engine_type" autocomplete="off" value="Бензин">
                    Бензин
                </label>
                <label class="toggle__btn btn text-center">
                    <input class="toggle__input" type="radio" name="engine_type" autocomplete="off" value="Дизель">
                    Дизель
                </label>
            </div>
        </div>
        <div class="input-field input-group d-flex flex-column mx-2">
            <input class="input-field__input" type="text" id="feedback-engine" placeholder="Двигатель">
            <input class="input-field__input my-2" id="feedback-model" type="text" placeholder="Модель">
            <input class="input-field__input" type="text" id="feedback-year" placeholder="Год">
        </div>
    </div>
    <div class="vin my-2 text-center text-lg-right">
        <label class="d-lg-inline  mx-auto mx-lg-2" for="feedback-vin">Или введите VIN</label>
        <input class="input-field__input form-control d-lg-inline-block mx-auto mx-lg-2" id="feedback-vin" type="text" placeholder="Например: WAUBH54B11N111054">
    </div>
    <h3 class="mx-auto mt-3">Персональная информация</h3>
    <div class="d-flex flex-column mx-auto">
        <input class="input-field__input form-control mx-2 my-2" id="feedback-name" name="name" type="text" placeholder="Имя">
        <input class="input-field__input form-control mx-2 my-2" id="feedback-phone" type="tel" name="phone" placeholder="Тел.: +7(xxx)xxx-xxxx" pattern="/((8|\\+7?)[\\- ]?)?(\\d{3}?[\\- ]?)?([\\d\\- ]{7,10})/">
        <input class="input-field__input form-control mx-2 my-2" id="feedback-email" name="email" type="email" placeholder="example@e-mail.com">
        <p class="mt-2 mb-1 mx-2">Предпочитаемый вид связи</p>
        <div class="toggle btn-group mx-2 mt-0" data-toggle="buttons">
            <label class="toggle__btn btn text-center active">
                <input class="toggle__input" type="radio" name="connect_type" autocomplete="off" value="phone" checked>
                Телефон
            </label>
            <label class="toggle__btn btn text-center">
                <input class="toggle__input" type="radio" name="connect_type" id="mail" autocomplete="off" value="email">
                E-mail
            </label>
        </div>
    </div>
    <h3 class="mx-auto mt-3">Описание товара</h3>
    <div class="d-flex flex-column flex-lg-row mx-auto">
        <div class="input-field d-flex flex-column">
            <input class="input-field__input form-control mx-2 my-2" id="feedback-article" name="article" type="text" placeholder="Номер делали(если известен)">
            <input class="input-field__input form-control mx-2 my-2" id="feedback-detail" name="detail" type="text" placeholder="Опишите запчасть">
        </div>
        <textarea class="input-field__input form-control mx-2 my-2" name="comment" id="feedback-comment" rows="3" placeholder="Комментарий к заказу"></textarea>
    </div>
    <div class="g-recaptcha mini consultation__captcha mx-auto mt-2" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
    <div class="d-flex flex-row mx-auto my-2">
        <button class="btn but but--sub mx-2" id="myStateButton" type="submit" data-complete-text="finished!">Отправить</button>
        <button class="btn but but--res mx-2" type="reset">Сбросить</button>
    </div>
</form>


@section('footer.after_scripts')
    <script src='https://www.google.com/recaptcha/api.js'></script>

@endsection