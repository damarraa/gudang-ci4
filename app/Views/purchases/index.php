<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>

<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">
            <?= esc($title) ?>
        </h1>

        <?php if (session('message')): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?= session('message') ?></span>
            </div>
        <?php endif; ?>

        <a href="/purchases/new" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
            + Buat Transaksi Pembelian Baru
        </a>

        <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">No.</th>
                        <th class="py-3 px-6 text-left">Tanggal</th>
                        <th class="py-3 px-6 text-left">Vendor</th>
                        <th class="py-3 px-6 text-left">Pembeli</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php if (!empty($purchases) && is_array($purchases)): ?>

                        <?php $i = (($pager->getCurrentPage() - 1) * $pager->getPerPage()) + 1; ?>

                        <?php foreach ($purchases as $purchase): ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <?= $i++ ?>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <?= esc(date('d M Y', strtotime($purchase['purchase_date']))) ?>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <?= esc($purchase['vendor_name']) ?>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <?= esc($purchase['buyer_name']) ?>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <span class="bg-yellow-200 text-yellow-600 py-1 px-3 rounded-full text-xs">
                                        <?= esc($purchase['status']) ?>
                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <a href="/purchases/<?= esc($purchase['id']) ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-xs">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-3 px-6 text-center">Belum ada transaksi pembelian.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="mt-6">
                <?= $pager->links() ?>
            </div>
        </div>
    </div>
</body>

</html>