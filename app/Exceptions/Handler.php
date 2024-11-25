<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse
    {
        if ($e instanceof AuthorizationException || $e instanceof AuthenticationException) {
            return response()->json([
                'error' => [
                    'message' => 'Not authorized. Please login to proceed.',
                ]
            ], 401);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'error' => [
                    'message' => 'Order not found.',
                ]
            ], 404);
        }

        return parent::render($request, $e);
    }
}
