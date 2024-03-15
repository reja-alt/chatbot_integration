<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatGPTService;

class ChatController extends Controller
{
    protected $chatGPTService;

    public function __construct(ChatGPTService $chatGPTService)
    {
        $this->chatGPTService = $chatGPTService;
    }

    public function generateResponse(Request $request)
    {
        $text = $request->input('text');
        $response = $this->chatGPTService->generateResponse($text);

       // Step 2 & Step 3: Handle the response from ChatGPT API
       if (isset($response['choices'][0]['text'])) {
            $generatedText = $response['choices'][0]['text'];

            // Step 4: Display the result to the user
            return response()->json(['generated_text' => $generatedText], 200);
        } else {
            return response()->json(['error' => 'Failed to generate response'], 500);
        }
    }

    public function saveResponse(Request $request)
    {
        $text = $request->input('text');
        $response = $this->chatGPTService->generateResponse($text);

        // Step 2 & Step 3: Handle the response from ChatGPT API
        if (isset($response['choices'][0]['text'])) {
            $generatedText = $response['choices'][0]['text'];

            // Step 5: Save the result to the database, associating it with the authenticated user
            $generatedTextModel = new GeneratedText();
            $generatedTextModel->text = $generatedText;
            $generatedTextModel->user_id = auth()->id(); // Assuming you have authentication set up
            $generatedTextModel->save();

            return response()->json(['generated_text' => $generatedText], 200);
        } else {
            return response()->json(['error' => 'Failed to generate response'], 500);
        }
    }
}
