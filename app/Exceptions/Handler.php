<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
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


    public function render($request, Throwable $exception)
    {
        // if ($request->expectsJson()) {
        //     if ($exception instanceof ModelNotFoundException)
        //         return new JsonResponse([
        //             'message' => "Unable to locate the {$this->prettyModelNotFound($exception)} you requested."
        //         ], 404);
        // }

        if ($exception instanceof ModelNotFoundException)
            throw new NotFoundHttpException("Unable to locate the {$this->prettyModelNotFound($exception)} you requested.");

        return parent::render($request, $exception);
    }


    private function prettyModelNotFound(Throwable $exception)
    {
        try {
            return Str::lower(
                ltrim(
                    preg_replace(
                        '/[A-Z]/',
                        '$0',
                        (new ReflectionClass($exception->getModel()))->getShortName()
                    )
                )
            );
        } catch (ReflectionException $e) {
            report($e);
        }
        return 'resource';
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
