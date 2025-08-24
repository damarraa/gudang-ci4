<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= (isset($title) ? esc($title) . ' - ' : '') ?>Sistem Manajemen Gudang Sederhana</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">

    <div class="flex h-screen bg-gray-200">
        <aside class="w-64 bg-gray-800 text-white flex-shrink-0">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-white">Sistem Manajemen Gudang Sederhana</h2>
            </div>
            <nav class="mt-6">
                <h3 class="px-6 text-xs uppercase text-gray-400 font-semibold tracking-wider">Menu Utama</h3>
                <a href="/categories" class="block py-2.5 px-6 hover:bg-gray-700">Kategori</a>
                <a href="/products" class="block py-2.5 px-6 hover:bg-gray-700">Barang</a>

                <h3 class="px-6 mt-6 text-xs uppercase text-gray-400 font-semibold tracking-wider">Transaksi</h3>
                <a href="/purchases" class="block py-2.5 px-6 hover:bg-gray-700">Pembelian</a>
                <a href="/incoming" class="block py-2.5 px-6 hover:bg-gray-700">Barang Masuk</a>
                <a href="/outgoing" class="block py-2.5 px-6 hover:bg-gray-700">Barang Keluar</a>

                <h3 class="px-6 mt-6 text-xs uppercase text-gray-400 font-semibold tracking-wider">Laporan</h3>
                <a href="/reports/stock" class="block py-2.5 px-6 hover:bg-gray-700">Laporan Stok</a>
                <a href="/reports/incoming" class="block py-2.5 px-6 hover:bg-gray-700">Laporan Masuk</a>
                <a href="/reports/outgoing" class="block py-2.5 px-6 hover:bg-gray-700">Laporan Keluar</a>
            </nav>
        </aside>

        <main class="flex-1 overflow-y-auto">
            <div class="p-8">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>

</body>

</html>