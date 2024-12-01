<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function getLanguageId(): int
    {
        $defaultCode = 'ru';
        $languageCode = substr(\Illuminate\Support\Facades\Request::header('Accept-Language', $defaultCode), 0, 2);

        $language = Language::where('code', $languageCode)->first();
        return $language ? $language->id : Language::where('code', $defaultCode)->first()->id;
    }
}
