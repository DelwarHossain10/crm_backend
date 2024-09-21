<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProspectMaster extends Model
{
    use HasFactory;

    protected $table = 'prospect_master';

    protected $fillable = [
        'initial_info_id',
        'concern_person_id',
        'organization_address_id'
    ];

    public function initialInfo() {
        return $this->belongsTo(InitialInfo::class, 'initial_info_id');
    }

    public function concernPerson() {
        return $this->belongsTo(ConcernPerson::class, 'concern_person_id');
    }

    public function organizationAddress() {
        return $this->belongsTo(OrganizationAddress::class, 'organization_address_id');
    }
}
