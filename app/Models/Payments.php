<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $fillable = [
        'order_id',
        'payment_method',
        'amount',
        'payment_date',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'order_id');
    }
}
