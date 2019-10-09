<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->expectsJson()) {
            if ($exception instanceof AuthorizationException) {
                return response()->json([
                    'data' => [
                        'message' => $exception->getMessage(),
                    ],
                ], 403);
            }

            if ($exception instanceof ModelNotFoundException) {
                /*$modelName = last(explode('\\', $exception->getModel()));
                return response()->json([
                    'data' => [
                        'message' => $modelName.' with id '.implode(', ', $exception->getIds()).' not found.',
                    ],
                ], 404);*/
                return response(null, 404);
            }

            if ($exception instanceof NotFoundHttpException) {
                return response(null, 404);
            }
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'data' => [
                    'message' => $exception->getMessage(),
                ]
            ], 401);
        }

        return redirect()->guest($exception->redirectTo() ?? route('login'));
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json([
            'data' => [
                'message' => $exception->getMessage(),
                'errors' => $exception->errors(),
            ],
        ], $exception->status);
    }
}
