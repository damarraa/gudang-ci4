<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-8 max-w-4xl">
        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
            <h1 class="text-2xl font-bold mb-6 text-gray-800"><?= esc($title) ?></h1>

            <?php if (session('message')) : ?>
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p><?= session('message') ?></p>
                </div>
            <?php endif; ?>
            <?php if (session('error')) : ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p><?= session('error') ?></p>
                </div>
            <?php endif; ?>
            <?php if (session('errors')) : ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <ul class="list-disc list-inside">
                        <?php foreach (session('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif ?>

            <form action="/outgoing" method="POST">
                <?= csrf_field() ?>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <label for="product_id" class="block text-gray-700 text-sm font-bold mb-2">Pilih Barang:</label>
                        <select name="product_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                            <option value="">-- Pilih Barang --</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= esc($product['id']) ?>" <?= old('product_id') == $product['id'] ? 'selected' : '' ?>>(Stok: <?= esc($product['stock']) ?>) <?= esc($product['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">Jumlah Keluar:</label>
                        <input type="number" name="quantity" value="<?= old('quantity') ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" min="1" required>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Keterangan:</label>
                    <textarea name="description" rows="2" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required><?= old('description') ?></textarea>
                </div>
                <div class="mt-6 text-right">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Catat</button>
                </div>
            </form>
        </div>

        <h2 class="text-2xl font-bold mb-4 text-gray-700">Log Barang Keluar</h2>
        <div class="bg-white shadow-md rounded">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm">
                    <tr>
                        <th class="py-3 px-6 text-left">Tanggal</th>
                        <th class="py-3 px-6 text-left">Barang</th>
                        <th class="py-3 px-6 text-center">Jumlah</th>
                        <th class="py-3 px-6 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm">
                    <?php if (!empty($log)): foreach ($log as $item): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-6 text-left"><?= esc(date('d M Y, H:i', strtotime($item['outgoing_date']))) ?></td>
                                <td class="py-3 px-6 text-left"><?= esc($item['product_name']) ?></td>
                                <td class="py-3 px-6 text-center"><?= esc($item['quantity']) ?></td>
                                <td class="py-3 px-6 text-left"><?= esc($item['description']) ?></td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td class="py-3 px-6 text-center">Belum ada data barang keluar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="p-4">
                <?= $pager->links() ?>
            </div>
            
        </div>
    </div>
</body>

</html>