<?php

namespace App\Controllers;

use App\Models\IncomingItemModel;
use App\Models\OutgoingItemModel;
use App\Models\ProductModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ReportsController extends ResourceController
{
    protected $productModel;
    protected $incomingItemModel;
    protected $outgoingItemModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->incomingItemModel = new IncomingItemModel();
        $this->outgoingItemModel = new OutgoingItemModel();
    }

    public function stockReport()
    {
        $data = [
            'title' => 'Laporan Stok Barang Terkini',
            'products' => $this->productModel->getProductsWithCategory()->paginate(15),
            'pager' => $this->productModel->pager,
        ];

        return view('reports/stock', $data);
    }

    public function incomingReport()
    {
        $data = [
            'title' => 'Laporan Barang Masuk',
            'items' => $this->incomingItemModel->getIncomingItemsWithDetails()->paginate(15),
            'pager' => $this->incomingItemModel->pager,
        ];

        return view('reports/incoming', $data);
    }

    public function outgoingReport()
    {
        $data = [
            'title' => 'Laporan Barang Keluar',
            'items' => $this->outgoingItemModel->getOutgoingItemsWithProductName()->paginate(15),
            'pager' => $this->outgoingItemModel->pager,
        ];

        return view('reports/outgoing', $data);
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        //
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
