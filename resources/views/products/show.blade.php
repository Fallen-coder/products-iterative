
<x-layout>
    <div class="page-container">

        <h1 class="page-title">{{ $product->name }}</h1>

        <p class="page-subtitle">
            Produkta informācija un krājumu pārvaldība.
        </p>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="details-card">

            <div class="details-grid">

                <div class="detail-item">
                    <span class="detail-label">Produkta ID</span>
                    <span class="detail-value">{{ $product->id }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Nosaukums</span>
                    <span class="detail-value">{{ $product->name }}</span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Cena</span>
                    <span class="detail-value">
                        {{ number_format($product->price, 2) }} €
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Derīguma termiņš</span>
                    <span class="detail-value">
                        {{ $product->expiration_date?->format('d.m.Y') ?? '-' }}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Statuss</span>
                    <span class="status-badge status-{{ $product->status }}">
                        {{ ucfirst($product->status) }}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="detail-label">Apraksts</span>
                    <span class="detail-value">
                        {{ $product->description ?? 'Nav apraksta' }}
                    </span>
                </div>

            </div>

            <div class="detail-item" style="margin-top: 20px;">
                <span class="detail-label">Produkta daudzums</span>

                <div class="quantity-control">

                    <form action="{{ route('products.decrease', $product) }}"
                          method="POST">
                        @csrf
                        <button type="submit"
                            {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                            − Samazināt
                        </button>
                    </form>

                    <strong>{{ $product->quantity }}</strong>

                    <form action="{{ route('products.increase', $product) }}"
                          method="POST">
                        @csrf
                        <button type="submit">
                            + Palielināt
                        </button>
                    </form>

                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('products.index') }}"
                   class="btn btn-secondary">
                    Atpakaļ
                </a>

                <a href="{{ route('products.edit', $product) }}"
                   class="btn btn-primary">
                    Rediģēt produktu
                </a>
            </div>

        </div>
    </div>
</x-layout>
