<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class MenuModel extends Model
{
    protected $table 	= 'menus';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}