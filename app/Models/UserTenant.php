<?php

namespace App\Models;
use Tymon\JWTAuth\Contracts\JWTSubject;


class UserTenant extends BaseUser implements JWTSubject
{
    protected $connection = 'tenant';
    protected $table = 'tenant_users';

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->ciid;
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'name' => $this->name,
            'email' => $this->email
        ];
    }
}
