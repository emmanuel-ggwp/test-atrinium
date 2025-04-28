<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CurrencyApiClient;
use App\Services\CurrencyConverter;


class ConvertionController extends Controller {
    public function convert(Request $request) {
        $validated = $request->validate([
            'source' => 'required|string|size:3',
            'target' => 'required|string|size:3',
            'amount' => 'required|numeric|min:0',
        ]);

        $converter = new CurrencyConverter(new CurrencyApiClient());
        $result = $converter->convert(
            $validated['source'],
            $validated['target'],
            $validated['amount']
        );
        if (is_string($result)) {
            return response()->json([
                'message' => $result,
                'error' => true,
            ]);
        }

        return response()->json([
            'converted_amount' => round($result, 2),
            'currency' => $validated['target'],
        ]);
    }
}
