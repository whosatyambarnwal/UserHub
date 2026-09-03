<?php

use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUser;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectUsersTo(function () {
            if (Auth::check()) {
                return Auth::user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard');
            }

            return route('login');
        });

        $middleware->redirectGuestsTo(fn () => route('login'));

        $middleware->alias([
            'isAdmin' => IsAdmin::class,
            'isUser' => IsUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json(['message' => 'Method not allowed.'], 405);
            }

            if (Auth::check()) {
                $target = Auth::user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard');

                return redirect($target)->with('info', 'The requested action cannot be accessed via GET.');
            }

            return redirect()->route('login');
        });
    })->create();
