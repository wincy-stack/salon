<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    protected $fillable = ['service_id', 'customer_name', 'customer_contact', 'appointment_date', 'appointment_time', 'status', 'total_price'];

    public function service() {
        return $this->belongsTo(Service::class);
    }
    public function payment() {
        return $this->hasOne(Payment::class);
    }
}
