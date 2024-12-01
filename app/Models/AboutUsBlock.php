<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsBlock extends Model
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
        'subtitle',
        'title',
        'description',
        'updated_at',
        'created_at',
    ];
}
