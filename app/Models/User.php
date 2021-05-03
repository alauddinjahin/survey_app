<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Pondit\Authorize\Models\Authorizable;
use Pondit\Authorize\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable, Authorizable;

    const ADMIN  = 1;
    const EDITOR = 2;
    const GUEST  = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'vendor_id',
        'photo',
        'bio',
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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function is_online()
    {
        return Cache::has('user-is-online'.$this->id);
    }


    public function role()
    {
        return $this->hasOne(Role::class,'id','role_id');
    }

    public function voter()
    {
        return $this->hasOne(Voter::class,'user_id','id');
    }

    public function isAdmin()
    {
        return $this->role_id === self::ADMIN;
    }

    public function isGuest()
    {
        return ($this->role_id === self::GUEST||$this->role->alias =='guest');
    }

}
