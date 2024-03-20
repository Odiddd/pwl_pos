<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Use HasMany for one-to-many relationship

class LevelModel extends Model
{
    use HasFactory;

    protected $table = 'm_level'; // Adjust table name if different
    protected $primaryKey = 'level_id'; // Adjust primary key if different

    protected $fillable = ['nama_level', 'deskripsi']; // Define fillable columns

    // Define relationship with UserModel (one level has many users)
    public function users()
    {
        return $this->hasMany(UserModel::class, 'level_id', 'level_id');
    }
}
