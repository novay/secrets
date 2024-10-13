<?php

namespace Novay\Secret;

use Illuminate\Support\Facades\Http;

class Secret
{
    protected $baseUri, $apiKey;

    public function __construct($baseUri, $apiKey)
    {
        $this->baseUri = $baseUri;
        $this->apiKey = $apiKey;
    }

    public function getSecret($key)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->baseUri . '/api/secrets/' . $key);

        if ($response->successful()) {
            return $response->json('data');
        }

        return response()->json([
            'message' => 'Unable to retrieve secret'
        ], 401);

        // throw new \Exception("Unable to retrieve secret");
    }

    public function storeSecret($key, $value)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->baseUri . '/api/secrets', [
            'key' => $key,
            'value' => $value,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception("Unable to store secret: " . $response->body());
    }

    public function deleteSecret($key)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->delete($this->baseUri . '/api/secrets/' . $key);

        if ($response->successful()) {
            return true;
        }

        throw new \Exception("Unable to delete secret: " . $response->body());
    }
}
