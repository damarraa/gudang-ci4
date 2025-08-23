<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOutgoingItemsTable extends Migration
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
            'product_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'quantity' => [
                'type' => 'FLOAT',
            ],
            'outgoing_date' => [
                'type' => 'DATETIME',
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'RESTRICT');

        $this->forge->createTable('outgoing_items');
    }

    public function down()
    {
        $this->forge->dropTable('outgoing_items');
    }
}
