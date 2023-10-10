<?php

namespace App\Http\Controllers\API;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Repositories\Admin\FaqRepository;
use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{

    const DEFAULT_PAGINATION = 15;

    const HTTP_OK = 200;

    const HTTP_CREATED = 201;

    const HTTP_NO_CONTENT = 204;

    const HTTP_BAD_REQUEST = 400;

    const HTTP_UNAUTHORIZED = 401;

    const HTTP_FORBIDDEN = 403;

    const HTTP_NOT_FOUND = 404;

    const HTTP_UNPROCESSABLE = 422;

    const HTTP_METHOD_NOT_ALLOW = 405;

    const HTTP_SERVER_ERROR = 500;

    public function __construct(private FaqRepository $faqRepository) {
        //
    }

    public function sendSuccessResponse($message, $data = []): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ], self::HTTP_OK);
    }

    public function sendFailedResponse($message, $code = 404, $errorData = []): JsonResponse
    {
    	$response = [
            'success' => false,
            'message' => $message,
        ];

        if(! empty($errorData)){
            $response['data'] = $errorData;
        }

        return response()->json($response, $code);
    }

    public function getFaq()
    {
        $faqData = $this->faqRepository->getRaw([
            'status' => 'Active'
        ])
        ->select('question', 'answer')
        ->orderBy('id', 'DESC')
        ->paginate(self::DEFAULT_PAGINATION);

        return $this->sendSuccessResponse('Faq data fetched successfully!', $faqData);
    }
}
