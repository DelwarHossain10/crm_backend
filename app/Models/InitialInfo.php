<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InitialInfo extends Model
{
    use HasFactory;

    protected $table = 'initial_info';

    protected $fillable = [
        'organization_name',
        'industry_type',
        'project_name',
        'organization_short_name',
        'interested_item_service',
        'information_source',
        'prospect_assigned_to',
        'organization_type',
        'campaign',
        'contacted_by',
        'important_note',
        'attactment',
    ];
}
