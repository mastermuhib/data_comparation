<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class KlasifikasiModel extends Model
{
    protected $table 	= 't_clasifications';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}