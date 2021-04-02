<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Report;
use App\Models\Customer;
use App\Models\User;

class StaffController extends Controller
{
    public function __construct() {
        $this->middleware('jwt.verify');
      }

    // public function sendMessage(Request $request) {
    //     try {
    //         $sender = $this->authUser();

    //         $newMessage = Message::create([
    //             'sender_id' => $sender->id,
    //             'message' => $request->message,
    //             'receiver_id' => $request->receiverId,
    //         ]);
    //         // $newMessage->sender_id = $request->sender_id;
    //         // $newMessage->message = $request->message;
    //         // $newMessage->receiver_id = $request->receiver_id;
    //         // $createdMessage = $newMessage->save();
            
    //         return response()->json([
    //             "code" => 200,
    //             "message" => "message sent successfully",
    //             "result" => $newMessage
    //         ]);
    //     } catch (\Throwable $th) {
    //         abort(
    //             response()->json([
    //                 "code" => 500,
    //                 "status" => "error",
    //                 "message" => "Internal Server Error"
    //             ])
    //         );
    //     }
    // }

    public function getAllMessages() {
        try {
            $user = $this->authUser();

            if($user->user_type_id != 2) {
                return response()->json([
                    "code" => 403,
                    "status" => "fail",
                    "message" => "Chat history is confidential to non-Staff users"
                ], 403);
            }
            
            $messages = Message::all();

            if($messages->isEmpty()) {
                return response()->json([
                    "code" => 404,
                    "status" => "fail",
                    "message" => "no messages found"
                ], 404);
            }

            return response()->json([
                "code" => 200,
                "status" => "success",
                "message" => "Messages data found",
                "data" => [
                    "totalItems" => $messages->count(),
                    "messages" => $messages
                ]
            ], 200);
        } catch (\Throwable $th) {
            abort(
                response()->json([
                    "code" => 500,
                    "status" => "error",
                    "message" => "Internal Server Error"
                ], 500)
            );
        }
    }

    public function getAllReports() {
        try {
            $user = $this->authUser();

            if($user->user_type_id != 2) {
                return response()->json([
                    "code" => 403,
                    "status" => "fail",
                    "message" => "Reports data is confidential to non-Staff users"
                ], 403);
            }

            $reports = Report::all();

            if($reports->isEmpty()) {
                return response()->json([
                    "code" => 404,
                    "status" => "fail",
                    "message" => "no reports data found",
                ], 404);
            }

            return response()->json([
                "code" => 200,
                "status" => "success",
                "message" => "Reports data found",
                "data" => [
                    "totalItems" => $reports->count(),
                    "reports" => $reports
                ]
            ], 200);

        } catch (\Throwable $th) {
            abort(
                response()->json([
                    "code" => 500,
                    "status" => "error",
                    "message" => "Internal Server Error"
                ], 500)
            );
        }
    }

    public function getAllCustomers() {
        try {
            $user = $this->authUser();

            if($user->user_type_id != 2) {
                return response()->json([
                    "code" => 403,
                    "status" => "fail",
                    "message" => "Customers data is confidential to non-Staff users"
                ], 403);
            }

            $customers = Customer::withTrashed()->get();

            if($customers->isEmpty()) {
                return response()->json([
                    "code" => 404,
                    "status" => "fail",
                    "message" => "no customers data found",
                ], 404);
            }

            return response()->json([
                "code" => 200,
                "status" => "success",
                "message" => "Customers data found",
                "data" => $customers
            ], 200);

        } catch (\Throwable $th) {
            abort(
                response()->json([
                    "code" => 500,
                    "status" => "error",
                    "message" => "Internal Server Error"
                ], 500)
            );
        }
    }

    public function deleteCustomer($customerId) {
        try {
            $userId = $user = $this->authUser();

            if($user->user_type_id != 2) {
                return response()->json([
                    "code" => 403,
                    "status" => "fail",
                    "message" => "Non-staff users can't delete customer data"
                ], 403);
            }

            $customer = Customer::find($customerId);

            if(!$customer) {
                return response()->json([
                    "code" => 404,
                    "status" => "fail",
                    "message" => "customer data not found"
                ], 404);
            }

            if($customer->user_type_id != 1) {
                return response()->json([
                    "code" => 403,
                    "status" => "fail",
                    "message" => "deleting data is not customer data"
                ], 403);
            }

            $customer->delete();

            return response()->json([
                "code" => 200,
                "status" => "success",
                "message" => "customer deleted successfully"
            ], 200);
        } catch (\Throwable $th) {
            abort(
                response()->json([
                    "code" => 500,
                    "status" => "error",
                    "message" => "Internal Server Error"
                ], 500)
            );
        }
    }
}
