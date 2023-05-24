<?php

namespace App\Http\Controllers;

use App\Models\ChMessage;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function view()
    {
        return view('notification.index');
    }

    public function read(Request $request)
    {
        $id = $request->notif_id;
        $notif = Notification::where('id', $id);
        $notif->update([
            'read_at' => Carbon::now()
        ]);
        return back();
    }

    public function readAll(Request $request)
    {
        $data = str_replace( array('[',']') , ''  , $request->notif_id);
        $id = explode(",", $data[0]);
        $notifs = Notification::whereIn('id', $id)->get();
        foreach($notifs as $notif){
            $notif->update([
                'read_at' => Carbon::now()
            ]);
        }
        return back();
    }

    public function readMessage(Request $request)
    {
        $id = $request->message_id;
        $message = ChMessage::where('id', $id);
        $message->update([
            'seen' => 1
        ]);
        return back();
    }

    public function readMessageAll(Request $request)
    {
        $messageIds = explode(',', $request->input('message_id'));
        $messages = ChMessage::whereIn('id', $messageIds)->get();

        foreach ($messages as $message) {
            $message->update([
                'seen' => 1
            ]);
        }
    
        return back();
    }
}
