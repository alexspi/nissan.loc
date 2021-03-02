<form action="{{ route('search') }}" method="get" class="form-inline">
    {{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
    <input type="text" placeholder="Номер детали" name="number" class="input-small form-control">
    <input class="btn" type="submit" value="Найти">
</form>