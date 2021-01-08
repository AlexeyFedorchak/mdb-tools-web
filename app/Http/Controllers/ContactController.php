<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Illuminate\Http\RedirectResponse;
use GuzzleHttp\Exception\GuzzleException;

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
        if (!$this->verifyCaptcha($request->get('g-recaptcha-response')))
            return view('error')->with([
                'message' => 'Please verify that you are not a robot!'
            ]);

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

    /**
     * verify captcha
     *
     * @param string|null $captchaCode
     * @return mixed
     * @throws GuzzleException
     */
    private function verifyCaptcha(?string $captchaCode)
    {
        if (empty($captchaCode))
            return false;

        $client = new Client();
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => env('GOOGLE_CAPTCHA_PRIVATE'),
                'response' => $captchaCode,
            ]
        ]);

        $renderedResponse = json_decode($response->getBody()->getContents());

        return $renderedResponse->success;
    }
}
