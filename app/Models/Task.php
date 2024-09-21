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
        'type',
        'start_date',
        'template',
        'attachment',
        'prospect_id',
        'contact',
        'lead_id',
        'start_time',
        'due_date',
        'time',
        'assign_to',
        'task_status_id',
        'priority_id',
        'status_id',
    ];
}
