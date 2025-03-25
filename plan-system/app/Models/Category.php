<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'priority' => 'integer',
            'active_flg' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active_flg', true);
    }

    public function scopeParent(Builder $query): void
    {
        $query->whereNull('parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->orderBy('priority');
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public static function getCategories($projectId, $onlyParent = false, $withInactive = false,  $withTrashed = false)
    {
        $query = Category::where('project_id', $projectId);

        if ($onlyParent) {
            $query->parent();
        }

        if (!$withInactive) {
            $query->active();
        }

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->get();
    }

    public static function findCategory($id, $projectId, $withInactive = false,  $withTrashed = false)
    {
        $query = Category::where('id', $id)
            ->where('project_id', $projectId);

        if (!$withInactive) {
            $query->active();
        }

        if ($withTrashed) {
            $query->withTrashed();
        }

        return $query->first();
    }
}
