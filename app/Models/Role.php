<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'role_type',
    ];

    public static array $roleTypes = [
        1 => 'Admin',
        2 => 'GeneralUser',
        3 => 'GuestUser'
    ];


    public function getRoleTypeAttribute()
    {
        return self::$roleTypes[$this->attributes['role_type']];
    }

    public function setRoleTypeAttribute(string $roleType)
    {
        $this->attributes['role_type'] = array_search($roleType, self::$roleTypes);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
