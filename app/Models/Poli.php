<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nicolaslopezj\Searchable\SearchableTrait;

class Poli extends Model
{
    use SearchableTrait, HasFactory;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Searchable configuration
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'pasiens.nama' => 10,
            'pasiens.no_pasien' => 10,
        ],
        'joins' => [
            'daftars' => ['polis.id', 'daftars.poli_id'],
            'pasiens' => ['pasiens.id', 'daftars.pasien_id'],
        ],
    ];

    /**
     * Relationship to Daftar
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function daftar(): HasMany
    {
        return $this->hasMany(Daftar::class);
    }
}
