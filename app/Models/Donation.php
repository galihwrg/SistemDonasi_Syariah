<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Donation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'artwork_id',
        'donor_name',
        'donor_contact',
        'prayer_message',
        'amount',
        'midtrans_order_id',
        'midtrans_snap_token',
        'payment_method',
        'payment_status',
        'is_royalty_settled',
        'settled_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'is_royalty_settled' => 'boolean',
            'settled_at' => 'datetime',
        ];
    }

    /**
     * Artwork that received the donation.
     *
     * @return BelongsTo<Artwork, $this>
     */
    public function artwork(): BelongsTo
    {
        return $this->belongsTo(Artwork::class);
    }
}
