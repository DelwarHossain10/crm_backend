<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'prospect_id',
        'lead_name',
        'win_probability_id',
        'estimated_closing_date',
        'estimated_closing_amount',
        'attention_person',
        'lead_stage',
        'stage_date',
        'priority',
        'comment',
        'attachment',
        'status',
        'created_by',
        'updated_by',
    ];
}
