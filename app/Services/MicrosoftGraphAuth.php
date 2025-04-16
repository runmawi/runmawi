<?php

namespace App\Services;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;


class MicrosoftGraphAuth
{
    public static function getAccessToken()
    {
        $client = new Client();

        try {
            $response = $client->post('https://login.microsoftonline.com/' . env('MICROSOFT_TENANT_ID') . '/oauth2/v2.0/token', [
                'form_params' => [
                    'client_id' => env('MICROSOFT_CLIENT_ID'),
                    'client_secret' => env('MICROSOFT_CLIENT_SECRET'),
                    'scope' => env('MICROSOFT_SCOPE'),
                    'grant_type' => 'client_credentials',
                ],
            ]);

            $body = json_decode($response->getBody(), true);
            return $body['access_token'] ?? null;

        } catch (RequestException $e) {
            $errorResponse = $e->getResponse() ? $e->getResponse()->getBody()->getContents() : 'No response';
            Log::error('Microsoft Graph API Token Error: ' . $errorResponse);
            return 'Error: ' . $errorResponse;
        }
    }
}


