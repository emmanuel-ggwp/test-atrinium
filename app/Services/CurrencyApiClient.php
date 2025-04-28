<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyApiClient
{
    private string $accessKey;
    private string $baseUrl = 'http://data.fixer.io/api';

    public function __construct()
    {
        $this->accessKey = config('services.fixer.access_key');
        
        if (empty($this->accessKey)) {
            throw new \RuntimeException('Fixer.io API key is not configured');
        }
    }

    public function getExchangeRate(string $base, string $target): float | string
    {
        try {
            $response = Http::get("{$this->baseUrl}/latest", [
                'access_key' => $this->accessKey,
                'base' => $base,
                'symbols' => $target,
            ]);

            $data = $response->json();

            if (!$response->successful() || !$data['success']) {
                if(isset($data['error']['code'])) {
                    if($data['error']['code'] === 105) return 'Base Currency Access Restricted';
                    if($data['error']['code'] === 101) return 'Problem with the external API';
                }
                Log::error('Fixer.io API error', [
                    'response' => $data,
                    'base' => $base,
                    'target' => $target
                ]);
                throw new \RuntimeException('Failed to fetch exchange rate: ' . ($data['error']['info'] ?? 'Unknown error'));
            }

            return (float) $data['rates'][$target];
            
        } catch (\Exception $e) {
            Log::error('Exchange rate API request failed', [
                'error' => $e->getMessage(),
                'base' => $base,
                'target' => $target
            ]);
            throw $e;
        }
    }
}