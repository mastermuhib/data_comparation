<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class ClassModel extends Model
{
    protected $table 	= 'table_class';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}