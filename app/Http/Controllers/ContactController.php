<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws TelegramSDKException
     */
    public function post(Request $request)
    {
        if (empty($request->name) && empty($request->email))
            return view('error')->with([
                'message' => 'Please tell me your name and email!'
            ]);

        if (empty($request->name))
            return view('error')->with([
                'message' => 'Please tell me your name!'
            ]);

        if (empty($request->email))
            return view('error')->with([
                'message' => 'Please tell me your email!'
            ]);

        $telegramClient = new Api(env('TELEGRAM_API_KEY'));

        $telegramClient->sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL'),
            'text' => "Gmail Logo Package contact request:\r\n"
                . 'Name: ' . $request->name . "\r\n"
                . 'Email: ' . $request->email . "\r\n"
                . 'Message: ' . $request->message . "\r\n"
        ]);

        return redirect()->to('/thank-you');
    }

    public function thankYou()
    {
        return view('thank-you');
    }
}
