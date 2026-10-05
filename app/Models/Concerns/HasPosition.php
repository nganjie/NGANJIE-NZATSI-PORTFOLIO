<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Manual ordering through an integer "position" column.
 */
trait HasPosition
{
    public static function bootHasPosition(): void
    {
        static::creating(function (Model $model) {
            if (! $model->position) {
                $model->position = (int) static::query()->max('position') + 1;
            }
        });
    }

    /**
     * @param  Builder<static>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('position')->orderBy('id');
    }

    /**
     * Persist a new order from a list of ids.
     *
     * @param  array<int, int|string>  $ids
     */
    public static function reorder(array $ids): void
    {
        foreach (array_values($ids) as $index => $id) {
            static::query()->whereKey($id)->update(['position' => $index + 1]);
        }
    }
}
