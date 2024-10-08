<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;


    protected $table = 'services';
    protected $primaryKey = 'id';

    protected $guarded = [];

    public function list($request)
    {
        $filterColumns = convertQueryStringToArray($request);
        return $this::query()
       ->orderBy('services.id', 'desc')
        ->select('services.*');
    }
}
