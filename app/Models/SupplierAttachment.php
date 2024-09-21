<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierAttachment extends Model
{
    use HasFactory;

    protected $fillable = ['supplier_id', 'file_name', 'file_path'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}

