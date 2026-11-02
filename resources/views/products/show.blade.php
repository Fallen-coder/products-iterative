
<x-layout>
    <h1>{{ $product->name }}</h1>

    <p><strong>ID:</strong> {{ $product->id }}</p>

    <p><strong>Daudzums:</strong></p>

    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">

        <form action="{{ route('products.decrease', $product) }}" method="POST">
            @csrf
            <button type="submit"
                {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                - Samazināt
            </button>
        </form>

        <strong style="font-size: 24px;">
            {{ $product->quantity }}
        </strong>

        <form action="{{ route('products.increase', $product) }}" method="POST">
            @csrf
            <button type="submit">
                + Palielināt
            </button>
        </form>

    </div>

    <p><strong>Apraksts:</strong> {{ $product->description ?? 'Nav apraksta' }}</p>

    <p><strong>Cena:</strong> {{ $product->price }}</p>

    <p>
        <strong>Derīguma termiņš:</strong>
        {{ $product->expiration_date?->format('d.m.Y') ?? '-' }}
    </p>

    <p><strong>Statuss:</strong> {{ $product->status }}</p>

    @if(session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    @if(session('error'))
        <p style="color: red;">
            {{ session('error') }}
        </p>
    @endif

    <a href="{{ route('products.edit', $product) }}">Rediģēt</a>
    <a href="{{ route('products.index') }}">Atpakaļ</a>
</x-layout>
