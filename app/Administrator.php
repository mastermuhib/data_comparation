<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Administrator extends Authenticatable
{
    // use Notifiable;
    // protected $guard   = 'admin';
    protected $table   = 'administrators';
    protected $guarded = [''];
    protected $hidden  = ['created_at', 'updated_at'];

    use SoftDeletes;
    public $incrementing = false;
    public $keyType = 'uuid';

    
}