<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageInfo extends Model
{
    protected $table = 'homepage_info';

    use HasFactory;

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    protected $casts = [
        'images' => 'array',
    ];

    protected $fillable = [
        'isActive',
        'sort',
        'language_id',
        'title',
        'description',
        'images',
        'advantages_title',
        'advantages_description',
        'aboutus_title',
        'aboutus_description',
        'pricelist_title',
        'pricelist_description',
        'customers_title',
        'customers_description',
    ];
}
