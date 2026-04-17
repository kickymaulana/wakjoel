<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('order_items')]
#[Fillable(['order_id', 'menu_id', 'jumlah', 'subtotal'])]
class OrderItem extends Model
{
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke Menu (Untuk ambil nama lauk dan harga saat itu)
    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }
}
