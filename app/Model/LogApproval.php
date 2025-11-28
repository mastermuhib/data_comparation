<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LogApproval extends Model
{
    protected $table 	= 'logs_approval';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $dates = ['date','created_at'];
}