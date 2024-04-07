<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SMSService
{
    public static function sendThankYouSMS($userPhoneNumber)
    {
        $smsProviderUrl = self::getSMSProviderUrl();
        $response = Http::post($smsProviderUrl, [
            'user_phone_number' => $userPhoneNumber,
            'message' => 'Thank you for submitting the reading interval.'
        ]);
        // if(!$response->successful())
        // {
        //     throw new \Exception('Failed to send sms.');
        // }
        // dd($response->failed());
        return $response->successful();
    }

    private static function getSMSProviderUrl()
    {
        $senderName = config('sms.sender_name');
        if ($senderName == 'msegat') {
            return config('sms.msegat_sender_url');
        }
        if ($senderName == 'unifonic') {
            return config('sms.unifonic_sender_url');
        }
        throw new \Exception("Invalid sms sender name: {$senderName}");
    }
}
