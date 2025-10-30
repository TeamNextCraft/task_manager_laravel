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
        'completed',
        'category',
        'priority',
        'due_date',
        'completed_at'
    ];

    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
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

    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }

    public function isOverdue()
    {
        return $this->due_date && $this->due_date->isPast() && !$this->completed;
    }

    public function getStatusAttribute()
    {
        if ($this->completed) return 'completed';
        if ($this->isOverdue()) return 'overdue';
        return 'pending';
    }
}
