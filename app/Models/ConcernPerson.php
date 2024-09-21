<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConcernPerson extends Model
{
    use HasFactory;

    protected $table = 'concern_person';

    protected $fillable = [
        'name', 'phone', 'date_of_birth', 'role_id', 'job_type_id', 'gender',
        'social_network', 'email', 'designation_id', 'department_id',
        'profession_id', 'attactment', 'image', 'status'
    ];
}
