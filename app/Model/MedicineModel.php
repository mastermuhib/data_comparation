<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class MedicineModel extends Model
{
    protected $table 	= 'table_medicines';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}