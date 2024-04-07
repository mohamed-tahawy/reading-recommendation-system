<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Book;
use App\Services\SMSService;
use Illuminate\Http\Request;
use App\Traits\ResponseHandel;
use App\Models\ReadingInterval;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ReadingIntervalRequest;
use App\Repositories\ReadingIntervalRepository;

class ReadingIntervalController extends Controller
{
    use ResponseHandel;
    protected $smsService;
    protected $readingIntervalRepository;

    public function __construct(SMSService $smsService, ReadingIntervalRepository $readingIntervalRepository)
    {
        $this->smsService = $smsService;
        $this->readingIntervalRepository = $readingIntervalRepository;
    }
    /**
     * documented function
     *
     * @param ReadingIntervalRequest $request
     * @param SMSService $smsService
     * @return JsonResponse
     */
    public function store(ReadingIntervalRequest $request, SMSService $smsService)
    {
        try {
            $readingIntervalData = $request->validated();
            $this->readingIntervalRepository->create($readingIntervalData);
            //task implemented without authentication system need to switch for auth user mobile if we implemented.
            $userPhoneNumber = '01146075904';
            $smsService->sendThankYouSMS($userPhoneNumber);
            return $this->successResponse(null, 'Success', 201);
        } catch (Throwable $e) {
            return $this->errorResponse(null, $e->getMessage(), 500);
        }
    }
    public function mostRecommended()
    {
        try {
            $mostRecommandedBooks = $this->readingIntervalRepository->getMostRecommendeBooksByReadPage();
            return $this->successResponse($mostRecommandedBooks, 'Success', 200);
        } catch (Throwable $e) {
            return $this->errorResponse(null, $e->getMessage(), 500);
        }
    }
}
