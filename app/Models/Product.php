<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['name', 'description', 'price', 'stock', 'image', 'admin_id'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }
}
