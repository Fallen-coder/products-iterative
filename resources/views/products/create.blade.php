<x-layout>
    <h1>Jauns produkts</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <label>Nosaukums:</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name')
            <p>{{ $message }}</p>
        @enderror

        <br><br>

        <label>Apraksts:</label>
        <textarea name="description">{{ old('description') }}</textarea>
        @error('description')
            <p>{{ $message }}</p>
        @enderror

        <br><br>

        <label>Cena:</label>
        <input type="number" name="price" step="0.01"
               min="0" value="{{ old('price') }}">
        @error('price')
            <p>{{ $message }}</p>
        @enderror

        <br><br>

        <button type="submit">Saglabāt</button>

        <a href="{{ route('products.index') }}">Atpakaļ</a>
    </form>
</x-layout>