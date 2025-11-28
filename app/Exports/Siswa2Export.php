<?php

namespace App\Exports;

use App\Siswa;
use DB;
use Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class Siswa2Export implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $filter;

    public function __construct($data)
    {
        $this->filter = $data;
    }

    public function collection()
    {
    	$start = $this->filter['awal'];
        $end = $this->filter['akhir'];
        $prins = $this->filter['prins'];
       	return DB::table('transactions_product as t')
          ->join('users as u', 'u.id', '=', 't.id_user')
          ->join('detail_transaction as d', 't.id', '=', 'd.id_transaction')
          ->join('products as p', 'p.id', '=', 'd.id_product')
          ->join('principles as pl', 'pl.id', '=', 'p.id_principle')
          ->leftJoin('kios as k', 'k.id', '=', 't.id_kios')
          ->where('pl.id',$prins)
          ->whereBetween('t.tanggal',[$start,$end])
          ->select('t.*','k.nama_Kios as kios','pl.nama_principle','u.name as user')
          ->distinct('t.id')
          ->where(function($query) {
              $check_principle=Auth::user()->id_principle;
              if ($check_principle != null) {
                  $query->where('p.id_principle',$check_principle);
              }
          })
          ->get();
    }
}
