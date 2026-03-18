<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = ['user_id','total','status','shipping_address','shipping_city','shipping_phone','notes'];
    public function user() { return $this->belongsTo(User::class); }
    public function items() { return $this->hasMany(OrderItem::class); }

    public function getStatusBadgeAttribute() {
        return match($this->status) {
            'pending'    => 'badge-warning',
            'processing' => 'badge-info',
            'shipped'    => 'badge-primary',
            'delivered'  => 'badge-success',
            'cancelled'  => 'badge-danger',
            default      => 'badge-secondary',
        };
    }
}
