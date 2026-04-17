<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Table('orders')]
#[Fillable(['user_id', 'catatan_khusus', 'total_harga', 'status'])]
class Order extends Model
{
    // Relasi ke User (Siapa yang pesan)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke detail item (Apa saja lauknya)
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
