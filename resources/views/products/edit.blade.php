<x-layout>
    <h1>Rediģēt produktu</h1>

    <form action="{{ route('products.update', $product) }}"
          method="POST">

        @csrf
        @method('PUT')

        <label>Nosaukums:</label>
        <input type="text" name="name"
               value="{{ old('name', $product->name) }}">

        <br><br>

        <label>Daudzums:</label>
        <input type="number" name="quantity" min="0"
               value="{{ old('quantity', $product->quantity) }}">

        <br><br>

        <label>Apraksts:</label>
        <textarea name="description">{{ old('description', $product->description) }}</textarea>

        <br><br>

        <label>Derīguma termiņš:</label>
        <input type="date" name="expiration_date"
               value="{{ old('expiration_date', $product->expiration_date?->format('Y-m-d')) }}">

        <br><br>

        <label>Statuss:</label>
        <select name="status">
            <option value="active"
                @selected(old('status', $product->status) == 'active')>
                Aktīvs
            </option>

            <option value="inactive"
                @selected(old('status', $product->status) == 'inactive')>
                Neaktīvs
            </option>

            <option value="expired"
                @selected(old('status', $product->status) == 'expired')>
                Beidzies
            </option>
        </select>

        <br><br>

        <button type="submit">Atjaunināt</button>

        <a href="{{ route('products.index') }}">Atpakaļ</a>
    </form>
</x-layout>