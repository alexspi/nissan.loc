<form class="d-flex flex-row" action="{{ route('searchvin') }}" method="get">
    <select class="form-control search-field" name="mark">
        <option value="nissan">Nissan</option>
        <option value="infiniti">Infiniti</option>
    </select>
    <input class="form-control mx-3 search-field" type="text" name="vin" placeholder="VIN (9-17 знаков)">
    <button class="btn submit" type="submit">Найти</button>
</form>