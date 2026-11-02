
<x-layout>
    <div class="page-container">

        <h1 class="page-title">Jauns produkts</h1>
        <p class="page-subtitle">
            Pievienojiet jaunu produktu savam inventāram.
        </p>

        <div class="form-card">

            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                <div class="form-grid">

                    <div class="form-group">
                        <label>Nosaukums</label>
                        <input type="text" name="name"
                               value="{{ old('name') }}"
                               placeholder="Produkta nosaukums"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Daudzums</label>
                        <input type="number" name="quantity"
                               min="0"
                               value="{{ old('quantity', 0) }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Cena (€)</label>
                        <input type="number" name="price"
                               step="0.01" min="0"
                               value="{{ old('price', 0) }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label>Derīguma termiņš</label>
                        <input type="date" name="expiration_date"
                               value="{{ old('expiration_date') }}">
                    </div>

                    <div class="form-group">
                        <label>Statuss</label>
                        <select name="status">
                            <option value="active"
                                @selected(old('status', 'active') == 'active')>
                                Aktīvs
                            </option>

                            <option value="inactive"
                                @selected(old('status') == 'inactive')>
                                Neaktīvs
                            </option>

                            <option value="expired"
                                @selected(old('status') == 'expired')>
                                Beidzies
                            </option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label>Apraksts</label>
                        <textarea name="description"
                                  placeholder="Produkta apraksts...">{{ old('description') }}</textarea>
                    </div>

                </div>

                <div class="form-actions">
                    <a href="{{ route('products.index') }}"
                       class="btn btn-secondary">
                        Atpakaļ
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Saglabāt produktu
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-layout>
