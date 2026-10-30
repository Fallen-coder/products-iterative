<x-layout>
    <h1>Jauns produkts</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <label>Nosaukums:</label>
        <input type="text" name="name" value="{{ old('name') }}">

        <br><br>

        <label>Daudzums:</label>
        <input type="number" name="quantity"
               min="0" value="{{ old('quantity', 0) }}">

        <br><br>

        <label>Apraksts:</label>
        <textarea name="description">{{ old('description') }}</textarea>

        <br><br>

        <label>Derīguma termiņš:</label>
        <input type="date" name="expiration_date"
               value="{{ old('expiration_date') }}">

        <br><br>

        <label>Statuss:</label>
        <select name="status">
            <option value="active" @selected(old('status') == 'active')>
                Aktīvs
            </option>
            <option value="inactive" @selected(old('status') == 'inactive')>
                Neaktīvs
            </option>
            <option value="expired" @selected(old('status') == 'expired')>
                Beidzies
            </option>
        </select>

        <br><br>

        <button type="submit">Saglabāt</button>

        <a href="{{ route('products.index') }}">Atpakaļ</a>
    </form>
</x-layout>