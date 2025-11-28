<?php

namespace App\Http\Controllers;

use App\Traits\Fungsi;
use Auth;
use DB;
use Illuminate\Http\Request;
use Redirect;
use App\Exceptions\Handler;


class LogsController extends Controller
{
    public function logs_admin()
    {
        $role_id         = Auth::guard('admin')->user()->id_role;
        $data = parent::sidebar();
        if ($data['access'] == 0) {
            return redirect('/');
        } else {

        // dd($data);
            return view('logs.admin.index', $data);
        }
    }

    public function data_logs_admin(Request $request)
    {
        $totalData = \App\LogAdmin::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');

        $posts = DB::table('logs as la')
            ->whereNotNull('la.id_admin')
            ->leftJoin('administrators as a', 'la.id_admin', 'a.id')
            ->select('a.name', 'aktifitas', 'la.created_at', 'la.id')
            ->orderBy('la.created_at', 'desc');

        $search = $request->input('search.value');

        if ($search) {
            $posts = $posts
                ->where('a.name', 'ILIKE', "%{$search}%")
                ->orWhere('la.aktifitas', 'ILIKE', "%{$search}%");
        }

        $totalFiltered = $posts->count();
        $posts         = $posts->offset($start)->limit($limit)->get();

        $data = array();
        if (!empty($posts)) {

            $no = 0;
            foreach ($posts as $d) {
                $no++;

                $detail = '<div style="float: left; margin-left: 5px;">
                <button type="button" data-toggle="modal" id="' . $d->id . '"  data-target="#modal_detail_log" data-tujuan="log_admin" class="btn btn-success btn-sm detail" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-eye"></i> Detail</button>
                </div>
                ';

                $nestedData['no']         = $no;
                $nestedData['admin_name'] = $d->name;
                $nestedData['aktifitas']  = $d->aktifitas;
                $nestedData['date']       = date("Y-m-d", strtotime($d->created_at));
                $nestedData['time']       = date("H-i-s", strtotime($d->created_at));
                $data[]                   = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        );

        echo json_encode($json_data);

    }

    public function logs_user()
    {
        $role_id         = Auth::guard('admin')->user()->id_role;
        $data = parent::sidebar();
        if ($data['access'] == 0) {
            return redirect('/');
        } else {
            // dd($data);
            return view('logs.user.index', $data);
        }
    }

    public function data_logs_user(Request $request)
    {
        //dd("fuck");

        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');

        $posts = DB::table('log_user as lu')
            ->whereNotNull('lu.id_user')
            ->leftJoin('users as u', 'lu.id_user', 'u.id')
            ->select('lu.*','user_name')
            ->orderBy('lu.created_at', 'desc');

        $search = $request->input('search.value');

        if ($search) {
            $posts = $posts->where('u.user_name', 'ILIKE', "%{$search}%")
                           ->orWhere('lu.activity', 'ILIKE', "%{$search}%")
                           ->orWhere('lu.menu', 'ILIKE', "%{$search}%");
        }

        $totalFiltered = $posts->count();
        $totalData = $totalFiltered;
        $posts         = $posts->offset($start)->limit($limit)->get();

        $data = array();
        if (!empty($posts)) {

            $no = 0;
            foreach ($posts as $d) {
                $no++;

                $detail = '<div style="float: left; margin-left: 5px;">
                <button type="button" data-toggle="modal" id="' . $d->id . '"  data-target="#modal_detail_log" data-tujuan="log_admin" class="btn btn-success btn-sm detail" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-eye"></i> Detail</button>
                </div>
                ';

                $nestedData['no']        = $no;
                $nestedData['user']      = $d->user_name;
                $nestedData['menu']      = $d->menu;
                $nestedData['aktifitas'] = $d->activity;
                $nestedData['tanggal']      = date("Y-m-d H:i", strtotime($d->created_at));
                $data[]                  = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        );

        echo json_encode($json_data);

    }


    public function logs_vacancy (){


        $role_id         = Auth::guard('admin')->user()->id_role;
        $data['menu']    = Fungsi::getmenu($role_id);
        $data['submenu'] = Fungsi::getsubmenu($role_id);

        // dd($data);
        return view('logs.vacancy.index', $data);
    }



  public function data_logs_vacancy(Request $request)
    {
        $totalData = \App\LogAdmin::count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $dir   = $request->input('order.0.dir');

        $posts = DB::table('logs as la')
            ->whereNotNull('la.id_admin')
            ->leftJoin('administrators as a', 'la.id_admin', 'a.id')
            ->select('a.name', 'aktifitas', 'la.created_at', 'la.id')
            ->orderBy('la.created_at', 'desc');

        $search = $request->input('search.value');

        if ($search) {
            $posts = $posts
                ->where('a.name', 'ILIKE', "%{$search}%")
                ->orWhere('la.aktifitas', 'ILIKE', "%{$search}%");
        }

        $totalFiltered = $posts->count();
        $posts         = $posts->offset($start)->limit($limit)->get();

        $data = array();
        if (!empty($posts)) {

            $no = 0;
            foreach ($posts as $d) {
                $no++;

                $detail = '<div style="float: left; margin-left: 5px;">
                <button type="button" data-toggle="modal" id="' . $d->id . '"  data-target="#modal_detail_log" data-tujuan="log_admin" class="btn btn-success btn-sm detail" style="min-width: 110px;margin-left: 2px;margin-top:3px;text-align:left"><i class="fa fa-eye"></i> Detail</button>
                </div>
                ';

                $nestedData['no']         = $no;
                $nestedData['admin_name'] = $d->name;
                $nestedData['aktifitas']  = $d->aktifitas;
                $nestedData['date']       = date("Y-m-d", strtotime($d->created_at));
                $nestedData['time']       = date("H-i-s", strtotime($d->created_at));
                $data[]                   = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
        );

        echo json_encode($json_data);

    }




}
