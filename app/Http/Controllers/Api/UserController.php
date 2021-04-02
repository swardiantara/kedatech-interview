<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;

class UserController extends Controller
{
    public function sendMessage(Request $request) {
        try {
            $sender = $this->authUser();

            $receiver = User::where('id', $request->receiverId)->first();

            if(!$receiver) {
                return response()->json([
                    "code" => 404,
                    "status" => "fail",
                    "message" => "Receiver user not found",
                ], 404);
            }
            
            if($sender->user_type_id == 1 && $receiver->user_type_id == 2) {
                return response()->json([
                    "code" => 403,
                    "status" => "fail",
                    "message" => "customer can't send message to staff",
                ], 403);
            }

            if($sender->id == $receiver->id) {
                return response()->json([
                    "code" => 400,
                    "status" => "fail",
                    "message" => "can't send message to yourself",
                ], 400);
            }

            $newMessage = Message::create([
                "sender_id" => $sender->id,
                "message" => $request->message,
                "receiver_id" => $request->receiverId,
            ]);
            // $newMessage->sender_id = $request->sender_id;
            // $newMessage->message = $request->message;
            // $newMessage->receiver_id = $request->receiver_id;
            // $createdMessage = $newMessage->save();
            
            return response()->json([
                "code" => 200,
                "status" => "success",
                "message" => "message sent successfully",
                "data" => ["message" => $newMessage]
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
