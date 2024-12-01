<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advantage extends Model
{
    use HasFactory;

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    protected $casts = [
        'descriptions' => 'array',
        'carousels' => 'array',
        'carousel' => 'array',
    ];

	protected $fillable = [
        'isActive',
        'sort',
        'language_id',
        'title',
        'descriptions',
        'carousels',
    ];
}
