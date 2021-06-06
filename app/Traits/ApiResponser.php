<?php

namespace App\Traits;

use Error;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\ValidationException;

trait ApiResponser
{

    // protected function resonseWithJsonResource(
    //     bool $error,
    //     JsonResource $jsonResource,
    //     int $statusCode,
    //     string $message
    // )
    // {
    //     return response()->json([
    //         "error" => $error,
    //         "message" => $message,
    //         "data" => $jsonResource,
    //         "status_code" => $statusCode,
    //     ]);
    // }

    // protected function successResponse(bool $error = false, $data = [], int $statusCode = null, string $message)
    // {
    //     return response()->json([
    //         "error" => $error,
    //         "message" => $message,
    //         "status_code" => $statusCode,
    //         "data" => $data
    //     ]);
    // }

    // public static function failResponse(int $errorCode , string $message, int $statusCode = 500)
    // {
    //     return response()->json([
    //         "error" => true,
    //         "error_code" => $errorCode,
    //         "message" => $message
    //     ], $statusCode);
    // }

    protected function respondWithResource(
        JsonResource $resource,
        $message = null,
        $statusCode = 200,
        $headers = []
    )
    {
        return $this->apiResponse(
            [
                'success' => true,
                'result' => $resource,
                'message' => $message
            ], $statusCode, $headers
        );
    }

    public function parseGivenData(
        $data = [],
        $statusCode = 200,
        $headers = []
    )
    {
        //dd([$data,  $statusCode]);
        $responseStructure = [
            'success' => $data['success'],
            'message' => $data['message'] ?? null,
            'result' => $data['result'] ?? null,
        ];
        if (isset($data['errors'])) {
            $responseStructure['errors'] = $data['errors'];
        }
        if (isset($data['status'])) {
            $statusCode = $data['status'];
        }


        if (isset($data['exception']) && ($data['exception'] instanceof Error || $data['exception'] instanceof Exception)) {
            if (config('app.env') !== 'production') {
                $responseStructure['exception'] = [
                    'message' => $data['exception']->getMessage(),
                    'file' => $data['exception']->getFile(),
                    'line' => $data['exception']->getLine(),
                    'code' => $data['exception']->getCode(),
                    'trace' => $data['exception']->getTrace(),
                ];
            }

            if ($statusCode === 200) {
                $statusCode = 500;
            }
        }
        if ($data['success'] === false) {
            if (isset($data['error_code'])) {
                $responseStructure['error_code'] = $data['error_code'];
            } else {
                $responseStructure['error_code'] = 1;
            }
        }
        return ["content" => $responseStructure, "statusCode" => $statusCode, "headers" => $headers];
    }


    protected function apiResponse(
        $data = [],
        $statusCode = 200,
        $headers = []
    )
    {
        $result = $this->parseGivenData($data, $statusCode, $headers);

        return response()->json(
            $result['content'], $result['statusCode'], $result['headers']
        );
    }


    protected function respondWithResourceCollection(
        ResourceCollection $resourceCollection,
        $message = null,
        $statusCode = 200,
        $headers = []
    )
    {
        return $this->apiResponse(
            [
                'success' => true,
                'result' => $resourceCollection->response()->getData()
            ], $statusCode, $headers
        );
    }


    protected function respondSuccess($message = '')
    {
        return $this->apiResponse(['success' => true, 'message' => $message]);
    }

    protected function respondCreated($data)
    {
        return $this->apiResponse($data, 201);
    }

    protected function respondResourceAlreadyExistsError($message = 'Resource already exists')
    {
        return $this->respondError($message, 409);
    }

    protected function respondNoContent($message = 'No Content Found')
    {
        return $this->apiResponse(['success' => false, 'message' => $message], 200);
    }


    // protected function respondNoContentResource($message = 'No Content Found')
    // {
    //     return $this->respondWithResource(new EmptyResource([]), $message);
    // }


    // protected function respondNoContentResourceCollection($message = 'No Content Found')
    // {
    //     return $this->respondWithResourceCollection(new EmptyResourceCollection([]), $message);
    // }

    protected function respondUnAuthorized($message = 'Unauthorized')
    {
        return $this->respondError($message, 401);
    }


    protected function respondError(
        $message,
        int $statusCode = 400,
        Exception $exception = null,
        int $error_code = 1
    )
    {
        return $this->apiResponse(
            [
                'success' => false,
                'message' => $message ?? 'There was an internal error, Pls try again later',
                'exception' => $exception,
                'error_code' => $error_code
            ], $statusCode
        );
    }


    protected function respondForbidden($message = 'Forbidden')
    {
        return $this->respondError($message, 403);
    }


    protected function respondNotFound($message = 'Not Found')
    {
        return $this->respondError($message, 404);
    }

    // /**
    //  * Respond with failed login.
    //  *
    //  * @return \Illuminate\Http\JsonResponse
    //  */
    // protected function respondFailedLogin()
    // {
    //     return $this->apiResponse([
    //         'errors' => [
    //             'email or password' => 'is invalid',
    //         ]
    //     ], 422);
    // }


    protected function respondInternalError($message = 'Internal Error')
    {
        return $this->respondError($message, 500);
    }

    protected function respondValidationErrors(ValidationException $exception)
    {
        return $this->apiResponse(
            [
                'success' => false,
                'message' => $exception->getMessage(),
                'errors' => $exception->errors()
            ],
            422
        );
    }

    protected function respondWithAccessToken($token = null, $message = "")
    {
        return $this->apiResponse(array(
            "success" => true,
            "message" => $message,
            "result" => [
                "access_token" => $token
            ]
        ), 200);
    }

}
