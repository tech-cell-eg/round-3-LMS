<?php

use Illuminate\Http\Request;
use App\Http\Middleware\IsInstructor;
use Illuminate\Foundation\Application;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__ . '/../routes/api.php',
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'instructor' => IsInstructor::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*') || $request->is('admin/*')) {
                return response()->json([
                    'success' => (bool) false,
                    'message' => 'Page 404 Not Found',
                    'data'    => $e->getMessage(),
                ], 404);
            }
        });

        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if ($request->is('api/*') || $request->is('admin/*')) {
                return response()->json([
                    'success' => (bool) false,
                    'message' => 'Model 404 Not Found',
                    'data'    => $e->getMessage(),
                ], 404);
            }
        });

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->is('api/*') || $request->is('admin/*')) {
                return response()->json([
                    'success' => (bool) false,
                    'message' => 'Method Not Allowed',
                    'data'    => $e->getMessage(),
                ], 405);
            }
        });

        $exceptions->render(function (ValidationException $e, Request $request) {
            if ($request->is('api/*') || $request->is('admin/*')) {
                return response()->json([
                    'success' => (bool) false,
                    'message' => 'Validation Error',
                    'data'    => $e->errors(),
                ], 422);
            }
        });

        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->is('api/*') || $request->is('admin/*')) {
                return response()->json([
                    'success' => (bool) false,
                    'message' => 'Unauthorized Access',
                    'data'    => $e->getMessage(),
                ], 401);
            }
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*') || $request->is('admin/*')) {
                return response()->json([
                    'success' => (bool) false,
                    'message' => 'Internal Server Error',
                    'data'    => $e->getMessage(),
                ], 500);
            }
        });
    })->create();
