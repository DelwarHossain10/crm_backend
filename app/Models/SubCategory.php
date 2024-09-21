<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;


    protected $table = 'sub_categories';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function list($request)
    {
        $filterColumns = convertQueryStringToArray($request);
        return $this::query()
        // ->orderBy('business_id', 'desc')
        ->select('sub_categories.*');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
