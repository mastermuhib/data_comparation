<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\MenuModel;
use DB;
use Illuminate\Support\Facades\Auth;

class sidebar extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {

        return view('components.sidebar');
    }

    public function parent_menus()
    {
        $role_id = Auth::user()->id_role;

        $menu_ids = DB::table('role_menus')
                        ->select('menu_id')
                        ->where('role_id', $role_id)->get();

        foreach ($menu_ids as $menu) {
            $data['menu_utama'][] = DB::table('menus')
                            ->where('parent_menu_id', 0)
                            ->where('id', $menu->menu_id)
                            ->get();

            $data['sub_menus'][] = DB::table('menus')
                                    ->where('parent_menu_id', '<>', 0)
                                    ->where('id', $menu->menu_id)
                                    ->get();
        }

        return $data;
    }
}
