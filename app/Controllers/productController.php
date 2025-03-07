<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class ProductController extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }


    public function search()
    {
        $query = $this->request->getGet('query');
    
    // Ambil data produk sesuai query pencarian
    $products = $this->productModel->search($query);

    // Ambil daftar kategori dari model
    $categories = $this->categoryModel->findAll();

    // Kirim data ke view
    return view('search_results', [
        'products' => $products,
        'categories' => $categories,
        'query' => $query,
    ]);
    }

    public function index()
{
    $data['products'] = $this->productModel
        ->select('products.*, categories.name_categories')
        ->join('categories', 'categories.id = products.category_id', 'left')
        ->findAll();

    // Tambahkan data kategori
    $data['categories'] = $this->categoryModel->findAll();

    return view('index', $data); // Pastikan path view sesuai
}


    public function create()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('products/create', $data);
    }

    public function store()
{
    $fileThumbnail = $this->request->getFile('thumbnail');

    // Periksa apakah file diupload
    if ($fileThumbnail && $fileThumbnail->isValid() && !$fileThumbnail->hasMoved()) {
        // Simpan file ke folder 'uploads'
        $newName = $fileThumbnail->getRandomName();
        $fileThumbnail->move(ROOTPATH . 'public/uploads', $newName);

        // Simpan nama file ke database
        $thumbnail = $newName;
    } else {
        $thumbnail = null; // Atau beri default value
    }

    $this->productModel->save([
        'thumbnail'   => $thumbnail,
        'product'     => $this->request->getPost('product'),
        'price'       => $this->request->getPost('price'),
        'category_id' => $this->request->getPost('category_id'),
    ]);

    session()->setFlashdata('message', 'Produk baru berhasil ditambahkan!');
    session()->setFlashdata('operationType', 'add');
    return redirect()->to(base_url('/index'));
    }

    public function update($id)
{
    $fileThumbnail = $this->request->getFile('thumbnail');

    // Ambil data produk lama
    $product = $this->productModel->find($id);

    if ($fileThumbnail && $fileThumbnail->isValid() && !$fileThumbnail->hasMoved()) {
        // Simpan file baru
        $newName = $fileThumbnail->getRandomName();
        $fileThumbnail->move('uploads', $newName);

        // Hapus file lama jika ada
        if ($product['thumbnail'] && file_exists($product['thumbnail'])) {
            unlink($product['thumbnail']);
        }

        $thumbnail = 'uploads/' . $newName;
    } else {
        // Jika tidak ada file baru, gunakan file lama
        $thumbnail = $product['thumbnail'];
    }

    // Update data produk
    $this->productModel->update($id, [
        'thumbnail'   => $thumbnail,
        'product'     => $this->request->getPost('product'),
        'price'       => $this->request->getPost('price'),
        'category_id' => $this->request->getPost('category_id'),
    ]);

    session()->setFlashdata('message', 'Produk berhasil diperbarui!');
    session()->setFlashdata('operationType', 'edit');
    return redirect()->to(base_url('index'));
    }

    public function delete($id)
{
    // Ambil data produk berdasarkan ID
    $product = $this->productModel->find($id);

    // Hapus file thumbnail jika ada
    if ($product['thumbnail'] && file_exists($product['thumbnail'])) {
        unlink($product['thumbnail']);
    }

    // Hapus data produk dari database
    $this->productModel->delete($id);

    session()->setFlashdata('message', 'Produk berhasil dihapus!');
    session()->setFlashdata('operationType', 'delete');
    return redirect()->to(base_url('index'));
}



}
