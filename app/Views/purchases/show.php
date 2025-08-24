<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-800"><?= esc($title) ?></h1>
        <a href="/purchases" class="text-blue-500 hover:text-blue-700 text-sm">&larr; Kembali ke Daftar Pembelian</a>
    </div>
</div>

<?php if (session('message')) : ?>
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p><?= session('message') ?></p>
    </div>
<?php endif; ?>
<?php if (session('errors')): ?>
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p class="font-bold">Terjadi Kesalahan!</p>
        <ul class="mt-2 list-disc list-inside">
            <?php foreach (session('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="/purchases/<?= esc($purchase['id']) ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-bold mb-4 border-b pb-2 text-gray-700">Informasi Pembelian</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-8 gap-y-4 text-sm">
            <div>
                <dt class="text-gray-500 font-medium">ID Pembelian</dt>
                <dd class="text-gray-900 font-semibold">#<?= esc($purchase['id']) ?></dd>
            </div>
            <div>
                <dt class="text-gray-500 font-medium">Tanggal</dt>
                <dd class="text-gray-900"><?= esc(date('d M Y', strtotime($purchase['purchase_date']))) ?></dd>
            </div>
            <div>
                <dt class="text-gray-500 font-medium">Vendor</dt>
                <dd class="text-gray-900"><?= esc($purchase['vendor_name']) ?></dd>
            </div>
            <div>
                <dt class="text-gray-500 font-medium">Pembeli</dt>
                <dd class="text-gray-900"><?= esc($purchase['buyer_name']) ?></dd>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg my-6 overflow-x-auto">
        <h2 class="text-xl font-bold border-b pb-2 p-6 text-gray-700">Detail Barang</h2>
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Barang</th>
                    <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Jumlah</th>
                    <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Hapus?</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (!empty($purchase_details)): ?>
                    <?php foreach ($purchase_details as $index => $detail): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="py-4 px-6 text-sm text-gray-900">
                                <input type="hidden" name="items[<?= $index ?>][product_id]" value="<?= esc($detail['product_id']) ?>">
                                <?= esc($detail['product_code']) ?> - <?= esc($detail['product_name']) ?>
                            </td>
                            <td class="py-4 px-6 text-center">
                                <input type="number" name="items[<?= $index ?>][quantity]" value="<?= esc($detail['quantity']) ?>" min="1" class="shadow-sm appearance-none border rounded w-24 text-center py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </td>
                            <td class="py-4 px-6 text-center">
                                <input type="checkbox" name="items[<?= $index ?>][delete]" value="1" class="h-5 w-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

                <tr class="bg-gray-50 border-t-2">
                    <td class="p-4">
                        <select name="new_item[product_id]" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Tambah Barang Baru --</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= esc($product['id']) ?>"><?= esc($product['code']) ?> - <?= esc($product['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td class="p-4">
                        <input type="number" name="new_item[quantity]" placeholder="Jumlah" min="1" class="shadow-sm appearance-none border rounded w-24 text-center py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </td>
                    <td class="p-4"></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="flex justify-end mt-6">
        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
            Update Transaksi Pembelian
        </button>
    </div>
</form> <?= $this->endSection() ?>