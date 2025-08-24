<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1 class="text-3xl font-bold mb-6 text-gray-800">
    <?= esc($title) ?>
</h1>

<?php if (session('message')): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <span class="block sm:inline"><?= session('message') ?></span>
    </div>
<?php endif; ?>

<a href="/products/new" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
    + Tambah Barang
</a>

<div class="bg-white shadow-md rounded my-6 overflow-x-auto">
    <table class="min-w-full table-auto">
        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <tr>
                <th class="py-3 px-6 text-left">No.</th>
                <th class="py-3 px-6 text-left">Kode</th>
                <th class="py-3 px-6 text-left">Nama Barang</th>
                <th class="py-3 px-6 text-left">Kategori</th>
                <th class="py-3 px-6 text-left">Satuan</th>
                <th class="py-3 px-6 text-left">Stok</th>
                <th class="py-3 px-6 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            <?php if (!empty($products) && is_array($products)): ?>

                <?php $i = (($pager->getCurrentPage() - 1) * $pager->getPerPage()) + 1; ?>

                <?php foreach ($products as $product): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <?= $i++ ?>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <?= esc($product['code']) ?>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <?= esc($product['name']) ?>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <?= esc($product['category_name']) ?>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <?= esc($product['unit']) ?>
                        </td>
                        <td class="py-3 px-6 text-left">
                            <?= esc($product['stock']) ?>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex items-center justify-center">
                                <a href="/products/<?= esc($product['id']) ?>/edit" class="w-8 h-8 rounded bg-blue-500 text-white flex items-center justify-center mr-2 hover:bg-blue-600" title="Edit">📝</a>
                                <form action="/products/<?= esc($product['id']) ?>" method="POST" class="inline w-8 h-8 rounded bg-red-500 text-white flex items-center justify-center hover:bg-red-600" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="w-8 h-8 rounded bg-red-500 text-white flex items-center justify-center hover:bg-red-600" title="Hapus">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="py-3 px-6 text-center">Tidak ada data barang.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="mt-6">
        <?= $pager->links() ?>
    </div>
</div>

<?= $this->endSection() ?>