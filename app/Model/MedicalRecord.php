<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class MedicalRecord extends Model
{
    protected $table 	= 'medical_records';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}