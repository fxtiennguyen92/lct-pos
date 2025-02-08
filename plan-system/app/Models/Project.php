<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    /** Auditable */
    use \OwenIt\Auditing\Auditable;

    use SoftDeletes;

    protected $fillable = ['code', 'name', 'logo_path', 'skin'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public static function getProjects(string $search = '', bool $withTrashed = false)
    {
        return Project::withTrashed($withTrashed)
            ->where('code', 'LIKE', '%' . trim($search) . '%')
            ->orWhere('code', 'LIKE', '%' . trim($search) . '%')
            ->orderBy('id')
            ->orderBy('name')
            ->paginate(20);
    }
}
