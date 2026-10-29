<x-layout>
    <h1>{{ $product->name }}</h1>

    <p><strong>ID:</strong> {{ $product->id }}</p>

    <p>
        <strong>Apraksts:</strong>
        {{ $product->description ?? 'Nav apraksta' }}
    </p>

    <p>
        <strong>Cena:</strong>
        {{ number_format($product->price, 2) }} €
    </p>

    <a href="{{ route('products.edit', $product) }}">
        Rediģēt
    </a>

    <a href="{{ route('products.index') }}">
        Atpakaļ uz sarakstu
    </a>
</x-layout>