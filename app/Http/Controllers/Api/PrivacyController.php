<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PrivacyService;

class PrivacyController extends Controller
{
    private PrivacyService $privacyService;

    public function __construct(PrivacyService $privacyService)
    {
        $this->privacyService = $privacyService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $languageId = $this->getLanguageId();

        $item = $this->privacyService->getPrivacyPolicy($languageId);

        if (!$item) {
            return response()->json(['message' => 'privacy not found'], 404);
        }

        return response()->json($item->content);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
