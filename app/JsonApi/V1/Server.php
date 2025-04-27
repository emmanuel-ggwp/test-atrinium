<?php

namespace App\JsonApi\V1;

use App\JsonApi\V1\ActivityTypes\ActivityTypeSchema;
use App\JsonApi\V1\Companies\CompanySchema;
use App\JsonApi\V1\RoleAppeals\RoleAppealSchema;
use App\JsonApi\V1\Users\UserSchema;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{

    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/v1';

    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void
    {
        Auth::shouldUse('sanctum');
        Company::creating(static function (Company $company): void {
            $company->owner()->associate(Auth::user());
        });
    }

    /**
     * Get the server's list of schemas.
     *
     * @return array
     */
    protected function allSchemas(): array
    {
        return [
            UserSchema::class,
            RoleAppealSchema::class,
            CompanySchema::class,
            ActivityTypeSchema::class,
        ];
    }
}
