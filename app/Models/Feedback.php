<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'category_id',
        'subject',
        'subcategory_id', // Ensure this is included
        'name',
        'email',
        'feedback',
    ];

    // Define relationship with FeedbackCategory model
    public function category()
    {
        return $this->belongsTo(FeedbackCategory::class, 'category_id');
    }

    // Define relationship with Subcategory model
    public function subcategory()
    {
        return $this->belongsTo(FeedbackSubcategory::class, 'subcategory_id');
    }

    // Define an accessor for category_name
    public function getCategoryNameAttribute()
    {
        return $this->category->name ?? null;
    }

    // Define an accessor for subcategory_name
    public function getSubcategoryNameAttribute()
    {
        return $this->subcategory->name ?? null;
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}
