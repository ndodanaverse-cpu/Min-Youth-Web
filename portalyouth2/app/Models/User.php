<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'is_active',
        'activated_at',
        'last_login_at',
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
            'is_active' => 'boolean',
            'activated_at' => 'datetime',
            'last_login_at' => 'datetime',
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(OpportunityApplication::class);
    }

    public function savedOpportunities(): HasMany
    {
        return $this->hasMany(SavedOpportunity::class);
    }

    public function createdOpportunities(): HasMany
    {
        return $this->hasMany(Opportunity::class, 'created_by');
    }

    /**
     * A registered portal user becomes active once their OTP has been verified.
     */
    public function isActivated(): bool
    {
        return $this->activated_at !== null;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(\App\Enums\UserRole::Admin->value);
    }

    public function isContentEditor(): bool
    {
        return $this->hasRole(\App\Enums\UserRole::ContentEditor->value);
    }

    public function isBackOfficeUser(): bool
    {
        return $this->isAdmin() || $this->isContentEditor();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active;
    }
}
