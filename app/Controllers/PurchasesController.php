<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\PurchaseDetailModel;
use App\Models\PurchaseModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PurchasesController extends ResourceController
{
    protected $purchaseModel;
    protected $purchaseDetailModel;
    protected $productModel;

    public function __construct()
    {
        $this->purchaseModel = new PurchaseModel();
        $this->purchaseDetailModel = new PurchaseDetailModel();
        $this->productModel = new ProductModel();
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data = [
            'title' => 'Daftar Transaksi Pembelian',
            'purchases' => $this->purchaseModel->orderBy('purchase_date', 'DESC')->paginate(10),
            'pager' => $this->purchaseModel->pager,
        ];

        return view('purchases/index', $data);
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
        $data = [
            'title' => 'Detail Transaksi Pembelian',
            'purchase' => $this->purchaseModel->find($id),
            'purchase_details' => $this->purchaseDetailModel->getDetailsByPurchaseId($id),
            'products' => $this->productModel->findAll(),
        ];

        if (empty($data['purchase'])) {
            throw new PageNotFoundException('Transaksi pembelian tidak ditemukan.');
        }

        return view('purchases/show', $data);
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        $data = [
            'title' => 'Buat Transaksi Pembelian Baru'
        ];

        return view('purchases/new', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $rules = [
            'purchase_date' => 'required|valid_date',
            'vendor_name' => 'required|min_length[3]',
            'buyer_name' => 'required|min_length[3]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'purchase_date' => $this->request->getPost('purchase_date'),
            'vendor_name' => $this->request->getPost('vendor_name'),
            'vendor_address' => $this->request->getPost('vendor_address'),
            'buyer_name' => $this->request->getPost('buyer_name'),
        ];

        if ($this->purchaseModel->save($data)) {
            $newPurchaseId = $this->purchaseModel->getInsertID();
            return redirect()->to('/purchases/' . $newPurchaseId)
                ->with('message', 'Master pembelian berhasil dibuat. Silahkan tambahkan detail barang.');
        }

        return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data pembelian.');
    }

    /**
     * Method custom untuk menambahkan item ke dalam purchase.
     */
    public function addItem()
    {
        $purchaseId = $this->request->getPost('purchase_id');

        $rules = [
            'purchase_id' => 'required|is_not_unique[purchases.id]',
            'product_id' => [
                'label' => 'Barang',
                'rules' => "required|is_not_unique[products.id]|is_unique[purchase_details.product_id,purchase_id,{$purchaseId}]",
                'errors' => [
                    'is_unique' => 'Barang ini sudah ditambahkan ke dalam pembelian.'
                ]
            ],
            'quantity' => [
                'label' => 'Jumlah',
                'rules' => 'required|numeric|greater_than[0]'
            ]
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->purchaseDetailModel->save([
            'purchase_id' => $purchaseId,
            'product_id' => $this->request->getPost('product_id'),
            'quantity' => $this->request->getPost('quantity'),
        ]);

        return redirect()->to('/purchases/' . $purchaseId)->with('message', 'Barang berhasil ditambahkan.');
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
        $items = $this->request->getPost('items') ?? [];
        $newItem = $this->request->getPost('new_item');

        $this->purchaseDetailModel->db->transStart();
        $this->purchaseDetailModel->where('purchase_id', $id)->delete();

        foreach ($items as $item) {
            if (!isset($item['delete'])) {
                $this->purchaseDetailModel->insert([
                    'purchase_id' => $id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        }

        if (!empty($newItem['product_id']) && !empty($newItem['quantity'])) {
            $this->purchaseDetailModel->insert([
                'purchase_id' => $id,
                'product_id' => $newItem['product_id'],
                'quantity' => $newItem['quantity'],
            ]);
        }

        $this->purchaseDetailModel->db->transComplete();

        return redirect()->to('/purchases/' . $id)->with('message', 'Transaksi pembelian berhasil diupdate.');
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
