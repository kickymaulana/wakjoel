<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('menus')]
#[Fillable(['nama_item', 'harga', 'is_available'])]
class Menu extends Model
{
    // Pastikan casting untuk boolean agar di Vue gampang dibaca
    protected function casts(): array
    {
        return [
            'is_available' => 'boolean',
            'harga' => 'decimal:2',
        ];
    }
}
