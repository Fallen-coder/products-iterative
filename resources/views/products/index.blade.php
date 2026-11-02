
<x-layout>
    <div class="products-page">

        <div class="products-heading">
            <div>
                <h1>Produkti</h1>
                <p>Visu pievienoto produktu saraksts</p>
            </div>

            <a href="{{ route('products.create') }}" class="btn btn-primary">
                + Pievienot produktu
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nosaukums</th>
                        <th>Daudzums</th>
                        <th>Apraksts</th>
                        <th>Cena</th>
                        <th>Derīguma termiņš</th>
                        <th>Statuss</th>
                        <th>Darbības</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>

                            <td class="product-name">
                                {{ $product->name }}
                            </td>

                            <td>
                                <span class="quantity-badge">
                                    {{ $product->quantity }}
                                </span>
                            </td>

                            <td class="description-cell">
                                {{ $product->description ?? 'Nav apraksta' }}
                            </td>

                            <td class="price-cell">
                                {{ number_format($product->price, 2) }} €
                            </td>

                            <td>
                                {{ $product->expiration_date?->format('d.m.Y') ?? '-' }}
                            </td>

                            <td>
                                <span class="status-badge status-{{ $product->status }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>

                            <td>
                                <div class="action-buttons">

                                    <a href="{{ route('products.show', $product) }}"
                                       class="btn btn-view">
                                        Apskatīt
                                    </a>

                                    <a href="{{ route('products.edit', $product) }}"
                                       class="btn btn-edit">
                                        Rediģēt
                                    </a>

                                    <form action="{{ route('products.destroy', $product) }}"
                                          method="POST"
                                          onsubmit="return confirm('Vai tiešām vēlaties dzēst šo produktu?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-delete">
                                            Dzēst
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-message">
                                Produktu vēl nav.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-layout>
