<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationCommunicationInfo extends Model
{
    use HasFactory;
    protected $table = 'organization_communication_info';
    protected $fillable = [
        'contact_no',
        'fax',
        'social_network',
        'email',
        'website',
        'image',
    ];
}
