<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'status',
        'customer_name',
        'customer_phone',
        'customer_email',
        'delivery_address',
        'notes',
        'subtotal',
        'delivery_fee',
        'total',
        'currency',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}

