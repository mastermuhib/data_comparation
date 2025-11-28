<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class SchollModel extends Model
{
    protected $table 	= 'table_scholls';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}