<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class PshycalModel extends Model
{
    protected $table 	= 'physical_records';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}