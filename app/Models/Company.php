<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [ 'name', 'phone', 'address', 'state', 'country', 'email', 'website', 'document_type', 'document', 'status'];

    /**
     * @var array
     */
    protected $casts = [
    ];

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function activityTypes(): BelongsToMany
    {
        return $this->belongsToMany(ActivityType::class, 'activity_type_company');
    }
}