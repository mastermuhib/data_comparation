<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class RoleModel extends Model
{
    protected $table 	= 'roles';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}