<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'suppliers';
    protected $primaryKey = 'id';

    protected $guarded = [];

    protected $fillable = [
        'supplier_name',
        'supplier_item',
        'supplier_category',
        'supplier_reputation_brand',
        'important_note',
        'concern_person_info',
        'country',
        'zone',
        'zip_po',
        'address',
        'phone',
        'fax',
        'website',
        'social_network',
    ];

    public function attachments()
    {
        return $this->hasMany(SupplierAttachment::class);
    }

}
