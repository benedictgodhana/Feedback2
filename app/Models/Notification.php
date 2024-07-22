<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'message',
        'feedback_id',
        'read',
    ];

    /**
     * Get the feedback associated with the notification.
     */
    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }
}
