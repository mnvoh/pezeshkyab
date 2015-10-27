<?php

namespace App\Http\Controllers;

use App\Models\PublicChat;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function send(Request $request)
	{
		$message = new PublicChat();

		if(Auth::check()) {
			$message->doctor_id = Auth::user()->id;
		}
		else {
			$message->doctor_id = $request->get('doctor_id', null);
			$message->sender = $request->get('sender', '');
		}

		$message->sent_at = date('Y-m-d H:i:s');
		$message->msg = $request->get('message', '');
		$message->ip = $_SERVER['REMOTE_ADDR'];
		$message->save();

		$sender = ($message->sender) ? $message->sender : $message->doctor->name . ' ' .
					$message->doctor->lname;

		return response()->json([
			'error' => false,
			'message_id' => $message->id,
			'from' => $sender,
			'sent_at' => jdate('Y/m/d H:i:s', strtotime($message->sent_at)),
			'message' => $message->msg,
		]);
	}
}
