<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Quotation extends Model
{
    use HasFactory;


    protected $table = 'quotations';
    protected $primaryKey = 'id';

    protected $guarded = [];

    use HasFactory;


}
