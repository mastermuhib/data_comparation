<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class DissabilityModel extends Model
{
    protected $table 	= 't_dissability';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
   
}