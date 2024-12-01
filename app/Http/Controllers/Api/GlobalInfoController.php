<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GlobalInfoService;


class GlobalInfoController extends Controller
{
    private GlobalInfoService $globalInfoService;

    public function __construct(GlobalInfoService $globalInfoService)
    {
        $this->globalInfoService = $globalInfoService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $languageId = $this->getLanguageId();

        $result = $this->globalInfoService->getGlobalInfo($languageId);

        return response()->json($result);
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
    public function show(string $id)
    {
        //
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
