<?php

namespace App\JsonApi\V1\Users;

use App\Models\User;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Filters\Where;
use LaravelJsonApi\Eloquent\Schema;


class UserSchema extends Schema
{
    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = User::class;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            
            Str::make('name')
                ->sortable(),
            
            Str::make('email')
                ->sortable(),
            
            Str::make('password')
                ->hidden(),

            Str::make('phone')
                ->sortable(),
            
            DateTime::make('emailVerifiedAt', 'email_verified_at')
                ->sortable()
                ->readOnly(),
            
            DateTime::make('createdAt', 'created_at')
                ->sortable()
                ->readOnly(),
            
            DateTime::make('updatedAt', 'updated_at')
                ->sortable()
                ->readOnly(),
        ];
    }

    /**
     * Get the resource include paths.
     *
     * @return string[]|iterable
     */
    public function includePaths(): iterable
    {
        return [
            'createdAt',
            'updatedAt'
        ];
    }

    /**
     * Get the resource filters.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this),
            Where::make('name'),
            Where::make('email'),
        ];
    }

    /**
     * Get the resource paginator.
     *
     * @return \LaravelJsonApi\Eloquent\Pagination\PagePagination|null
     */
    public function pagination(): ?PagePagination
    {
        return PagePagination::make()
            ->withPageKey('number')
            ->withPerPageKey('size')
            ->withDefaultPerPage(15);
    }
}