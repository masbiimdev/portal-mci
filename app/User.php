<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
        'departemen'
    ];

    const ROLES = ['KR', 'ADM', 'SPV', 'MGT', 'STF', 'SUP'];
    const DEPARTEMEN = ['QC', 'ASSEMBLING', 'MACHINING', 'PACKING', 'PAINTING', 'WELDING', 'WAREHOUSE', 'PPIC', 'ADMIN'];
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

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'module_user', 'user_id', 'module_id');
    }
}
