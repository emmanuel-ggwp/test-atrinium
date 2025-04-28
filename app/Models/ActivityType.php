<?php

namespace App\Models;

use App\Enums\CompanyStatusEnum;
use App\Enums\DocumentTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ActivityType extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['name'];

    protected $casts = [
        'document_type' => DocumentTypeEnum::class,
        'status' => CompanyStatusEnum::class,
    ];

    /**
     * @return BelongsToMany
     */
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class);
    }
}