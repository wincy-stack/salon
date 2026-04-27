<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    protected $fillable = ['booking_id', 'amount', 'payment_status', 'payment_method', 'paid_at'];

    public function booking() {
        return $this->belongsTo(Booking::class);
    }
}
