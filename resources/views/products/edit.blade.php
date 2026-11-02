
<x-layout>
    <div class="page-container">

        <h1 class="page-title">Rediģēt produktu</h1>
        <p class="page-subtitle">
            Mainiet produkta informāciju.
        </p>

        <div class="form-card">

            <form action="{{ route('products.update', $product) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="form-grid">

                    <div class="form-group">
                        <label>Nosaukums</label>
                        <input type="text" name="name"
                               value="{{ old('name', $product->name) }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Daudzums</label>
                        <input type="number" name="quantity"
                               min="0"
                               value="{{ old('quantity', $product->quantity) }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Cena (€)</label>
                        <input type="number" name="price"
                               step="0.01" min="0"
                               value="{{ old('price', $product->price) }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Derīguma termiņš</label>
                        <input type="date" name="expiration_date"
                               value="{{ old('expiration_date', $product->expiration_date?->format('Y-m-d')) }}">
                    </div>

                    <div class="form-group">
                        <label>Statuss</label>
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
                    </div>

                    <div class="form-group full-width">
                        <label>Apraksts</label>
                        <textarea name="description">{{ old('description', $product->description) }}</textarea>
                    </div>

                </div>

                <div class="form-actions">
                    <a href="{{ route('products.index') }}"
                       class="btn btn-secondary">
                        Atpakaļ
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Saglabāt izmaiņas
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-layout>
