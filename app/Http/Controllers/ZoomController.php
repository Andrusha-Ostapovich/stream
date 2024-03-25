<?php

namespace App\Http\Controllers;

use App\Support\Zoom\Facades\Zoom;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;

class ZoomController extends Controller
{
    public function index()
    {
        return view('zoom.index');
    }
    public function create()
    {
        return view('zoom.create');
    }
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'agenda' => 'required|string|max:255',
        //     'topic' => 'required|string|max:255',
        //     'type' => 'required|integer|in:1,2,3,8',
        //     'duration' => 'required|integer|min:1',
        //     'timezone' => 'required|string|max:255',
        //     'password' => 'nullable|string|max:255',
        //     'start_time' => 'required|date_format:Y-m-d\TH:i',
        //     'host_video' => 'nullable|boolean',
        //     'participant_video' => 'nullable|boolean',
        //     'mute_upon_entry' => 'nullable|boolean',
        //     'audio' => 'required|string|in:both,telephony,voip',
        //     'auto_recording' => 'required|string|in:none,local,cloud',
        // ]);

        $meeting = Zoom::createMeeting([
            "agenda" => "Zoom meeting creation example",
            "duration" => 30,
            "password" => "1234qwer",
            "timezone" => "UTC +2",
            "topic" => "Zoom meeting creation example",
            "type" => 2,
            "settings" => [
                "audio" => "both",
                "auto_recording" => "none",
                "host_video" => true,
                "mute_upon_entry" => true,
                "participant_video" => true,
                "registration_type" => 2
            ],
            "start_time" => "2025-12-26T12:00:00Z"
        ]);

        $signature = $this->generateJWTKey($meeting['data']['id']);
        \Log::info($signature);
        return view('zoom.show', compact('meeting', 'signature'));
    }
    // public function generateSignature($meetingNumber, $role = 0)
    // {
    //     $key = config('zoom.client_id', '');
    //     $secret = config('zoom.secret_key', '');
    //     // Отримання поточного часу
    //     $iat = time() - 30; // Вирахування часу видачі токена (зменшуємо на 30 секунд)
    //     $exp = $iat + 60 * 60 * 2; // Час закінчення токена (2 години після видачі)

    //     // Параметри токена
    //     $payload = [
    //         'sdkKey' => $key,
    //         'appKey' => $key,
    //         'mn' => $meetingNumber,
    //         'role' => $role,
    //         'iat' => $iat,
    //         'exp' => $exp,
    //         'tokenExp' => $exp,
    //     ];

    //     // Підписуємо токен
    //     $signature = JWT::encode($payload, $secret, 'HS256');

    //     return $signature;
    // }
    // public function generateSignature($meetingNumber, $role = 0)
    // {
    //     $key = config('zoom.client_id', '');
    //     $secret = config('zoom.secret_key', '');
    //     // Отримання поточного часу
    //     $iat = time() - 30; // Вирахування часу видачі токена (зменшуємо на 30 секунд)
    //     $exp = $iat + 60 * 60 * 2; // Час закінчення токена (2 години після видачі)

    //     // Створення заголовка
    //     $header = base64_encode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));

    //     // Підготовка полезного навантаження
    //     $payload = [
    //         'appKey' => $key,
    //         'iat' => $iat,
    //         'exp' => $exp,
    //         'tokenExp' => $exp,
    //         'meetingNumber' => $meetingNumber,
    //         'role' => $role
    //     ];

    //     // Кодування полезного навантаження та підпис
    //     $encodedPayload = base64_encode(json_encode($payload));
    //     $signature = hash_hmac('sha256', "{$header}.{$encodedPayload}", $secret, true);
    //     $encodedSignature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

    //     // Повернення підписаного токена
    //     return "{$header}.{$encodedPayload}.{$encodedSignature}";
    // }




        public function generateJWTKey($meetingNumber, $roleInfo = 0) : array
        {
            $key =  config('zoom.client_id', '');
            $secret = config('zoom.secret_key', '');
            $meeting_number = $meetingNumber;
            $iat = time();
            $exp = $iat + 60 * 60 * 2;
            $role = $roleInfo;
            $token = [
                "appKey" => $key,
                "sdkKey" => $key,
                "mn" => $meeting_number,
                "role" => $role,
                "iat" => $iat,
                "exp" => $exp, //60 seconds as suggested
                "tokenExp" => $exp,
            ];
            $encode = \Firebase\JWT\JWT::encode($token, $secret, 'HS256');
            $decode = \Firebase\JWT\JWT::decode($encode, $secret, $headers);
            \Log::info($decode);
            return  [
                'token'=>$encode
            ];
        }
}
