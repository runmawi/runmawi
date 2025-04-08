<?php

namespace App\Services;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\Message;

class MicrosoftGraphMail
{
    public static function sendEmail($to, $subject, $body)
    {
        $accessToken = MicrosoftGraphAuth::getAccessToken();
        if (!$accessToken) {
            return 'Failed to retrieve access token.';
        }

        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        $emailMessage = [
            "message" => [
                "subject" => $subject,
                "body" => [
                    "contentType" => "Text",
                    "content" => $body
                ],
                "toRecipients" => [
                    [
                        "emailAddress" => ["address" => $to]
                    ]
                ]
            ]
        ];

        try {
            $graph->createRequest("POST", "/users/your-email@yourdomain.com/sendMail")
                ->attachBody($emailMessage)
                ->execute();
            return 'Email sent successfully.';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
