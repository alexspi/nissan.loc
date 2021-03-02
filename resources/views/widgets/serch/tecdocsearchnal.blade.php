<form class="d-flex flex-row" action="{{ route('searchprimen') }}" method="get">
    {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
    <input class="form-control mr-3 search-field" type="text" name="snumber" placeholder="Номер детали">
    <button class="btn submit" type="submit">Найти</button>
</form>