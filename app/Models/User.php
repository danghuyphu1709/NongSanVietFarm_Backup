<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    use SoftDeletes,HasRoles;

    public $table = 'users';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'user_code',
        'address',
        'social_id',
        'name_avatar',
        'image_avatar',
        'desc',
        'avatar',
        'token',
        'status',
        'active',
        'remember_token',
        'birthday',
        'province_id',
        'district_id',
        'ward_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function provinces() :BelongsTo
    {
       return $this->belongsTo(Provinces::class,'province_id');
    }

    public function districts() :BelongsTo
    {
        return $this->belongsTo(District::class,'district_id');
    }

    public function wards() :BelongsTo
    {
        return $this->belongsTo(Ward::class,'ward_id');
    }


    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }
    public function hasPurchasedProduct($productId)
    {
        return $this->orders()->whereHas('products', function ($query) use ($productId) {
            $query->where('product_id', $productId);
        })->exists();
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'user_code';
    }

    public static function findOrCreateByGoogle($googleUser)
    {
        $user = static::where('social_id', $googleUser->id)->first();
        // If the user exists, return that user

        if ($user) {
            return $user;
        }
        // Generate a random integer for user_code
        $userCode = rand(100000, 999999); // Generate a random integer between 100000 and 999999
        // Otherwise, create a new user in your database

        $userCode = rand(100000, 999999);

        return static::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'social_id' => 1, // Set social_id to 1
            'phone' => $googleUser->phone,
            'user_code' => $userCode,
            'password' => bcrypt('randompassword'),
        ]);
    }

    public function setPasswordAttribute($value)
    {
        // Chỉ mã hóa khi giá trị của mật khẩu khác rỗng
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->user_code = fake()->uuid();
            if ($user->status == 'on'){
                $user->status = 1;
            }else {
                $user->status = 0;
            }

            if ($user->active == 'on'){
                $user->active = 1;
            }else {
                $user->active = 0;
            }
        });

        static::updating(function ($user) {
            if ($user->status == 'on'){
                $user->status = 1;
            }

            if ($user->active == 'on'){
                $user->active = 1;
            }
        });
    }

}