<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'completed', // Make sure this field exists in your database
    ];

    protected $casts = [
        'completed' => 'boolean',
    ];

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper method to check if task is completed
    public function isCompleted()
    {
        return $this->completed;
    }

    // Scope for completed tasks
    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    // Scope for pending tasks
    public function scopePending($query)
    {
        return $query->where('completed', false);
    }
}
