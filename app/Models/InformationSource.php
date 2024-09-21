<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationSource extends Model
{
    use HasFactory;

    protected $table = 'information_source';

    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
    ];
}
