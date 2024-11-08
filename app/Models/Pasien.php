<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Pasien extends Model
{
    use SearchableTrait;
    use HasFactory;

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

    public function daftar(): HasMany
    {
        return $this->hasMany(Daftar::class);
    }
}
