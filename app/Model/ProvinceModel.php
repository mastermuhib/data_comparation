<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProvinceModel extends Model
{
    protected $table 	= 'provinces';
    protected $fillable = ['id','name', 'country_id', 'status', 'deleted_at', 'created_at', 'updated_at'];
}
