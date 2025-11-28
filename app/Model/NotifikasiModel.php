<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class NotifikasiModel extends Model
{
    protected $table 	= 't_notifications';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}