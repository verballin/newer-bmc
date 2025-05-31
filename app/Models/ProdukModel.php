<?php 

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'produk';
    protected $primaryKey           = 'id_produk';
    protected $useAutoIncrement     = true;
    protected $insertID     = 0;
    protected $returnType     = 'array';
    protected $useSoftDeletes     = false;
    protected $protectFields     = true;
    protected $allowedFields     = ['title', 'benefit', 'about', 'harga', 'durasi', 'gambar'];


    public function getCourseById($id)
    {
        return $this->where('id_produk', $id)->first();
    }

        
}
?>