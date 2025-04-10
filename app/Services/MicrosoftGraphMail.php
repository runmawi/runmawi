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

        $senderEmail = env('MICROSOFT_SENDER_EMAIL');
        if (empty($senderEmail)) {
            return 'MICROSOFT_SENDER_EMAIL is missing in .env.';
        }
        try {
            $graph->createRequest("POST", '/users/' . $senderEmail . '/sendMail')
                ->attachBody($emailMessage)
                ->execute();
            return 'Email sent successfully.';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }
}
