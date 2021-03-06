<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

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
     * A list of the inputs that are never flashed for validation exceptions.
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

        $this->renderable(function (NotFoundHttpException $e, $request) {
            
            if ($e instanceof NotFoundHttpException && $request->wantsJson()) {
                return response()->json([                    
                    'msg'   => 'Record not found.',
                    'status'   => false,
                    'data'  => (object) []
                ], 200);
            }
                        
        });

        $this->renderable(function (AccessDeniedHttpException $e, $request) {

            if ($e instanceof AccessDeniedHttpException && $request->wantsJson()) {
                return response()->json([                    
                    'msg'   => 'Unauthorized',
                    'status'   => false,
                    'data'  => (object) []
                ], 401);
            }

        });

        $this->renderable(function (UnauthorizedHttpException $e, $request) {

            if ($e instanceof UnauthorizedHttpException && $request->wantsJson()) {
                return response()->json([                           
                    'msg'   => 'Invalid token or token not found.',
                    'status'   => false,
                    'data'  => (object) []
                ], 401);
            }

        });

        $this->renderable(function (TokenInvalidException $e, $request) {
            if ($e instanceof TokenInvalidException && $request->wantsJson()) {                
                return response()->json([                              
                    'msg'   => 'Invalid token or token not found.',
                    'status'   => false,
                    'data'  => (object) []
                ], 401);
            }
        });

        $this->renderable(function (TokenBlacklistedException $e, $request) {
            if ($e instanceof TokenBlacklistedException && $request->wantsJson()) {                
                return response()->json([                                 
                    'msg'   => 'Token expired',
                    'status'   => false,
                    'data'  => (object) []
                ], 401);
            }
        });        
        
        $this->renderable(function (TokenExpiredException $e, $request) {
            if ($e instanceof TokenExpiredException && $request->wantsJson()) {                
                return response()->json([                                 
                    'msg'   => 'Token expired',
                    'status'   => false,
                    'data'  => (object) []
                ], 401);
            }
        });
        
        
    }
}
