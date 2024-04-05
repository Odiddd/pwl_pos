<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;

    protected $table = 'm_barang'; // Assuming your barang table name is 'm_barang'
    protected $primaryKey = 'barang_id';

    protected $fillable = [
        'kategori_id', // Assuming a foreign key referencing KategoriModel
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual',
        // Add other relevant fields for your barang data
    ];

    public function kategori() // Relationship method with singular form for clarity
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }
}
