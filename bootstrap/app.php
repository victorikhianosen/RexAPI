<?php

use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\BusinessMiddleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\Mailer\Exception\TransportException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['admin'])
                ->prefix('admin')
                ->group(base_path('routes/admin.php'));

            Route::prefix('business')
                ->group(base_path('routes/business.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'business' => BusinessMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Route Error
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            return (new class {
                use HttpResponses;
            })->error(
                'Route Not Found.',
                [],
                404,
                '04'
            );
        });
        // ✅ Add ValidationException handler
        $exceptions->render(function (ValidationException $e, $request) {
            $errors = $e->errors();

            // Extract the first message + count for the concise message
            $allMessages = collect($errors)->flatten();
            $message = $allMessages->first();
            $errorCount = $allMessages->count();

            if ($errorCount > 1) {
                $message .= " (and " . ($errorCount - 1) . " more error" . (($errorCount - 1) > 1 ? "s" : "") . ")";
            }

            return (new class {
                use HttpResponses;
            })->error(
                $message,
                $errors,
                422,
                '05'
            );
        });
        // UnAuthorize Arror
        $exceptions->render(function (AccessDeniedHttpException $e, $request) {
            return (new class {
                use HttpResponses;
            })->error(
                $e->getMessage() ?: 'This action is unauthorized.',
                [],
                403,
                '06'
            );
        });
        // UnAuthenticate Error
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            return (new class {
                use HttpResponses;
            })->error(
                'Unauthenticated.',
                [],
                401,
                '02'
            );
        });
        // Email Error
        $exceptions->render(function (TransportException $e, $request) {
            return (new class {
                use HttpResponses;
            })->error(
                'Unable to send mail, Connection timed out',
                // 'Unable to send mail: ' . $e->getMessage(),
                [],
                500,
                '05'
            );
        });
    })->create();
