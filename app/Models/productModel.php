<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['thumbnail', 'product', 'price', 'category_id'];

    public function search($query)
    {
        // Gunakan metode query builder untuk mencari data
        return $this->like('product', $query)
                    ->orLike('category_id', $query)
                    ->findAll();
    }
}


