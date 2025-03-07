<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;

class DashboardController extends BaseController
{
    protected $productModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        // Hitung jumlah produk berdasarkan kategori
        $kategoriIos = $this->productModel
            ->where('category_id', $this->getCategoryIdByName('iOS'))
            ->countAllResults();

        $kategoriAndroid = $this->productModel
            ->where('category_id', $this->getCategoryIdByName('Android'))
            ->countAllResults();

        // Data yang akan dikirim ke view
        $data = [
            'kategoriIos' => $kategoriIos,
            'kategoriAndroid' => $kategoriAndroid,
            'totalProduk' => $this->productModel->countAllResults(),
        ];

        return view('dashboard', $data);
    }

    private function getCategoryIdByName($categoryName)
    {
        $category = $this->categoryModel->where('name_categories', $categoryName)->first();
        return $category ? $category['id'] : null;
    }
}
