<?php
namespace App\Services;

use App\Models\Conversion;
use App\Models\ExchangeRate;
use App\Services\CurrencyApiClient;

class CurrencyConverter {
    public function __construct(private CurrencyApiClient $apiClient) {}

    public function convert(string $source, string $target, float $amount): float | string {
        // Buscar tasa reciente (últimas 24 horas)
        $rate = ExchangeRate::where('base_currency', $source)
            ->where('target_currency', $target)
            ->where('timestamp', '>=', now()->subDay())
            ->latest('timestamp')
            ->first();

        // Si no hay tasa válida, obtenerla de la API
        if (!$rate) {
            $newRateValue = $this->apiClient->getExchangeRate($source, $target);

            if (is_string($newRateValue)) {
                return $newRateValue;
            }
            if (!is_numeric($newRateValue)) {
                throw new \InvalidArgumentException('Rate must be a numeric value');
            }
            
            $rate = ExchangeRate::create([
                'base_currency' => $source,
                'target_currency' => $target,
                'rate' => $newRateValue,
                'timestamp' => now(),
            ]);
        }

        // Calcular y guardar conversión
        $convertedAmount = $amount * $rate->rate;
        Conversion::create([
            'source_currency' => $source,
            'target_currency' => $target,
            'amount' => $amount,
            'converted_amount' => $convertedAmount,
            'exchange_rate_id' => $rate->id,
        ]);

        return $convertedAmount;
    }
}