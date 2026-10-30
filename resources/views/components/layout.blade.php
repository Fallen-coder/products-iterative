<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produktu sistēma</title>
    @vite(['resources/css/app.css'])
</head>
<body>

<div class="holy-grail">

    <header class="header">
        <h2>TEST LOGO – PRODUCT SYSTEM</h2>
    </header>

    <nav class="nav">
        <h3>Navigācija</h3>

        <ul class="nav-list">
            <li><a href="{{ route('products.index') }}">Produkti</a></li>
            <li><a href="{{ route('products.create') }}">Pievienot produktu</a></li>
            <li><a href="#">Sākums</a></li>
            <li><a href="#">Par mums</a></li>
        </ul>
    </nav>

    <main class="main">
        <x-success-message />
        <x-validation-errors />

        {{ $slot }}
    </main>

    <aside class="sidebar">
        <h3>Reklāma</h3>
        <p>TEST REKLĀMA – iegādājies mūsu produktus jau šodien!</p>
    </aside>

    <footer class="footer">
        <p>Copyright © 2026 Product System. Visas tiesības aizsargātas.</p>
    </footer>

</div>

</body>
</html>