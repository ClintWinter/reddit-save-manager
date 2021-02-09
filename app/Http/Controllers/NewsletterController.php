<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Newsletter;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
        ]);

        if (Newsletter::isSubscribed($data['email'])) {
            return response()->json("Looks like you are already subscribed!", 422);
        }

        Newsletter::subscribe($data['email']);

        if ($error = Newsletter::getLastError()) {
            return response()->json($error, 422);
        }

        return response()->json("Thanks for joining us!", 200);
    }
}
