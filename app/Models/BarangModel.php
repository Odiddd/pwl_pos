<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class BarangModel extends Authenticatable implements JWTSubject
{
    use HasFactory;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return[];
    }

    protected $table = 'm_barang'; // Assuming your barang table name is 'm_barang'
    protected $primaryKey = 'barang_id';

    protected $fillable = [
        'kategori_id', // Assuming a foreign key referencing KategoriModel
        'barang_kode',
        'barang_nama',
        'harga_beli',
        'harga_jual',
        'image',
        // Add other relevant fields for your barang data
    ];

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => url('/storage/posts/' . $image),
        );
    }

    public function kategori() // Relationship method with singular form for clarity
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }

    public function level() // Relationship method with singular form for clarity
    {
        return $this->belongsTo(LevelModel::class, 'level_id', 'level_id');
    }
}
