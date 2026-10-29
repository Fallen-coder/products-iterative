<x-layout>
    <h1>Rediģēt produktu</h1>

    <form action="{{ route('products.update', $product) }}"
          method="POST">
        @csrf
        @method('PUT')

        <label>Nosaukums:</label>
        <input type="text" name="name"
               value="{{ old('name', $product->name) }}">
        @error('name')
            <p>{{ $message }}</p>
        @enderror

        <br><br>

        <label>Apraksts:</label>
        <textarea name="description">{{ old('description', $product->description) }}</textarea>
        @error('description')
            <p>{{ $message }}</p>
        @enderror

        <br><br>

        <label>Cena:</label>
        <input type="number" name="price" step="0.01"
               min="0" value="{{ old('price', $product->price) }}">
        @error('price')
            <p>{{ $message }}</p>
        @enderror

        <br><br>

        <button type="submit">Atjaunināt</button>

        <a href="{{ route('products.index') }}">Atpakaļ</a>
    </form>
</x-layout>