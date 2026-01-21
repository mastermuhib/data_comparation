<?php


namespace App\Model;


use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class ChangeDataMonggoDB extends Eloquent
{
	protected $connection = 'monggo_con';
	protected $collection = 'change_datas';
    //ClickAdsMonggoDB

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nik','old_data','new_data','type','code'
    ];
}