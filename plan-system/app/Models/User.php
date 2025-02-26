<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Controllers\UploadImage;
use App\ScopesEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;
use OwenIt\Auditing\Contracts\Auditable;
use Propaganistas\LaravelPhone\PhoneNumber;

class User extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable, HasRoles;
    use \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'gender',
        'email',
        'password',
        'locale',
        'profile_photo_path',
        'country_code',
        'phone_number',
        'active_flg',
        'phone_number_verified_at',
        'scope',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_number_verified_at' => 'datetime',
            'password' => 'hashed',
            'active_flg' => 'boolean'
        ];
    }

    protected $appends = ['full_name', 'formatted_phone_number'];

    public function scopeActive(Builder $query): void
    {
        $query->where('active_flg', true);
    }

    public function scopeSuper(Builder $query): void
    {
        $query->where('scope', ScopesEnum::SUPER);
    }

    public function scopeAdmin(Builder $query): void
    {
        $query->where('scope', ScopesEnum::ADMIN);
    }

    public function scopeUser(Builder $query): void
    {
        $query->where('scope', ScopesEnum::USER);
    }

    protected function profilePhotoPath(): Attribute
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

    public function getFullNameAttribute()
    {
        return $this->name . ($this->first_name ? ' ' . $this->first_name : '');
    }

    public function getFormattedPhoneNumberAttribute()
    {
        if ($this->country_code && $this->phone_number) {
            $phone = new PhoneNumber($this->phone_number, $this->country_code);
            return $phone->formatInternational();
        }

        return $this->phone_number;
    }


    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public static function checkActiveUser(string $email)
    {
        return User::where('email', $email)->active()->first();
    }

    public static function getSuperAccounts()
    {
        return User::super()->active()->get();
    }

    public static function getByEmailOrPhone(string $search)
    {
        return User::where('email', $search)
            ->orWhere('phone_number', preg_replace('/^0/', '', $search))
            ->first();
    }

    public static function getByProject(string $projectCode, string $search = '')
    {
        return User::whereHas('projects', function ($query) use ($projectCode) {
            $query->where('code', $projectCode);
        })
            ->where(function ($query) use ($search) {
                $query->where('email', 'LIKE', '%' . trim($search) . '%')
                    ->orWhere('name', 'LIKE', '%' . trim($search) . '%')
                    ->orWhere('first_name', 'LIKE', '%' . trim($search) . '%')
                    ->orWhere('phone_number', 'LIKE', '%' . preg_replace('/^0/', '', $search) . '%');
            })
            ->orderBy('name')
            ->paginate(20);
    }

    public static function findUserWithProject(string $projectCode, $id)
    {
        return User::where('id', $id)
            ->whereHas('projects', function ($query) use ($projectCode) {
                $query->where('code', $projectCode);
            })
            ->user()
            ->first();
    }
}
