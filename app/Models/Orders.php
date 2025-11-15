<?php

namespace App\Models;

use App\Models\User;
use App\Models\Services;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'operator_id',
        'invoice_code',
        'weight',
        'total_price',
        'status',
    ];

    // Relasi ke User (operator/pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

     public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    // Relasi ke Service
    public function service()
    {
        return $this->belongsTo(Services::class, 'service_id');
    }

    public function orders()
    {
        return $this->hasMany(Orders::class);
    }

     public function payments()
    {
        return $this->hasMany(Payments::class);
    }

    

}
