<?php

namespace App\Exceptions;

use App\Traits\ServiceResponser;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ServiceResponser;
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
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
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
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpException) {
            $code = $exception->getStatusCode();
            $message = $exception->getMessage() ?? Response::$statusTexts[$code];
            return $this->errorResponse($message, $code);
        }
        if ($exception instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($exception->getModel()));
            return $this->errorResponse("Does not exist any instance of {$model} with the given id", Response::HTTP_NOT_FOUND, $this->loggerInterface);
        }

        if ($exception instanceof ValidationException) {
            $errors = collect($exception->validator->errors()->getMessages())->flatten();
            return $this->errorResponse($errors, Response::HTTP_BAD_REQUEST);
        }
        if ($exception instanceof QueryException) {
            $message = $exception->getMessage();
            return $this->errorResponse($message, 500);
        }
     
        if (env('APP_DEBUG', false)) {

            return parent::render($request, $exception);
        }

        return $this->errorResponse('Unexpected error. Try later', Response::HTTP_INTERNAL_SERVER_ERROR, $this->loggerInterface);
    }

}