<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function __construct() {
      $this->middleware('jwt.verify');
    }

    // public function sendMessage(Request $request) {
    //     try {
    //         $sender = $this->authUser();

    //         $receiver = User::where('id', $request->receiverId)->first();
            
    //         if($receiver->user_type_id == 2) {
    //             return response()->json([
    //                 "code" => 403,
    //                 "status" => "fail",
    //                 "message" => "customer can't send message to staff",
    //             ], 403);
    //         }

    //         $newMessage = Message::create([
    //             "sender_id" => $sender->id,
    //             "message" => $request->message,
    //             "receiver_id" => $request->receiverId,
    //         ]);
    //         // $newMessage->sender_id = $request->sender_id;
    //         // $newMessage->message = $request->message;
    //         // $newMessage->receiver_id = $request->receiver_id;
    //         // $createdMessage = $newMessage->save();
            
    //         return response()->json([
    //             "code" => 201,
    //             "status" => "success",
    //             "message" => "message sent successfully",
    //             "data" => $newMessage
    //         ], 201);
    //     } catch (\Throwable $th) {
    //         abort(
    //             response()->json([
    //                 "code" => 500,
    //                 "status" => "error",
    //                 "message" => "Internal Server Error"
    //             ], 500)
    //         );
    //     }
    // }

    // public function conversationWith($receiverId) {
    //     try {
    //         $sender = $this->authUser();

    //         $receiver = User::find($receiverId);

    //         if(!$receiver) {
    //             return response()->json([
    //                 "code" => 404,
    //                 "status" => "fail",
    //                 "message" => "Receiver user not found",
    //             ], 404);
    //         }
    //         $conversation = Message::whereIn('sender_id', [$sender->id, (int)$receiverId])->WhereIn('receiver_id', [$sender->id, (int)$receiverId])->orderByDesc('created_at')->get();

    //         if($conversation->isEmpty()) {
    //             return response()->json([
    //                 "code" => 404,
    //                 "status" => "fail",
    //                 "message" => "no messages found",
    //             ], 404);
    //         }

    //         return response()->json([
    //             "code" => 200,
    //             "status" => "success",
    //             "message" => "Messages data found",
    //             "data" => $conversation
    //         ], 200);

    //     } catch (\Throwable $th) {
    //         abort(
    //             response()->json([
    //                 "code" => 500,
    //                 "status" => "error",
    //                 "message" => "Internal Server Error"
    //             ], 500)
    //         );
    //     }
    // }

    public function createReport(Request $request) {
        try {
            $reporter = $this->authUser();

            if($reporter->user_type_id !=1) {
                
            }

            $validator = Validator::make($request->all(), [
                "type" => "required|in:feedback,bug",
                "description" => "required|string"
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "code" => 400,
                    "status" => "fail",
                    "message" => $validator->errors(),
                    "data" => [
                        'type' => $request->type,
                        'description' => $request->description,
                    ]
                ], 400);
            }

            $newReport = Report::create([
                'reporter_id' => $reporter->id,
                'type' => $request->type,
                'description' => $request->description,
            ]);

            return response()->json([
                'code' => 201,
                'message' => 'report created successfully',
                'result' => $newReport
            ], 201);

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
