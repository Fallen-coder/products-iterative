<x-layout>
    <h1>{{ $product->name }}</h1>

    <p><strong>ID:</strong> {{ $product->id }}</p>
    <p><strong>Daudzums:</strong> {{ $product->quantity }}</p>
    <p><strong>Apraksts:</strong> {{ $product->description ?? 'Nav apraksta' }}</p>

    <p>
        <strong>Derīguma termiņš:</strong>
        {{ $product->expiration_date?->format('d.m.Y') ?? '-' }}
    </p>

    <p><strong>Statuss:</strong> {{ $product->status }}</p>

    <a href="{{ route('products.edit', $product) }}">Rediģēt</a>
    <a href="{{ route('products.index') }}">Atpakaļ</a>
</x-layout>