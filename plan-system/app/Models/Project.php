<?php

namespace App\Models;

use App\Http\Controllers\UploadImage;
use App\ProjectStatusEnum;
use App\RolesEnum;
use App\ScopesEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Models\Role;

class Project extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = ['code', 'name', 'domain', 'status', 'logo_path', 'skin'];

    protected function casts(): array
    {
        return [
            'status' => 'integer'
        ];
    }

    public static function boot()
    {
        parent::boot();

        self::created(function ($model) {
            // temporary: get session team_id for restore at end
            $projectId = getPermissionsTeamId();

            // set actual new team_id to package instance
            setPermissionsTeamId($model);

            // create default roles
            foreach (RolesEnum::values() as $role) {
                Role::create(['name' => $role, 'project_id' => $model->id]);
            }

            // assign super admin role
            foreach (User::getSuperAccounts() as $super) {
                $super->assignRole(RolesEnum::SUPER_ADMIN);
            }

            // assign admin role if author is admin
            if (Auth::check()) {
                $user = User::find(Auth::user()->id);
                if ($user->scope == ScopesEnum::ADMIN) {
                    $user->assignRole(RolesEnum::ADMIN);
                }
            }

            // restore session team_id to package instance using temporary value stored above
            setPermissionsTeamId($projectId);
        });
    }

    protected function logoPath(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (!$value) {
                    return UploadImage::getDefaultAvatar($this->name);
                }

                return asset($value);
            }
        );
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', ProjectStatusEnum::ACTIVE);
    }

    public static function getProjects(string $search = '', bool $withTrashed = false)
    {
        return Project::where('code', 'LIKE', '%' . trim($search) . '%')
            ->orWhere('name', 'LIKE', '%' . trim($search) . '%')
            ->orderBy('id')
            ->orderBy('name')
            ->paginate(20);
    }

    public static function getByCode(string $code)
    {
        return Project::where('code', $code)->first();
    }
}
