<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use App\Models\Truck;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'empId',
        'username',
        'name',
        'email',
        'password',
        'positions',
        'address',
        'phoneNumber',
        'IDCardNumber',
        'inactive'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        self::created(function (User $user) {
            if (!$user->roles()->get()->contains(2)) {
                $user->roles()->attach(2);
            }
        });
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->empId = IdGenerator::generate(['table' => 'users', 'length' => 8, 'prefix' =>'EMP-', 'field' => 'empId']);
            $model->api_token = Helper::v4();
        });
    }

    /*public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {

            $num = DB::table('users')->orderBy('id', 'desc')->first()->id ?? 0;
            $num += 1;

            $len = strlen($num);
            for($i=$len; $i< 4; ++$i) {
                $num = '0'.$num;
            }
            
            $model->empId = 'EMP-' . $num;
        });
    }*/

    public function setPasswordAttribute($password)
    {   
        $this->attributes['password'] = Hash::make($password);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function truck()
    {
        return $this->hasOne(Truck::class);
    }
}
