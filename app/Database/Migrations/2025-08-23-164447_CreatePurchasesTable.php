<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePurchasesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'vendor_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'vendor_address' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'purchase_date' => [
                'type' => 'DATE',
            ],
            'buyer_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'Pending',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('purchases');
    }

    public function down()
    {
        $this->forge->dropTable('purchases');
    }
}
