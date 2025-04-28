<?php

use App\Console\Commands\ImportEcbExchangeRates;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('import:ecb-exchange-rates', function () {
    (new ImportEcbExchangeRates)->handle();
})->describe('Imports ECB exchange rates.');

app()->booted(function () {
    $schedule = app(Schedule::class);
    $schedule->command('import:ecb-exchange-rates')->daily();
});
