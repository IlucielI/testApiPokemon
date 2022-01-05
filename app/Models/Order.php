<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'transaction_id',
        'pokemon_id',
        'user_id',
        'transaction_token',
        'transaction_status',
        'payment_type',
        'fraud_status',
        'price',
        'order_date',
        'paid_date',
        'to_level',
        'expired',

    ];
}
