<?php

namespace Lareon\CMS\App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Schema;
use Lareon\CMS\App\Enums\PublishStatusEnum;

class PublishStatusScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $table = $model->getTable();
        $hasPublishedAtColumn = Schema::hasColumn($table, 'published_at');
        if (!request()->routeIs('admin.*') || !auth()->check() || !auth()->user()->can('admin')) {
            $builder->where(function (Builder $builder) {
                $builder->where('publish_status', PublishStatusEnum::Published);
            })->orWhere(function (Builder $builder) use ($hasPublishedAtColumn) {
                $builder->where('publish_status', PublishStatusEnum::Postpone)->when($hasPublishedAtColumn, function (Builder $query) {
                    $query->where('published_at', '<=', now());
                });
            });
        }
    }
}
