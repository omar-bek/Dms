<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Messages;
use App\Models\Conversation;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    // public $message_service;

    // public function __construct(MessageServices $message_service)
    // {
    //     $this->message_service = $message_service;
    // }
    public function send($id){

        $recipient = User::findOrFail($id);
        $sender = auth()->user();
        
        $messages = Messages::where('sender_id' , $sender->id)->orWhere('recipient_id' , $sender->id)->get();
        $mymessages = Messages::where(function($query) use ($sender, $id) {
            $query->where('sender_id', $sender->id)
                  ->where('recipient_id', $id);
        })
        ->orWhere(function($query) use ($sender, $id) {
            $query->where('sender_id', $id)
                  ->where('recipient_id', $sender->id);
        })
        ->orderBy('created_at', 'asc')->get();
        return view('admin.messages.message' ,compact('messages' , 'sender' , 'recipient' , 'mymessages'));
    }


    public function store(Request $request){

        $request->validate([
            'recipient_id'   => 'required',
            'message'               => 'required',
        ]);
        
        $sender = auth()->user(); 
        $data = $request->all();
        $data['sender_id'] = $sender->id;
        $id = $request->recipient_id;
        $conversation = Conversation::where(function($query) use ($sender, $id) {
                $query->where('sender_id', $sender->id)
                      ->where('recipient_id', $id);
            })
            ->orWhere(function($query) use ($sender, $id) {
                $query->where('sender_id', $id)
                      ->where('recipient_id', $sender->id);
            });
        $is_create = Messages::create([
            'sender_id'           =>  $request->sender_id,
            'recipient_id'   => $request->recipient_id ,
        ]);
        if($is_create != null){
            if(!$conversation){
                Conversation::create([
                    'sender_id'           =>  $request->sender_id,
                    'recipient_id'   => $request->recipient_id ,
                ]);
            }
            return redirect()->back();
        }
        return redirect()->back();

    }
}
