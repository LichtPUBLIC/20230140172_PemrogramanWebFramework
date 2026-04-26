<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'name', 'qty', 'price', 'category_id'];

    // Relasi: Product milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Product milik satu Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
