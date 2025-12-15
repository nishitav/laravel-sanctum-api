<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    // assign roles (single or array)
    public function assignRole($roles)
    {
        $roles = is_array($roles) ? $roles : [$roles];
        $roleIds = Role::whereIn('name', $roles)->pluck('id')->toArray();
        $this->roles()->syncWithoutDetaching($roleIds);
        return $this;
    }

    // sync roles (replace)
    public function syncRoles($roles)
    {
        $roles = is_array($roles) ? $roles : [$roles];
        $roleIds = Role::whereIn('name', $roles)->pluck('id')->toArray();
        $this->roles()->sync($roleIds);
        return $this;
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }

    // get abilities merged from roles (unique)
    public function getAbilitiesFromRoles(): array
    {
        return $this->roles()
            ->with('abilities')
            ->get()
            ->flatMap(function ($role) {
                return $role->abilities->pluck('name');
            })
            ->unique()
            ->values()
            ->toArray();
    }
}
