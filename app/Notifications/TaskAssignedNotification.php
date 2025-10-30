<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $task;

    /**
     * Create a new notification instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Task Assigned: ' . $this->task->title)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You have been assigned a new task: **' . $this->task->title . '**')
            ->line('Due Date: ' . ($this->task->due_date ? $this->task->due_date->format('M j, Y g:i A') : 'Not set'))
            ->line('Priority: ' . ucfirst($this->task->priority))
            ->action('View Task', route('tasks.index'))
            ->line('Thank you for using TaskFlow!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'task_priority' => $this->task->priority,
            'due_date' => $this->task->due_date,
            'message' => 'You have been assigned a new task: ' . $this->task->title,
            'type' => 'task_assigned',
        ];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'task_id' => $this->task->id,
            'task_title' => $this->task->title,
            'task_priority' => $this->task->priority,
            'due_date' => $this->task->due_date?->toDateTimeString(),
            'message' => 'You have been assigned a new task: ' . $this->task->title,
            'type' => 'task_assigned',
            'url' => route('tasks.index'),
        ];
    }
}
