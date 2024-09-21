<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationPersonalInfo extends Model
{
    use HasFactory;
    protected $table = 'organization_personal_info';
    protected $fillable = [
        'visiting_card',
        'profession_id',
        'birthday_greetings',
        'marital_status',
        'job_type_id',
        'date_of_birth',
        'gender_id',
        'image',
    ];
}
