<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Controllers\UploadImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'locale',
        'profile_photo_path',
        'active_flg',
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
            'password' => 'hashed',
            'active_flg' => 'boolean'
        ];
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active_flg', true);
    }

    protected function profilePhotoPath(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if (!$value) {
                    return UploadImage::getDefaultAvatar($this->name);
                }
                
                return $value;
            }
        );
    }

    public static function checkActiveUser(string $email)
    {
        return User::where('email', $email)->active()->first();
    }
}
