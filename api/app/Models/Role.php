<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['name', 'guard_name'];

    public function abilities()
    {
        return $this->belongsToMany(Ability::class, 'ability_role');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
