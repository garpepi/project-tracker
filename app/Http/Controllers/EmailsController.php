<?php

namespace App\Http\Controllers;

use App\Mail\SendMail;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailsController extends Controller
{
    public function show(Request $request)
    {
        $get = Email::where('email_config_id', $request->id)->get();
        return response()->json(['dataE' => $get]);
    }

    public function sendMail()
    {
        $details = [
            'title' => 'Mail form project tracking',
            'body' => 'This mail for testing mail using gmail'
        ];

        // Mail::to("projecttrac6@gmail.com")->send(new SendMail($details));
        Mail::to("aldi24511@gmail.com")->send(new SendMail($details));
        return "Email Send";
    }
}
