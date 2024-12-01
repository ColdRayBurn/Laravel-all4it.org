<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GlobalInfo extends Model
{
    protected $table = 'globals';

    use HasFactory;

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    protected $casts = [
        'contacts' => 'array',
    ];

    protected $fillable = [
        'isActive',
        'sort',
        'language_id',
        'page_title',
        'page_description',
        'logotype',
        'contacts',
        'footer_title',
    ];
}
