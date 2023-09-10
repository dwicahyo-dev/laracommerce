<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id', 'name', 'description', 'price', 'image'
    ];

    /**
     * Image URL
     * 
     * @return \Illuminate\Database\Eloquent\Casts\Attribute 
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => Storage::disk('public')->exists("products/{$this->image}")
                ? Storage::disk('public')->url("products/{$this->image}")
                : $this->image,
        );
    }

    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
