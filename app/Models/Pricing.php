<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    protected $casts = [
        'isHighlighted' => 'boolean',
    ];

	protected $fillable = [
        'isActive',
        'sort',
        'language_id',
        'title',
		'priceFrom',
		'time',
        'shortDescription',
		'description',
        'isHighlighted',
    ];
}
