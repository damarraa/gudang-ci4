<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= esc($title) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-800"><?= esc($title) ?></h1>

        <div class="bg-white shadow-md rounded my-6 overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">No.</th>
                        <th class="py-3 px-6 text-left">Tanggal Masuk</th>
                        <th class="py-3 px-6 text-left">Kode Barang</th>
                        <th class="py-3 px-6 text-left">Nama Barang</th>
                        <th class="py-3 px-6 text-left">Vendor</th>
                        <th class="py-3 px-6 text-center">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php if (!empty($items)): ?>
                        <?php $i = (($pager->getCurrentPage() - 1) * $pager->getPerPage()) + 1; ?>
                        <?php foreach ($items as $item): ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left"><?= $i++ ?></td>
                                <td class="py-3 px-6 text-left"><?= esc(date('d M Y, H:i', strtotime($item['incoming_date']))) ?></td>
                                <td class="py-3 px-6 text-left"><?= esc($item['product_code']) ?></td>
                                <td class="py-3 px-6 text-left"><?= esc($item['product_name']) ?></td>
                                <td class="py-3 px-6 text-left"><?= esc($item['vendor_name']) ?></td>
                                <td class="py-3 px-6 text-center font-medium"><?= esc($item['quantity']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-3 px-6 text-center">Tidak ada data barang masuk.</td>
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