<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class DptModel extends Model
{
    protected $table 	= 't_dpt';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}