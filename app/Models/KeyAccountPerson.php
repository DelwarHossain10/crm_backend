<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyAccountPerson extends Model
{
    use HasFactory;

    protected $table = 'key_account_person';

    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
    ];
}
