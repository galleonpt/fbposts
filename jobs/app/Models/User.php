<?php

namespace App\Models;

use App\Models\Casts\EncryptCast;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthorizableContract, AuthenticatableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable. 
     *
     * @var array
     */
    protected $table = 'Users';
    public $timestamps = false;
    protected $fillable = [
        'username', 'password', 'FbAccessToken', 'FbUserID'
    ];

    protected $hidden = [
        'password', 'FbAccessToken', 'FbUserID'
    ];

    protected $casts = [
        'FbAccessToken' => EncryptCast::class,
        'FbUserID' => EncryptCast::class,
    ];

    //relationship with Pages table
    public function page()
    {
        return $this->hasMany(Page::class, 'userID', 'id');
    }


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
