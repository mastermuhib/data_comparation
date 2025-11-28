<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class StudyModel extends Model
{
    protected $table 	= 'table_studies';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}