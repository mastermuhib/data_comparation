<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use DB;
use Auth;
class PaketExport2 implements FromCollection
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
       	return DB::table('transactions_chat')
     			->join('master_tarif_chat','master_tarif_chat.id','=','transactions_chat.id_level_member')
  				->join('users','users.id','=','transactions_chat.id_user')
  				->select('transactions_chat.*','master_tarif_chat.nama_master','users.name')
  				->where('transactions_chat.status',$prins)
  				->whereBetween('transactions_chat.tanggal',[$start,$end])
  				->whereNull('transactions_chat.deleted_at')
  				->get();
    }
}
