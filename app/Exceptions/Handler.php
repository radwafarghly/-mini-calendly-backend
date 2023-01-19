<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {


        if ($exception instanceof ModelNotFoundException) {
            return response()->json(
                [
                    'data' => [],
                    'message' => 'Not Found',
                    'success' => false
                ],
                404
            );
        }
        if ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(
                [
                    'data' => [],
                    'message' => 'Method Not Allowed',
                    'success' => false,
                    'authorized' => false
                ],
                404
            );
        }
        if ($exception instanceof AuthorizationException) {
            return response()->json(
                [
                    'data' => [],
                    'message' => 'This action is unauthorized',
                    'success' => false,
                    'authorized' => false
                ],
                401
            );
        }
        if ($exception instanceof AuthenticationException) {
            return response()->json(
                [
                    'data' => [],
                    'message' => 'Unauthenticated',
                    'success' => false,
                    'authorized' => false
                ],
                401
            );
        }
        return parent::render($request, $exception);
    }
}
