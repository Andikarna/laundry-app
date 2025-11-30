<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Services extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'name','order_time', 'estimated_time', 'price'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
