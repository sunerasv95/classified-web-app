<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use App\Enums\ErrorCodes;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if(get_class($exception) == "Illuminate\Database\Eloquent\ModelNotFoundException"){
             return $this->respondNotFound("Resource not found!", ErrorCodes::NOT_FOUND);
        }
        if(get_class($exception) == "Illuminate\Validation\ValidationException"){
            return $this->respondValidationErrors($exception);
        }
        if(get_class($exception) == "Illuminate\Auth\AuthenticationException"){
            return $this->respondUnAuthorized('Unauthorized', ErrorCodes::INVALID_TOKEN);
        }
        return parent::render($request, $exception);
    }
}
