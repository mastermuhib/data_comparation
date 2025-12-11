<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class RecapModel extends Model
{
    protected $table 	= 't_recaps';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}