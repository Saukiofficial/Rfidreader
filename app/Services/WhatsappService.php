<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    protected $apiUrl;
    protected $apiToken;

    public function __construct()
    {
        $this->apiUrl = config('app.whatsapp_api_url', 'https://api.fonnte.com/send');
        $this->apiToken = config('app.whatsapp_api_token');
    }

    /**
     * Sends a message and returns a detailed status array.
     *
     * @param string $phoneNumber
     * @param string $message
     * @return array
     */
    public function sendMessage(string $phoneNumber, string $message): array
    {
        if (!$this->apiToken) {
            $errorMessage = 'WHATSAPP_API_TOKEN is not set.';
            Log::error($errorMessage);
            return ['success' => false, 'response' => $errorMessage];
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiToken,
            ])->post($this->apiUrl, [
                'target' => $phoneNumber,
                'message' => $message,
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp message sent to {$phoneNumber}.");
                return ['success' => true, 'response' => $response->body()];
            }

            $errorMessage = "Failed to send WhatsApp message to {$phoneNumber}. Response: " . $response->body();
            Log::error($errorMessage);
            return ['success' => false, 'response' => $response->body()];

        } catch (\Exception $e) {
            $errorMessage = "Exception when sending WhatsApp message: " . $e->getMessage();
            Log::error($errorMessage);
            return ['success' => false, 'response' => $errorMessage];
        }
    }
}

