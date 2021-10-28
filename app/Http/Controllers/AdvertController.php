<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdvertRequest;
use App\Services\AdvertService;
use Exception;
use Illuminate\Http\JsonResponse;

class AdvertController extends Controller
{
    /**
     * AdvertController constructor.
     * @param AdvertService $advertService
     */
    public function __construct(private AdvertService $advertService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @param int $userId
     * @return JsonResponse
     * @throws Exception
     */
    public function index(int $userId): JsonResponse
    {
        return $this->sendSuccess($this->advertService->getAllAdvert($userId));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param AdvertRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function createOrUpdate(AdvertRequest $request): JsonResponse
    {
        return $this->sendSuccess(
            $this->advertService->upsert(
                name: $request->input('name'),
                from: $request->input('from'),
                to: $request->input('to'),
                totalBudget: $request->input('total_budget'),
                dailyBudget: $request->input('daily_budget'),
                userId: $request->input('user_id'),
                files: $request->hasFile('banners') ? $request->file('banners') : [],
                id: $request->input('id'),
            )
        );
    }
}
