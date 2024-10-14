<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConcernPerson extends Model
{
    use HasFactory;

    protected $table = 'concern_person';

    protected $fillable = [
        'name',
        'primary_status',
        'phone',
        'email',
        'date_of_birth',
        'designation',
        'influencing_role',
        'department',
        'job_type',
        'profession',
        'gender',
        'social_network',
        'attachments'
    ];
}
