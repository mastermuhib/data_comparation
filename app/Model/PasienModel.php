<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class PasienModel extends Model
{
    protected $table 	= 'patients';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}