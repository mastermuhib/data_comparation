<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class TeacherModel extends Model
{
    protected $table 	= 'teachers';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}