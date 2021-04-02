<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function sendMessage(Request $request) {
        try {
            $sender_id = 3;

            $newMessage = Message::create([
                'sender_id' => $sender_id,
                'message' => $request->message,
                'receiver_id' => $request->receiverId,
            ]);
            // $newMessage->sender_id = $request->sender_id;
            // $newMessage->message = $request->message;
            // $newMessage->receiver_id = $request->receiver_id;
            // $createdMessage = $newMessage->save();
            
            return response()->json([
                "code" => 200,
                "message" => "message sent successfully",
                "result" => $newMessage
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getCustomer() {
        try {
            $userId = 3;

            $user = User::where("id", $userId)->first();

            if($user->user_type_id != 2) {
                return response()->json([
                    "code" => 403,
                    "message" => "Customer data is confidential to non-Staff users"
                ]);
            }

            $customers = Customer::withTrashed()->get();

            if($customers->isEmpty()) {
                return response()->json([
                    "code" => 404,
                    "message" => "no customers data found",
                ]);
            }

            return response()->json([
                "code" => 200,
                "message" => "success",
                "result" => $customers
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAllMessages() {
        try {
            $messages = Message::all();

            if($messages->isEmpty()) {
                return response()->json([
                    "code" => 404,
                    "message" => "no messages found"
                ]);
            }

            return response()->json([
                "code" => 200,
                "message" => "success",
                "result" => $messages
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function deleteCustomer($customerId) {
        try {
            $userId = 3;
            $user = User::find($userId);

            if($user->user_type_id != 2) {
                return response()->json([
                    "code" => 403,
                    "message" => "Non-staff users can't delete customer data"
                ]);
            }

            $customer = Customer::find($customerId);

            if(!$customer) {
                return response()->json([
                    "code" => 404,
                    "message" => "customer data not found"
                ]);
            }

            if($customer->user_type_id != 1) {
                return response()->json([
                    "code" => 403,
                    "message" => "deleting data is not customer data"
                ]);
            }

            $customer->delete();

            return response()->json([
                "code" => 204,
                "message" => "customer deleted successfully"
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
