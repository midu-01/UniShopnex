<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'user_id',
    'name',
    'slug',
    'email',
    'phone',
    'logo_path',
    'banner_path',
    'description',
    'address_line',
    'city',
    'state',
    'postal_code',
    'country',
    'approval_status',
    'is_active',
    'settings',
    'meta',
    'approved_at',
])]
class Store extends Model
{
    /** @use HasFactory<\Database\Factories\StoreFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'settings' => 'array',
            'meta' => 'array',
            'approved_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user(): BelongsTo
    {
        return $this->owner();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    protected function fullAddress(): Attribute
    {
        return Attribute::get(fn () => collect([
            $this->address_line,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ])->filter()->implode(', '));
    }
}
