<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected $sid;
    protected $token;
    protected $from;

    public function __construct()
    {
        $this->sid = env('TWILIO_SID');
        $this->token = env('TWILIO_TOKEN');
        $this->from = env('TWILIO_FROM');
    }

    public function send($to, $message)
    {
        if (empty($this->sid) || empty($this->token) || empty($this->from)) {
            Log::warning("SMS Service: Twilio credentials not found. Message to $to: $message");
            return false;
        }

        try {
            $client = new Client($this->sid, $this->token);

            $client->messages->create(
                $to,
                [
                    'from' => $this->from,
                    'body' => $message
                ]
            );

            Log::info("SMS sent to $to");
            return true;
        } catch (\Exception $e) {
            Log::error("SMS Service Error: " . $e->getMessage());
            return false;
        }
    }
}
