<?php

namespace App\Controllers;

use App\Models\IncomingItemModel;
use App\Models\ProductModel;
use App\Models\PurchaseDetailModel;
use App\Models\PurchaseModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Config\Database;

class IncomingController extends ResourceController
{
    protected $purchaseModel;
    protected $purchaseDetailModel;
    protected $productModel;
    protected $incomingItemModel;
    protected $db;

    public function __construct()
    {
        $this->purchaseModel = new PurchaseModel();
        $this->purchaseDetailModel = new PurchaseDetailModel();
        $this->productModel = new ProductModel();
        $this->incomingItemModel = new IncomingItemModel();
        $this->db = Database::connect();
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data = [
            'title' => 'Daftar Penerimaan Barang',
            'purchases' => $this->purchaseModel->where('status', 'Pending')->orderBy('purchase_date', 'ASC')->findAll(),
        ];

        return view('incoming/index', $data);
    }

    /**
     * Method custom untuk proses penerimaan product.
     */
    public function process($id = null)
    {
        $this->db->transStart();
        $items = $this->purchaseDetailModel->where('purchase_id', $id)->findAll();

        if (empty($items)) {
            return redirect()->back()->with('error', 'Pembelian ini tidak memiliki detail barang.');
        }

        foreach ($items as $item) {
            $this->productModel->where('id', $item['product_id'])->increment('stock', $item['quantity']);

            $this->incomingItemModel->insert([
                'purchase_id' => $id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'incoming_date' => date('Y-m-d H:i')
            ]);
        }

        $this->purchaseModel->update($id, ['status' => 'Completed']);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->to('/incoming')->with('error', 'Terjadi kesalahan saat memproses penerimaan barang.');
        }

        return redirect()->to('/incoming')->with('message', 'Penerimaan barang untuk pembelian #' . $id . ' berhasil diproses dan stok telah diperbarui.');
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
