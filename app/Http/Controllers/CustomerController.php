<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{   
    public function __construct() {
        $this->middleware('auth:api');
    }
    
    public function sendMessage(Request $request) {
        try {
            $sender_id = 1;

            $receiver = User::where('id', $request->receiverId)->first();
            
            if($receiver->user_type_id == 2) {
                return response()->json([
                    'code' => 403,
                    'message' => "customer can't send message to staff",
                ]);
            }

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
                'code' => 200,
                'message' => 'message sent successfully',
                'result' => $newMessage
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function conversationWith($receiverId) {
        try {
            $senderId = 1;
            $conversation = Message::whereIn('sender_id', [$senderId, (int)$receiverId])->WhereIn('receiver_id', [$senderId, (int)$receiverId])->orderByDesc('created_at')->get();

            if($conversation->isEmpty()) {
                return response()->json([
                    'code' => 404,
                    'message' => 'no messages found',
                ]);
            }

            return response()->json([
                'code' => 200,
                'message' => 'success',
                'result' => $conversation
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function createReport(Request $request) {
        try {
            $reporterId = 1;

            $newReport = Report::create([
                'reporter_id' => $reporterId,
                'type' => $request->type,
                'description' => $request->description,
            ]);

            return response()->json([
                'code' => 200,
                'message' => 'report created successfully',
                'result' => $newReport
            ]);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
