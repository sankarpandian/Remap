<?php

namespace App\Http\Controllers\Admin\Bucket;

use Illuminate\Http\Request;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\home;
use App\Models\lms_buckets;
class BucketController extends Controller
{ 
   public function __construct(home $home)
   {
	   $this->home        = $home;
	   
   }
   public function BucketFunction()
   {
	$user_id = session('usrs_userid');
	$get_dashborad_data = $this->home->get_dashboard_menu($user_id);

	$message=array('title' => 'Admin Bucket',  'description' => "" , 'page' => 'Admin Bucket','get_dashborad_data' => $get_dashborad_data);
	

	return view('Admin.Bucket.bucket',$message);
	 
   }
   
   public function BucketInsertFunction()
   {
	   $CompanyId   = trim($_REQUEST['lb_CompanyId']);
	   $BucketName  = trim($_REQUEST['lb_BucketName']);
	   // insert the bucket details
	   $lms_buckets = new lms_buckets;
	   $lms_buckets->lb_CompanyId     = $CompanyId;
	   $lms_buckets->lb_BucketName    = $BucketName;
	  // $this->lms_buckets->insert(['lb_CompanyId'=>$CompanyId,'lb_BucketName'=>$BucketName]);
	  $lms_buckets->save();
	  $user_id = session('usrs_userid');
	  $get_dashborad_data = $this->home->get_dashboard_menu($user_id);
	  
	  $message=array('title' => 'Admin',  'description' => "" , 'page' => 'Admin','get_dashborad_data' => $get_dashborad_data);
	  return view('Admin.Bucket.bucket',$message);
	
   }
}
?>
