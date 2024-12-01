<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privacy extends Model
{
    use HasFactory;

    protected $table = 'privacy';

    public function language()
    {
        return $this->belongsTo(Language::class);
    }


    protected $fillable = [
        'isActive',
        'sort',
        'language_id',
        'content',
    ];
}
