<?php

namespace App\Services;

use GuzzleHttp\Client;

class ChatGPTService
{
    protected $client;
    public $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('CHATGPT_API_KEY');
    }

    public function generateResponse($text)
    {
        try {
            $response = $this->client->post('https://api.openai.com/v1/completions', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                ],
                'json' => [
                    'prompt' => $text,
                    'max_tokens' => 150,
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (ClientException $e) {
            // Log the error details
            $response = $e->getResponse();
            $statusCode = $response->getStatusCode();
            $errorMessage = $response->getBody()->getContents();
            \Log::error("ChatGPT API Error - Status Code: $statusCode, Message: $errorMessage");

            // Rethrow the exception to handle it elsewhere if needed
            throw $e;
        }
    }
}

$obj = new ChatGPTService();
echo $obj->apiKey;