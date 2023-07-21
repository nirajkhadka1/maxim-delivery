<?php

namespace App\Http\Controllers\v1\api;

use App\Http\Controllers\Controller;
use App\Jobs\NotificationJob;
use App\Mail\WelcomeEmail;
use Exception;
use Twilio\Rest\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use SendGrid\Mail\Mail as SendGridMail;
use SendGrid;


class SmsController extends Controller
{
    public function sendSms()
    {

        try {
            $sid = getenv('TWILIO_SID');
        $token = getenv('TWILIO_AUTH_TOKEN');
        $twilioPhoneNumber = getenv('TWILIO_NUMBER');
        $client = new Client($sid, $token);
        $message = $client->messages->create('+9779800980901',
                    [
                        'from' => $twilioPhoneNumber,
                        'body' => 'MEssagee'
                    ]
                );
        dd($message);
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function sendEmail(Request $request)
    {
        try {
            $userEmail = 'niraj.khadka@webo.digital';
            $emailContent = 'This is the email.';
            $subject = 'Subject';

            $sendGridMail = new SendGridMail();
            $sendGridMail->setFrom("Lloyd@maximofficegroup.com.au", "Niraj Khadka");
            $sendGridMail->setSubject($subject);
            $sendGridMail->addTo($userEmail);
            $sendGridMail->addContent("text/plain", $emailContent);

            $sendGridApiKey = env('SENDGRID_API_KEY');
            $sendGrid = new SendGrid($sendGridApiKey);

            $response = $sendGrid->send($sendGridMail);
            if ($response->statusCode() === 202) {
                return "Email sent successfully!";
            } else {
                return "Failed to send email. Status Code: " . $response->statusCode();
            }
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
}
