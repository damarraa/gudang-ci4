<?php

namespace App\Controllers;

use App\Models\OutgoingItemModel;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Config\Database;

class OutgoingController extends ResourceController
{
    protected $outgoingItemModel;
    protected $productModel;
    protected $db;

    public function __construct()
    {
        $this->outgoingItemModel = new OutgoingItemModel();
        $this->productModel = new ProductModel();
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
            'title' => 'Catat Barang Keluar',
            'products' => $this->productModel->findAll(),
            'log' => $this->outgoingItemModel->getOutgoingItemsWithProductName()->paginate(5),
            'pager' => $this->outgoingItemModel->pager,
        ];

        return view('outgoing/index', $data);
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
        $rules = [
            'product_id' => 'required',
            'quantity' => 'required|numeric|greater_than[0]',
            'description' => 'required',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $productId = $this->request->getPost('product_id');
        $quantity = $this->request->getPost('quantity');
        $product = $this->productModel->find($productId);

        if ($product['stock'] < $quantity) {
            return redirect()->back()->withInput()->with('error', 'Stok tidak mencukupi. Stok saat ini: ' . $product['stock']);
        }

        $this->db->transStart();
        $this->productModel->where('id', $productId)->decrement('stock', $quantity);

        $this->outgoingItemModel->insert([
            'product_id' => $productId,
            'quantity' => $quantity,
            'description' => $this->request->getPost('description'),
            'outgoing_date' => date('Y-m-d H:i')
        ]);

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return redirect()->to('/outgoing')->with('error', 'Gagal mencatat barang keluar.');
        }

        return redirect()->to('/outgoing')->with('message', 'Barang keluar berhasil dicatat.');
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
