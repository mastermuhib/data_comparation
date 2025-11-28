<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class ParentModel extends Model
{
    protected $table 	= 'student_parents';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}