<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Str;

class Project extends Model implements Auditable
{
    /** Auditable */
    use \OwenIt\Auditing\Auditable;

    use SoftDeletes;

    protected $fillable = ['token', 'name', 'status'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->token)) {
                $project->token = Str::uuid()->toString();
            }
        });
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function taxes()
    {
        return $this->hasMany(Tax::class)->orderBy('priority');
    }

    public function productAttributeSets()
    {
        return $this->hasMany(ProductAttributeSet::class)->orderBy('priority');
    }

    public function productCategories()
    {
        return $this->hasMany(ProductCategory::class)->parent()->with('children')->orderBy('priority');
    }

    public function categories()
    {
        return $this->hasMany(ProductCategory::class)->orderBy('parent_id')->orderBy('priority');
    }

    /**
     * Find with token
     */
    public static function findByToken(string $token, bool $withTrashed = false)
    {
        if ($withTrashed) {
            return Project::withTrashed()->where('token', $token)->first();
        }

        return static::where('token', $token)->first();
    }
}
