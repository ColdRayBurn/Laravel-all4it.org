<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioItem extends Model
{
    use HasFactory;

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    protected $casts = [
        'gallery' => 'array',
    ];

    protected $fillable = [
        'isActive',
        'sort',
        'language_id',
        'title',
        'logotype',
        'shortDescription',
        'secondShortDescription',
        'description',
        'url',
        'developmentDate',
        'gallery',
    ];
}
