<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Ticket extends Model
{
    protected $fillable = [
        'user_id', 'order_id', 'exhibition_id', 'email', 'phone', 'status', 'snap_token', 'payment_method'
    ];

    public function exhibition()
    {
        return $this->belongsTo(\App\Models\Exhibition::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
