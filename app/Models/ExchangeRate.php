<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'exchange_rates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'base_currency',
        'target_currency',
        'rate',
        'timestamp'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'timestamp' => 'datetime',
        'rate' => 'decimal:6',
    ];

    /**
     * Get all conversions that used this exchange rate.
     */
    public function conversions()
    {
        return $this->hasMany(Conversion::class);
    }
}