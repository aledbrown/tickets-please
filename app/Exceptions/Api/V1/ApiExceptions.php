<?php

namespace App\Exceptions\Api\V1;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiExceptions
{
    public static array $handlers = [
        AuthenticationException::class => 'handleAuthenticationException',
        ValidationException::class => 'handleValidationException',
        ModelNotFoundException::class => 'handleNotFoundException',
        NotFoundHttpException::class => 'handleNotFoundException',
        AuthorizationException::class => 'handleAuthorizationException',
        AccessDeniedHttpException::class => 'handleAuthorizationException',
        // OTHERS WE COULD ADD
        // MethodNotAllowedHttpException::class => 'handleMethodNotAllowedHttpException',
        // HttpException::class => 'handleHttpException',
        // QueryException::class => 'handleQueryException'
    ];

    public static function showError(Array $error): JsonResponse
    {
        return response()->json([
            'error' => [
                'type' => $error['type'],
                'status' => $error['status'],
                'message' => $error['message']
            ]
        ]);
    }

    public static function getExceptionClass($exception) : string
    {
        $className = get_class($exception);
        $index = strrpos($className, '\\');
        return substr($className, $index + 1);
    }

    public static function handleAuthorizationException(AuthorizationException|AccessDeniedHttpException $e, Request $request): JsonResponse
    {
        // log sensitive stuff
        $source = 'Line: ' . $e->getLine() . ', File: ' . $e->getFile();
        Log::notice(basename(get_class($e)) . ' - ' . $e->getMessage() . ' - ' . $source);

        $error = [
            'type' => self::getExceptionClass($e),
            'status' => 401,
            'message' => $e->getMessage()
        ];
        return self::showError($error);
    }

    public static function handleAuthenticationException(AuthenticationException $e, Request $request): JsonResponse
    {
        // log sensitive stuff
        $source = 'Line: ' . $e->getLine() . ', File: ' . $e->getFile();
        Log::notice(basename(get_class($e)) . ' - ' . $e->getMessage() . ' - ' . $source);

        $error = [
            'type' => self::getExceptionClass($e),
            'status' => 401,
            'message' => $e->getMessage()
        ];
        return self::showError($error);
    }

    public static function handleValidationException(ValidationException $e, Request $request): JsonResponse
    {
        foreach ($e->errors() as $key => $value)
            foreach ($value as $message) {
                $errors[] = [
                    'type' => self::getExceptionClass($e),
                    'status' => 422,
                    'message' => $message,
                ];
            }

        return response()->json([
            'errors' => $errors
        ]);
    }

    public static function handleNotFoundException(ModelNotFoundException|NotFoundHttpException $e, Request $request): JsonResponse
    {
        $error = [
            'type' => self::getExceptionClass($e),
            'status' => 404,
            'message' => 'Not Found ' . $request->getRequestUri()
        ];
        return self::showError($error);
    }
}
