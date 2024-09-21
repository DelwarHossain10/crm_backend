<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;


    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function list($request)
    {
        $filterColumns = convertQueryStringToArray($request);
        return $this::query()->with('assignedUser')
        // ->orderBy('business_id', 'desc')
        ->select('categories.*');
    }

    // Define the relationship with the User model
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assign_by');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
