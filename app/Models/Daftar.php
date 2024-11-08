<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nicolaslopezj\Searchable\SearchableTrait;


class Daftar extends Model
{
    use SearchableTrait;
    /** @use HasFactory<\Database\Factories\DaftarFactory> */
    use HasFactory;
    protected $guarded = [];

    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */
        'columns' => [
            'pasiens.nama' => 10,
            'pasiens.no_pasien' => 10,
            //'polis.nama' => 2,
        ],
        'joins' => [
            'pasiens' => ['pasiens.id', 'daftars.pasien_id'],
            //'polis' => ['polis.id','daftar.poli_id'],
        ],
    ];

    public function pasien(): BelongsTo {
        return $this->belongsTo(Pasien::class, 'pasien_id');

    }

    public function poli(): BelongsTo {
        return $this->belongsTo(Poli::class)->withDefault();
    }
}
