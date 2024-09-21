<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InitialInfo extends Model
{
    use HasFactory;

    protected $table = 'initial_info';

    protected $fillable = [
        'name', 'project_name', 'service_id', 'info_source_id', 'organization_type_id',
        'campaign_id', 'note', 'industry_type_id', 'organization_name',
        'prospect_assigned_to_id', 'contacted_by_id', 'attactment', 'image'
    ];
}
