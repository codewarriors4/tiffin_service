<?php

namespace TiffinService;
use Laravel\Passport\HasApiTokens;
use TiffinService\Notifications\VerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','token','isEmailVerified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function verified(){

        return $this->token === null; 
    }

    public function sendVerificationEmail(){
         $this->notify(new VerifyEmail($this));
    }
}
