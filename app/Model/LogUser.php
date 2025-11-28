<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LogUser extends Model
{
    protected $table 	= 'log_participant';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $dates = ['date','created_at'];
}