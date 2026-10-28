<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'role',
        'user_type',
        'is_verified',
        'campus_name',
        'nim_nik',
        'address',
        'avatar',
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
            'is_verified' => 'boolean',
        ];
    }

    /**
     * Bank accounts owned by the user.
     *
     * @return HasMany<BankAccount, $this>
     */
    public function bankAccounts(): HasMany
    {
        return $this->hasMany(BankAccount::class);
    }

    /**
     * Primary bank account.
     *
     * @return HasOne<BankAccount, $this>
     */
    public function primaryBankAccount(): HasOne
    {
        return $this->hasOne(BankAccount::class)->where('is_primary', true);
    }

    /**
     * Verifications submitted by the user.
     *
     * @return HasMany<ContributorVerification, $this>
     */
    public function verifications(): HasMany
    {
        return $this->hasMany(ContributorVerification::class);
    }

    /**
     * Latest verification request.
     *
     * @return HasOne<ContributorVerification, $this>
     */
    public function latestVerification(): HasOne
    {
        return $this->hasOne(ContributorVerification::class)->latestOfMany();
    }

    /**
     * Artworks uploaded by the user.
     *
     * @return HasMany<Artwork, $this>
     */
    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class);
    }

    /**
     * Saved collection entries.
     *
     * @return HasMany<SavedCollection, $this>
     */
    public function savedCollections(): HasMany
    {
        return $this->hasMany(SavedCollection::class);
    }

    /**
     * Artworks saved to user collection.
     *
     * @return BelongsToMany<Artwork, $this>
     */
    public function savedArtworks(): BelongsToMany
    {
        return $this->belongsToMany(Artwork::class, 'saved_collections', 'user_id', 'artwork_id')
            ->withTimestamps();
    }

    /**
     * Determine if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Determine if the user is a student.
     */
    public function isMahasiswa(): bool
    {
        return $this->user_type === 'mahasiswa';
    }
}
