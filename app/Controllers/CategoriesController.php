<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;

class CategoriesController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Kategori',
            'categories' => $this->categoryModel->paginate(5),
            'pager' => $this->categoryModel->pager,
        ];

        return view('categories/index', $data);
    }

    public function new()
    {
        return view('categories/new');
    }

    public function create()
    {
        $rules = [
            'name' => 'required|min_length[3]|is_unique[categories.name]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->save([
            'name' => $this->request->getPost('name'),
        ]);

        return redirect()->to('/categories')->with('message', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id = null)
    {
        $data = [
            'category' => $this->categoryModel->find($id)
        ];

        if (empty($data['category'])) {
            throw new PageNotFoundException('Kategori tidak ditemukan.');
        }

        return view('categories/edit', $data);
    }

    public function update($id = null)
    {
        $rules = [
            'name' => "required|min_length[3]|is_unique[categories.name,id,{$id}]"
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->update($id, [
            'name' => $this->request->getPost('name')
        ]);

        return redirect()->to('/categories')->with('message', 'Kategori berhasil diubah.');
    }

    public function delete($id = null)
    {
        $this->categoryModel->delete($id);
        return redirect()->to('/categories')->with('message', 'Kategori berhasil dihapus.');
    }
}
