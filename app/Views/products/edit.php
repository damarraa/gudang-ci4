<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
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

<form action="/products/<?= esc($product['id']) ?>" method="POST" class="bg-white p-6 rounded-lg shadow-md">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="mb-4">
            <label for="code" class="block text-gray-700 text-sm font-bold mb-2">Kode Barang:</label>
            <input type="text" name="code" id="code" value="<?= old('code', esc($product['code'])) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

            <?php if (session('errors.code')): ?>
                <p class="text-red-500 text-xs mt-1"><?= session('errors.code') ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Barang:</label>
            <input type="text" name="name" id="name" value="<?= old('name', esc($product['name'])) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

            <?php if (session('errors.name')): ?>
                <p class="text-red-500 text-xs mt-1"><?= session('errors.name') ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Kategori:</label>
            <select name="category_id" id="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">-- Pilih Kategori --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= esc($category['id']) ?>" <?= (old('category_id', $product['category_id']) == $category['id']) ? 'selected' : '' ?>>
                        <?= esc($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-4">
            <label for="unit" class="block text-gray-700 text-sm font-bold mb-2">Satuan:</label>
            <input type="text" name="unit" id="unit" value="<?= old('unit', esc($product['unit'])) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

            <?php if (session('errors.unit')): ?>
                <p class="text-red-500 text-xs mt-1"><?= session('errors.unit') ?></p>
            <?php endif; ?>
        </div>

        <div class="mb-4">
            <label for="stock" class="block text-gray-700 text-sm font-bold mb-2">Satuan:</label>
            <input type="number" name="stock" id="stock" value="<?= old('stock', esc($product['stock'])) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

            <?php if (session('errors.stock')): ?>
                <p class="text-red-500 text-xs mt-1"><?= session('errors.stock') ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="flex items-center justify-between mt-6">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Simpan
        </button>
        <a href="/products" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
            Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>