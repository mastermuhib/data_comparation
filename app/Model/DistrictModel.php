<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class DistrictModel extends Model
{
    protected $table 	= 'districts';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
}
