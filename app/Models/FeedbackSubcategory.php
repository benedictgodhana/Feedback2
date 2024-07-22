<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackSubcategory extends Model
{
    use HasFactory;

    use HasFactory;


    protected $table = 'subcategories'; // Ensure this matches your database table name

    protected $fillable = [
        'name',
        'feedback_category_id',
        'description'
        // Add other fields as needed
    ];

    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'feedback_subcategory_id');
    }

    public function category()
    {
        return $this->belongsTo(FeedbackCategory::class, 'feedback_category_id');
    }
}
