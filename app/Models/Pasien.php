<?php

namespace App\Models;

use App\Casts\Encrypted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pasien extends Model
{
    use SearchableTrait;
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $searchable = [
        'columns' => [
            'pasiens.nama' => 10,
            'pasiens.no_pasien' => 10,
        ],
        'joins' => [
            'daftars' => ['pasiens.id', 'daftars.pasien_id'],
        ],
    ];
    
    protected $dates = ['deleted_at'];

    /**
     * TAMBAHKAN INI: Enkripsi otomatis untuk alamat dan umur
     */
    protected function casts(): array
    {
        return [
            'alamat' => Encrypted::class,
            'umur' => Encrypted::class,
        ];
    }

    public function daftar(): HasMany
    {
        return $this->hasMany(Daftar::class);
    }
}