<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class IndividualInfo extends Model
{
    use HasFactory;
    protected $table = 'prospect_master';
    protected $fillable = [
        'initial_info_id',
        'concern_person_id',
        'organization_address_id',
        'prospect_type',
        'organization_initial_info_id',
        'organization_basic_info_id',
        'organization_personal_info_id',
        'organization_communication_info_id',
        'organization_service_info_id',
    ];

    public function initialInfo()
    {
        return $this->belongsTo(InitialInfo::class, 'initial_info_id');
    }

    public function concernPerson()
    {
        return $this->belongsTo(ConcernPerson::class, 'concern_person_id');
    }

    public function organizationAddress()
    {
        return $this->belongsTo(OrganizationAddress::class, 'organization_address_id');
    }

    public function organizationInitial()
    {
        return $this->belongsTo(OrganizationInitialInfo::class, 'organization_initial_info_id');
    }

    public function organizationBasic()
    {
        return $this->belongsTo(OrganizationBasicInfo::class, 'organization_basic_info_id');
    }

    public function organizationPersonal()
    {
        return $this->belongsTo(OrganizationPersonalInfo::class, 'organization_personal_info_id');
    }
    public function organizationCommunication()
    {
        return $this->belongsTo(OrganizationCommunicationInfo::class, 'organization_communication_info_id');
    }

    public function organizationService()
    {
        return $this->belongsTo(OrganizationServiceInfo::class, 'organization_service_info_id');
    }


}
