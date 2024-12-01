<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    protected $fillable = [
        'isActive',
        'sort',
        'language_id',
        'title',
        'time',
        'priceFrom',
        'image',
        'shortDescription',
        'description',
    ];
}
