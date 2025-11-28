<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CityModel extends Model
{
    protected $table 	= 'cities';
    protected $fillable = ['id','name', 'province_id', 'status', 'deleted_at', 'created_at', 'updated_at'];
}
