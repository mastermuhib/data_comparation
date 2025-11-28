<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LogAdmin extends Model
{
    protected $table 	= 'log_admins';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $dates = ['date','created_at'];
}