<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Ticket extends Model
{
    protected $fillable = [
        'order_id', 'exhibition_id', 'email', 'phone', 'status', 'snap_token'
    ];

    public function exhibition()
    {
        return $this->belongsTo(\App\Models\Exhibition::class);
    }
}
