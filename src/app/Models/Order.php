<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'status',
        'team_name',
        'color_choice',
        'notes',
        'design_file',
        'logo_file',
        'total_price',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted()
    {
        static::creating(function ($order) {
            if ($order->product && $order->quantity) {
                $order->total_price = $order->product->price * $order->quantity;
            } else {
                $order->total_price = 0;
            }
        });

        static::updating(function ($order) {
            if ($order->product && $order->quantity) {
                $order->total_price = $order->product->price * $order->quantity;
            } else {
                $order->total_price = 0;
            }
        });
    }
}
