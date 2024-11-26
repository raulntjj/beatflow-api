<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model{
    protected $fillable = [
        'id',
        'name',
    ];

    public function permissions(){
        return $this->belongsToMany(Permission::class, 'permission_roles', 'role_id', 'permission_id');
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id');
    }
}