<?php

namespace App\Http\Controllers\Ajax_Process;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\lms_screens;
use App\Models\lms_scripts;
class AdminAjaxProController extends Controller
{
    //
	public function __construct()
	{
		
	}
	
	public function ScreenDataFromBucket()
	{
	  	$lms_screens    = new lms_screens;
		$BucketId       = trim($_REQUEST['BucketId']);
		$result         = $lms_screens->select("lsn_ScreentId","lsn_ScreenName")->where("lsn_BucketId","=",$BucketId)->get();
		return $result;
	}
	public function ProductAjaxGetScript()
	{  
	    extract($_REQUEST);
		//print_r($_REQUEST);
		$lms_scripts = new lms_scripts;
		$result = $lms_scripts->select("ls_ScriptProduct")
		->where("ls_ScreenId","=",$ScreenId)
		->where("ls_BucketId","=",$BucketId)
		->where("ls_ProductCode","=",$ProductCode)
		->where("ls_CompanyId","=",3)
		->first();
		return $result['ls_ScriptProduct'];
	}
	
	public function AjaxGetScript()
	{  
	    extract($_REQUEST);
		//print_r($_REQUEST);
		$lms_scripts = new lms_scripts;
		$result = $lms_scripts->select("ls_ScriptProduct")
		->where("ls_ScreenId","=",$ScreenId)
		->where("ls_BucketId","=",$BucketId)
		->whereNull("ls_ProductCode")
		->where("ls_CompanyId","=",3)
		->first();
		return $result['ls_ScriptProduct'];
	}
}
