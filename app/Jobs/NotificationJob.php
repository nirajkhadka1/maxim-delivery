<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\RestException;
use Twilio\Rest\Client;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $recipients;
    protected $message;

    public $tries = 5; 

    public function __construct($recipients,$message)
    {
        Log::info(json_encode($recipients));
        $this->recipients = $recipients;
        $this->message = $message;
    }

    public function handle()
    {
        $sid = getenv('TWILIO_SID');
        $token = getenv('TWILIO_AUTH_TOKEN');
        $twilioPhoneNumber = getenv('TWILIO_NUMBER');
        $client = new Client($sid, $token);
                        


        foreach ($this->recipients as $recipient) {
            try {
                $message = $client->messages->create(
                    $recipient,
                    [
                        'from' => $twilioPhoneNumber,
                        'body' => $this->message
                    ]
                );

                Log::info("SMS sent to {$recipient}. SID: {$message->sid}");
            } catch (RestException $exception) {
                Log::error("Failed to send SMS to {$recipient}. Error: {$exception->getMessage()}");
                throw $exception;
            }
        }
    }

    public function failed(\Exception $exception)
    {
        Log::error("SMS sending failed to" .  json_encode($this->recipients) . " Error: {$exception->getMessage()}");
    }
}
