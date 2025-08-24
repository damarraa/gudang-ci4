<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1 class="text-3xl font-bold mb-6 text-gray-800">
    <?= esc($title) ?>
</h1>

<?php if (session('message')): ?>
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p><?= session('message') ?></p>
    </div>
<?php endif; ?>

<div class="bg-white shadow-md rounded my-6">
    <table class="min-w-full table-auto">
        <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <tr>
                <th class="py-3 px-6 text-left">ID Pembelian</th>
                <th class="py-3 px-6 text-left">Tanggal</th>
                <th class="py-3 px-6 text-left">Vendor</th>
                <th class="py-3 px-6 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            <?php if (!empty($purchases)): ?>
                <?php foreach ($purchases as $purchase): ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left">#<?= esc($purchase['id']) ?></td>
                        <td class="py-3 px-6 text-left"><?= esc(date('d M Y', strtotime($purchase['purchase_date']))) ?></td>
                        <td class="py-3 px-6 text-left"><?= esc($purchase['vendor_name']) ?></td>
                        <td class="py-3 px-6 text-center">
                            <form action="/incoming/process/<?= esc($purchase['id']) ?>" method="POST" onsubmit="return confirm('Anda yakin ingin memproses penerimaan untuk pembelian ini? Stok akan diperbarui.');">
                                <?= csrf_field() ?>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-xs">
                                    Proses Penerimaan
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td class="py-3 px-6 text-center">Tidak ada pembelian yang perlu diproses.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection() ?>