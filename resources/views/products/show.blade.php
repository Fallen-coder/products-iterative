
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

        <button type="button"
                id="decrease-btn"
                onclick="changeQuantity('decrease')"
                {{ $product->quantity <= 0 ? 'disabled' : '' }}>
            − Samazināt
        </button>

        <strong id="product-quantity">
            {{ $product->quantity }}
        </strong>

        <button type="button"
                id="increase-btn"
                onclick="changeQuantity('increase')">
            + Palielināt
        </button>

    </div>

    <p id="quantity-message"></p>

</div>

            <div class="detail-item" style="margin-top: 25px;">

    <span class="detail-label">Produkta birkas</span>

    <form action="{{ route('products.update', $product) }}"
          method="POST"
          id="product-tags-form">

        @csrf
        @method('PUT')

        <input type="hidden" name="name"
               value="{{ $product->name }}">

        <input type="hidden" name="quantity"
               value="{{ $product->quantity }}">

        <input type="hidden" name="description"
               value="{{ $product->description }}">

        <input type="hidden" name="price"
               value="{{ $product->price }}">

        <input type="hidden" name="expiration_date"
               value="{{ $product->expiration_date?->format('Y-m-d') }}">

        <input type="hidden" name="status"
               value="{{ $product->status }}">

        <div class="tag-container" id="tag-container">

            @foreach($product->tags as $tag)
                <span class="tag-item">
                    {{ $tag->name }}

                    <button type="button"
                            class="remove-tag"
                            data-tag="{{ $tag->name }}">
                        ×
                    </button>

                    <input type="hidden"
                           name="tags[]"
                           value="{{ $tag->name }}">
                </span>
            @endforeach

        </div>

        <div style="position: relative; margin-top: 12px;">

            <input type="text"
                   id="tag-input"
                   placeholder="Ievadi birkas nosaukumu..."
                   autocomplete="off">

            <div id="tag-suggestions"></div>

        </div>

        <button type="submit" class="btn btn-primary"
                style="margin-top: 15px;">
            Update
        </button>

    </form>
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

<script>

    function changeQuantity(action) {

        const increaseBtn = document.getElementById('increase-btn');
        const decreaseBtn = document.getElementById('decrease-btn');
        const quantityElement = document.getElementById('product-quantity');
        const messageElement = document.getElementById('quantity-message');

        const url = action === 'increase'
            ? "{{ route('products.increase', $product) }}"
            : "{{ route('products.decrease', $product) }}";

        // Deaktivizē pogas pieprasījuma laikā
        increaseBtn.disabled = true;
        decreaseBtn.disabled = true;

        messageElement.textContent = '';

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })

        .then(response => response.json().then(data => ({
            status: response.status,
            data: data
        })))

        .then(result => {

            if (!result.data.success) {
                throw new Error(result.data.message);
            }

            // Atjaunina daudzumu bez lapas pārlādes
            quantityElement.textContent = result.data.quantity;

            // Deaktivizē samazināšanas pogu, ja daudzums ir 0
            decreaseBtn.disabled = result.data.quantity <= 0;

            messageElement.textContent = result.data.message;
            messageElement.style.color = 'green';

        })

        .catch(error => {

            messageElement.textContent = error.message;
            messageElement.style.color = 'red';

        })

        .finally(() => {

            increaseBtn.disabled = false;

            decreaseBtn.disabled =
                parseInt(quantityElement.textContent) <= 0;

        });

    }


document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('tag-input');
    const container = document.getElementById('tag-container');
    const suggestions = document.getElementById('tag-suggestions');

    let selectedTags = [];

    // Ielādē jau izvēlētās birkas
    container.querySelectorAll('input[name="tags[]"]').forEach(el => {
        selectedTags.push(el.value.toLowerCase());
    });

    let searchTimeout;

    // Meklē esošās birkas
    input.addEventListener('input', function () {

        clearTimeout(searchTimeout);

        const query = input.value.trim();

        if (!query) {
            suggestions.innerHTML = '';
            return;
        }

        searchTimeout = setTimeout(() => {

            fetch(`{{ route('tags.search') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(tags => {

                    suggestions.innerHTML = '';

                    tags.forEach(tag => {

                        if (selectedTags.includes(tag.name.toLowerCase())) {
                            return;
                        }

                        const item = document.createElement('div');

                        item.textContent = tag.name;
                        item.classList.add('tag-suggestion');

                        item.addEventListener('click', function () {
                            addTag(tag.name);
                        });

                        suggestions.appendChild(item);
                    });

                });

        }, 200);
    });

    // Izvēlas birku ar Enter
    input.addEventListener('keydown', function (e) {

        if (e.key === 'Enter') {
            e.preventDefault();

            const firstSuggestion = suggestions.querySelector('.tag-suggestion');

            if (firstSuggestion) {
                firstSuggestion.click();
            } else if (input.value.trim()) {
                addTag(input.value.trim());
            }
        }
    });

    // Pievieno birku sarakstam
    function addTag(name) {

        name = name.trim();

        if (!name) return;

        if (selectedTags.includes(name.toLowerCase())) {
            input.value = '';
            suggestions.innerHTML = '';
            return;
        }

        selectedTags.push(name.toLowerCase());

        const tag = document.createElement('span');
        tag.classList.add('tag-item');

        const text = document.createTextNode(name + ' ');

        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('remove-tag');
        removeButton.textContent = '×';

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'tags[]';
        hiddenInput.value = name;

        removeButton.addEventListener('click', function () {
            removeTag(name, tag);
        });

        tag.appendChild(text);
        tag.appendChild(removeButton);
        tag.appendChild(hiddenInput);

        container.appendChild(tag);

        input.value = '';
        suggestions.innerHTML = '';
    }

    // Dzēš birku no saraksta
    function removeTag(name, element) {

        selectedTags = selectedTags.filter(
            tag => tag !== name.toLowerCase()
        );

        element.remove();
    }

    // Dzēš arī sākotnēji ielādētās birkas
    container.querySelectorAll('.remove-tag').forEach(button => {

        button.addEventListener('click', function () {

            const tagElement = button.closest('.tag-item');
            const name = button.dataset.tag;

            removeTag(name, tagElement);

        });

    });

    // Aizver ieteikumus, noklikšķinot ārpus lauka
    document.addEventListener('click', function (e) {

        if (!input.contains(e.target) &&
            !suggestions.contains(e.target)) {

            suggestions.innerHTML = '';
        }
    });

});
</script>

</x-layout>
