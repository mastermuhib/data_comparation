<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class VillageModel extends Model
{
    protected $table    = 'villages';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $dates = ['date','created_at'];
}
