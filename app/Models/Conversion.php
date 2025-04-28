<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'conversions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'source_currency',
        'target_currency',
        'amount',
        'converted_amount',
        'exchange_rate_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'amount' => 'decimal:6',
        'converted_amount' => 'decimal:6',
    ];

    /**
     * Get the exchange rate used for this conversion.
     */
    public function exchangeRate()
    {
        return $this->belongsTo(ExchangeRate::class);
    }
}