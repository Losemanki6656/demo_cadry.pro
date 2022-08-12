<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Rappasoft\LaravelAuthenticationLog\Traits\AuthenticationLoggable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use \Venturecraft\Revisionable\RevisionableTrait;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, RevisionableTrait, AuthenticationLoggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function userorganization()
    {
        return $this->belongsTo(UserOrganization::class,'id','user_id');
    }

    public function organizations()
    {
        return $this->belongsToMany(
            Organization::class,
            'user_organization',
            'user_id',
            'organization_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

}
