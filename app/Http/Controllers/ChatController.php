<?php

namespace App\Http\Controllers;

use App\Models\PublicChat;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
	private $message_history_count = 100;

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

	public function get(Request $request)
	{
		$doctor_id = (Auth::check()) ? Auth::user()->id : $request->get('doctor_id', null);
		$messages = PublicChat::where('doctor_id', $doctor_id)
			->orderBy('id', 'DESC')
			->take($this->message_history_count)
			->get();

		$messages_array = array();
		foreach($messages as $message) {
			$sender = ($message->sender) ? $message->sender : $message->doctor->name . ' ' .
				$message->doctor->lname;
			$messages_array[] = [
				'message_id' => $message->id,
				'from' => $sender,
				'sent_at' => jdate('Y/m/d H:i:s', strtotime($message->sent_at)),
				'message' => $message->msg,
				'from_doctor' => $message->sender == null,
			];
		}

		return response()->json([
			'error' => false,
			'messages' => array_reverse($messages_array),
		]);
	}
}
