<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;


class CategoryMedical extends Model
{
    protected $table 	= 'medical_categories';
    protected $guarded = [''];
    protected $hidden   = ['created_at','updated_at'];
    public $incrementing = false;
    protected $keyType = 'uuid';

}