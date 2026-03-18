<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model {
    use HasFactory;
    protected $fillable = ['category_id','name','slug','description','price','stock','image','is_active'];

    public function category() { return $this->belongsTo(Category::class); }
    public function cartItems() { return $this->hasMany(CartItem::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }

    public function getImageUrlAttribute() {
        return $this->image ? asset('storage/' . $this->image) : asset('images/no-image.png');
    }
}
