<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class StudentModel extends Model
{
    protected $table 	= 'students';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}