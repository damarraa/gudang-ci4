<?php

namespace App\Models;

use CodeIgniter\Model;

class PurchaseDetailModel extends Model
{
    protected $table            = 'purchase_details';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['purchase_id', 'product_id', 'quantity'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // Get purchase_id
    public function getDetailsByPurchaseId($purchaseId)
    {
        return $this->select('purchase_details.*, products.name as product_name, products.code as product_code')
            ->join('products', 'products.id = purchase_details.product_id')
            ->where('purchase_details.purchase_id', $purchaseId)
            ->findAll();
    }
}
