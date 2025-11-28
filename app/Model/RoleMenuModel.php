<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class RoleMenuModel extends Model
{
    protected $table 	= 'role_menus';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}