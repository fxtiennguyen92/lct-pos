<?php

namespace App\Models;

use App\Http\Controllers\UploadImage;
use App\ProjectStatusEnum;
use App\RolesEnum;
use App\ScopesEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class Project extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'code',
        'name',
        'domain',
        'status',
        'logo_path',
        'skin',
        'primary_color',
        'secondary_color',
        'has_branches',
        'secret_key'
    ];

    protected $hidden = [
        'secret_key',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'integer',
            'has_branches' => 'boolean',
        ];
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($project) {
            $project->secret_key = Str::random(40);
        });

        self::created(function ($model) {
            // temporary: get session team_id for restore at end
            $projectId = getPermissionsTeamId();

            // set actual new team_id to package instance
            setPermissionsTeamId($model);

            // create main branch
            $branch = Branch::create([
                'project_id' => $model->id,
                'code' => 'main',
                'name' => 'Principal'
            ]);
            $branch->setting()->create([]);


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

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', ProjectStatusEnum::ACTIVE);
    }

    public static function getProjects(string $search = '', bool $withTrashed = false)
    {
        return Project::where('code', 'LIKE', '%' . trim($search) . '%')
            ->orWhere('name', 'LIKE', '%' . trim($search) . '%')
            ->with(['branches'])
            ->orderBy('id')
            ->orderBy('name')
            ->paginate(20);
    }

    public static function getByCode(string $code)
    {
        return Project::where('code', $code)->first();
    }

    public static function getByCodeWithSecretKey(string $code, string $secretKey)
    {
        return Project::where('code', $code)
            ->where('secret_key', $secretKey)
            ->first();
    }
}
