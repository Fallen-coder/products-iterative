<x-layout>
    <h1>Produkti</h1>

    <a href="{{ route('products.create') }}">
        Pievienot produktu
    </a>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nosaukums</th>
                <th>Cena</th>
                <th>Darbības</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->price, 2) }} €</td>
                    <td>
                        <a href="{{ route('products.show', $product) }}">
                            Apskatīt
                        </a>

                        <a href="{{ route('products.edit', $product) }}">
                            Rediģēt
                        </a>

                        <form action="{{ route('products.destroy', $product) }}"
                              method="POST"
                              style="display:inline">
                            @csrf
                            @method('DELETE')

                            <button type="submit">
                                Dzēst
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Produktu vēl nav.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</x-layout>