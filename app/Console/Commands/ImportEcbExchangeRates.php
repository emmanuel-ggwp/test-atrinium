<?php

namespace App\Console\Commands;

use App\Models\ExchangeRate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use SimpleXMLElement;

class ImportEcbExchangeRates extends Command
{
    protected $signature = 'import:ecb-exchange-rates';
    protected $description = 'Importa tasas de cambio históricas del BCE';

    public function handle()
    {
        $url = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-hist.xml';
        $response = Http::get($url);

        if ($response->failed()) {
            $this->error('Error al obtener el XML del BCE');
            return 1;
        }

        $xml = new SimpleXMLElement($response->body());
        $xml->registerXPathNamespace('ecb', 'http://www.ecb.int/vocabulary/2002-08-01/eurofxref');

        $entries = $xml->xpath('//ecb:Cube/ecb:Cube');

        //TODO Make the insertions with multiple processes or put the current year for limit
        //TODO "Create exchange_rate_imports to avoid checking older entries.
        foreach ($entries as $entry) {
            $time = $entry['time'];
            foreach ($entry->Cube as $cube) {
                $currency = $cube['currency'];
                $rate = $cube['rate'];
                ExchangeRate::firstOrCreate(
                    [
                        'timestamp' => $time . ' 00:00:00',
                        'base_currency' => 'EUR',
                        'target_currency' => $currency,
                    ],
                    [
                        'rate' => $rate,
                    ]
                );
            }
        }
        $this->info('Datos importados exitosamente.');
        return 0;
    }
}