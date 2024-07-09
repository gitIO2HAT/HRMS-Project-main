<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
Use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'user_type',
        'password',
        'middlename',
        'lastname',
        'suffix',
        'sex',
        'age',
        'custom_id',
        'birth_date',
        'phonenumber',
        'department',
        'daily_rate',
        'credit',
        'civil_status',
        'fulladdress',
        'emergency_fullname',
        'emergency_phonenumber',
        'emergency_relationship',
        'emergency_fulladdress',
        'profile_pic',
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public static function getEmployee()
{
    return self::where('user_type', '=', 2)
    ->where('is_archive', '=', 1);
}

public static function getArchiveEmployee()
{
    return self::where('user_type', '=', 2)
    ->where('is_archive', '=', 2);
}
static public function getID($id)
    {
        return self::find($id);
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($user) {
            $user->age = Carbon::parse($user->birth_date)->age;
        });
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}

