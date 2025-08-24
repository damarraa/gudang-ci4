<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->db->disableForeignKeyChecks();

        $this->db->table('outgoing_items')->truncate();
        $this->db->table('incoming_items')->truncate();
        $this->db->table('purchase_details')->truncate();
        $this->db->table('purchases')->truncate();
        $this->db->table('products')->truncate();
        $this->db->table('categories')->truncate();

        $categories = [
            ['name' => 'Alat Tulis Kantor', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Elektronik & Aksesoris', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['name' => 'Perabotan Kantor', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('categories')->insertBatch($categories);

        $products = [
            ['id' => 1, 'category_id' => 1, 'name' => 'Kertas HVS A4 70gr', 'code' => 'ATK-001', 'unit' => 'rim', 'stock' => 10, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 2, 'category_id' => 1, 'name' => 'Pulpen Pilot G2 Hitam', 'code' => 'ATK-002', 'unit' => 'pcs', 'stock' => 50, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 3, 'category_id' => 2, 'name' => 'Mouse Logitech M185 Wireless', 'code' => 'ELK-001', 'unit' => 'unit', 'stock' => 25, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => 4, 'category_id' => 3, 'name' => 'Meja Kantor Aditech', 'code' => 'PRB-001', 'unit' => 'unit', 'stock' => 5, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('products')->insertBatch($products);

        $purchases = [
            ['id' => 1, 'vendor_name' => 'PT ATK Jaya', 'purchase_date' => '2025-08-20', 'buyer_name' => 'Andi', 'status' => 'Completed', 'created_at' => date('Y-m-d H:i:s')],
            ['id' => 2, 'vendor_name' => 'CV Furnitur Abadi', 'purchase_date' => '2025-08-23', 'buyer_name' => 'Budi', 'status' => 'Pending', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('purchases')->insertBatch($purchases);

        $purchase_details = [
            ['purchase_id' => 1, 'product_id' => 1, 'quantity' => 20], // 20 rim Kertas
            ['purchase_id' => 1, 'product_id' => 2, 'quantity' => 50], // 50 pcs Pulpen
            ['purchase_id' => 2, 'product_id' => 4, 'quantity' => 5], // 5 unit Meja
        ];
        $this->db->table('purchase_details')->insertBatch($purchase_details);

        $incoming_items = [
            ['purchase_id' => 1, 'product_id' => 1, 'quantity' => 20, 'incoming_date' => '2025-08-21 10:00:00', 'created_at' => date('Y-m-d H:i:s')],
            ['purchase_id' => 1, 'product_id' => 2, 'quantity' => 50, 'incoming_date' => '2025-08-21 10:00:00', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('incoming_items')->insertBatch($incoming_items);

        $outgoing_items = [
            ['product_id' => 2, 'quantity' => 10, 'outgoing_date' => '2025-08-22 14:30:00', 'description' => 'Untuk kebutuhan tim marketing', 'created_at' => date('Y-m-d H:i:s')],
            ['product_id' => 3, 'quantity' => 2, 'outgoing_date' => '2025-08-23 11:00:00', 'description' => 'Mouse rusak, diganti baru', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('outgoing_items')->insertBatch($outgoing_items);
        // Stok Kertas: 10 (awal) + 20 (masuk) = 30
        $this->db->table('products')->where('id', 1)->update(['stock' => 30]);
        // Stok Pulpen: 50 (awal) + 50 (masuk) - 10 (keluar) = 90
        $this->db->table('products')->where('id', 2)->update(['stock' => 90]);
        // Stok Mouse: 25 (awal) - 2 (keluar) = 23
        $this->db->table('products')->where('id', 3)->update(['stock' => 23]);
        // Stok Meja tidak berubah karena pembeliannya masih 'Pending'

        $this->db->enableForeignKeyChecks();
    }
}
