<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
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
     * @param ContactRequest $request
     * @return RedirectResponse
     * @throws TelegramSDKException
     */
    public function post(ContactRequest $request)
    {
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
