<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
        // $this->reportable(function (Throwable $e) {
        //     //
        // });
        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                "code" => 404,
                "status" => "fail",
                "message" => "Requested URL is not found. Try below URLs",
                "data" => [
                    "auth" => [
                        "login" => [
                            "method" => "post",
                            "auth" => "no",
                            "url" => "/api/auth/login",
                            "payload" => [
                                "email" => "string",
                                "password" => "string"
                            ]
                        ],
                        "logout" => [
                            "method" => "post",
                            "auth" => "yes",
                            "authType" => "bearer-token",
                            "url" => "/api/auth/logout"
                        ]
                    ],
                    "messages" => [
                        "sendMessage" => [
                            "method" => "post",
                            "url" => "/api/messages",
                            "auth" => "yes",
                            "authType" => "bearer-token",
                            "payload" => [
                                "message" => "string",
                                "receiverId" => "int"
                            ]
                        ],
                        "getAllMessagees" => [
                            "method" => "get",
                            "url" => "/api/messages",
                            "auth" => "yes",
                            "authType" => "bearer-token",
                        ]
                    ],
                    "reports" => [
                        "createReport" => [
                            "method" => "post",
                            "url" => "/api/reports",
                            "auth" => "yes",
                            "authType" => "bearer-token",
                            "payload" => [
                                "type" => "enum:feedback|bug",
                                "description" => "string"
                            ]
                        ],
                        "getAllReports" => [
                            "method" => "get",
                            "url" => "/api/reports",
                            "auth" => "yes",
                            "authType" => "bearer-token",
                        ]
                    ],
                    "customers" => [
                        "getAllCustomers" => [
                            "method" => "get",
                            "url" => "/api/customers",
                            "auth" => "yes",
                            "authType" => "bearer-token",
                        ],
                        "deleteCustomer" => [
                            "method" => "delete",
                            "url" => "/api/customers/{userId}",
                            "auth" => "yes",
                            "authType" => "bearer-token",
                        ],
                        "getConversationWith" => [
                            "method" => "get",
                            "url" => "/api/customers/conversation/{receiverId}",
                            "auth" => "yes",
                            "authType" => "bearer-token",
                        ],
                    ],
                    "staff" => [
                        "getConversationWith" => [
                            "method" => "get",
                            "url" => "/api/staff/conversation/{receiverId}",
                            "auth" => "yes",
                            "authType" => "bearer-token",
                        ],
                    ],
                ]
            ], 404, ['Content-Type' => 'application/json; charset=UTF-8']);
        });
    }
}
