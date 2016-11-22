<?php

namespace App\Http\Controllers\Ajax_Process;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\lms_screens;
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
}
