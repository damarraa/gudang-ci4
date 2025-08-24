<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Kategori</h1>

        <form action="/categories/<?= esc($category['id']) ?>" method="POST" class="bg-white p-6 rounded-lg shadow-md">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori:</label>
                <input type="text" name="name" id="name" value="<?= old('name', esc($category['name'])) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">

                <?php if (session('errors.name')): ?>
                    <p class="text-red-500 text-xs mt-1"><?= session('errors.name') ?></p>
                <?php endif; ?>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan
                </button>
                <a href="/categories" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Batal
                </a>
            </div>
        </form>
    </div>

<?= $this->endSection() ?>