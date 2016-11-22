<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\remap_users;
use App\Models\remap_company;
use App\Models\remap_dashboardrelations;
use Illuminate\support\Facades\session;
use App\Models\remap_submenus;
use App\Models\remap_menu;
use App\Models\remap_section;
use GuzzleHttp\Client;

class home extends Controller
{
    //

    public function __construct(remap_section $remap_section,remap_menu $remap_menu,remap_dashboardrelations $remap_dashboardrelations,remap_submenus $remap_submenus)
	{
        //$this->brands = remap_users::all();
		$this->remap_dashboardrelations=$remap_dashboardrelations;
	    $this->remap_sections=$remap_section;
       $this->remap_menus=$remap_menu;
       $this->remap_submenus= $remap_submenus;


	}

	public function index()
    {
    	
    	$user_id = session('usrs_userid');

    	$list_dashborad_data = $this->get_dashboard_menu($user_id);
		
		//return $list_dashborad_data;
		return view('home', array('title' => 'Home', 'description' =>'Home Page' , 'page' => 'Home','get_dashborad_data' => $list_dashborad_data));

    	

    }


    public function get_dashboard_menu($usrs_userid)
    {

		$list_dashborad_data = $this->remap_dashboardrelations
				 ->leftJoin('remap_sections','remap_dashboardrelations.rdr_SectionId', '=','remap_sections.rs_SectionId')
				 ->leftJoin('remap_menus','remap_dashboardrelations.rdr_MenuId', '=','remap_menus.rm_MenuId')
				 ->leftJoin('remap_submenus','remap_dashboardrelations.rdr_SubMenuId', '=','remap_submenus.rsm_SubMenuId')
				 ->select('remap_dashboardrelations.*','remap_sections.rs_SectionName', 'remap_menus.rm_MenuName','remap_menus.rm_MenuUrl', 'remap_submenus.rsm_SubMenuName', 'remap_submenus.rsm_SubMenuUrl','remap_dashboardrelations.rdr_MenuId')
				 ->where('remap_dashboardrelations.rdr_UserId', '=','nathan123') //$usrs_userid
				 ->orderBy('remap_sections.rs_SectionId', 'Asc')
				 ->orderBy('remap_menus.rm_MenuId', 'Asc')
				 ->get();

				 return $list_dashborad_data;
    }
}
