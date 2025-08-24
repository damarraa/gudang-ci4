<?php

namespace App\Controllers;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ProductsController extends ResourceController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data = [
            'title' => 'Daftar Barang',
            'products' => $this->productModel->getProductsWithCategory()->paginate(10),
            'pager' => $this->productModel->pager,
        ];

        return view('products/index', $data);
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
        $data = [
            'title' => 'Tambah Barang Baru',
            'categories' => $this->categoryModel->findAll(),
        ];

        return view('products/new', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $rules = [
            'category_id' => 'required',
            'name'        => 'required|min_length[3]',
            'code'        => 'required|is_unique[products.code]',
            'unit'        => 'required',
            'stock'       => 'required|numeric'
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productModel->save([
            'category_id' => $this->request->getPost('category_id'),
            'name'        => $this->request->getPost('name'),
            'code'        => $this->request->getPost('code'),
            'unit'        => $this->request->getPost('unit'),
            'stock'       => $this->request->getPost('stock'),
        ]);

        return redirect()->to('/products')->with('message', 'Barang berhasil ditambahkan');
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
        $data = [
            'title' => 'Edit Barang',
            'product' => $this->productModel->find($id),
            'categories' => $this->categoryModel->findAll(),
        ];

        if (empty($data['product'])) {
            throw new PageNotFoundException('Barang dengan ID ' . $id . ' tidak ditemukan.');
        }

        return view('products/edit', $data);
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
        $rules = [
            'category_id' => 'required',
            'name' => 'required|min_length[3]',
            'code' => "required|is_unique[products.code,id,{$id}]",
            'unit' => 'required',
            'stock' => 'required|numeric',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->productModel->update($id, [
            'category_id' => $this->request->getPost('category_id'),
            'name' => $this->request->getPost('name'),
            'code' => $this->request->getPost('code'),
            'unit' => $this->request->getPost('unit'),
            'stock' => $this->request->getPost('stock'),
        ]);

        return redirect()->to('/products')->with('message', 'Barang berhasil diperbarui.');
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
        $this->productModel->delete($id);
        return redirect()->to('/products')->with('message', 'Barang berhasil dihapus.');
    }
}
