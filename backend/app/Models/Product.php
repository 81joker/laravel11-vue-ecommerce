<?php

namespace App\Models;

use App\Models\Color;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
      use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        "name",
        "slug",
        "qty",
        "price",
        "desc",
        "thumbnail",
        "first_image",
        "second_image",
        "third_image",
        "status",
        "category_id",
        "brand_id"
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    //TODO: review to understand more Nehad  
    public function reviews()
    {
        return $this->hasMany(Review::class)
            ->with('user')
            ->where('approved', 1)
            ->latest();
    }

    public function getRouteKeyName()
    {
        return "slug";
    }
}
