<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\HomepageService;


class HomepageController extends Controller
{
    private HomepageService $homepageService;

    public function __construct(HomepageService $homepageService)
    {
        $this->homepageService = $homepageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languageId = $this->getLanguageId();

        $homepageInfo = $this->homepageService->getHomepage($languageId);

        return response()->json($homepageInfo);
    }


}
