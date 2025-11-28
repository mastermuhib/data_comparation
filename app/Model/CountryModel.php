<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{
    protected $table 	= 'countries';
    protected $fillable = ['id','name', 'status', 'deleted_at', 'created_at', 'updated_at'];

    protected $primaryKey = 'id';
}
