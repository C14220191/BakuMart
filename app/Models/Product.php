<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
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
