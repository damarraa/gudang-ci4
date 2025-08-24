<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-8 max-w-2xl">
        <h1 class="text-3xl font-bold mb-6 text-gray-800"><?= esc($title) ?></h1>

        <?php if (session('errors')): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Terjadi Kesalahan!</strong>
                <ul class="mt-2 list-disc list-inside">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/purchases" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="purchase_date" class="block text-gray-700 text-sm font-bold mb-2">Tanggal Pembelian:</label>
                    <input type="date" name="purchase_date" id="purchase_date" value="<?= old('purchase_date', date('Y-m-d')) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

                    <?php if (session('errors.purchase_date')): ?>
                        <p class="text-red-500 text-xs mt-1"><?= session('errors.purchase_date') ?></p>
                    <?php endif ?>
                </div>

                <div class="mb-4">
                    <label for="buyer_name" class="block text-gray-700 text-sm font-bold mb-2">Nama Pembeli:</label>
                    <input type="text" name="buyer_name" id="buyer_name" value="<?= old('buyer_name') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

                    <?php if (session('errors.buyer_name')): ?>
                        <p class="text-red-500 text-xs mt-1"><?= session('errors.buyer_name') ?></p>
                    <?php endif ?>
                </div>
            </div>

            <div class="mb-4">
                <label for="vendor_name" class="block text-gray-700 text-sm font-bold mb-2">Nama Vendor:</label>
                <input type="text" name="vendor_name" id="vendor_name" value="<?= old('vendor_name') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

                <?php if (session('errors.vendor_name')): ?>
                    <p class="text-red-500 text-xs mt-1"><?= session('errors.vendor_name') ?></p>
                <?php endif ?>
            </div>

            <div class="mb-4">
                <label for="vendor_address" class="block text-gray-700 text-sm font-bold mb-2">Alamat Vendor (Opsional):</label>
                <textarea name="vendor_address" id="vendor_address" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"><?= old('vendor_address') ?></textarea>
            </div>

            <div class="flex items-center justify-between mt-6">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan & Lanjut Tambah Barang
                </button>
                <a href="/purchases" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Batal
                </a>
            </div>
        </form>
    </div>
</body>

</html>