<?php

namespace App\Http\Controllers\Admin\Screen;

use Illuminate\Http\Request;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\home;
use App\Repositories\Admin\Screen\ScreenRepository;
use App\Models\lms_screens;
class ScreenController extends Controller
{ 
   public function __construct(home $home,ScreenRepository $ScreenRepository)
   {
	   $this->home               = $home;
	   $this->ScreenRepository   = $ScreenRepository;
	   $this->user_id            = session('usrs_userid');
	   $this->get_dashborad_data = $this->home->get_dashboard_menu($this->user_id);
   }
   public function ScreenFunction()
   {
	
    $ListBuckets = $this->ScreenRepository->GetListBuckets();
	$message=array('title' => 'Admin',  'description' => "" , 'page' => 'Admin','get_dashborad_data' => $this->get_dashborad_data,'ListBuckets'=>$ListBuckets);
	

	return view('Admin.Screen.screen',$message);
	 
   }
   
   public function ScreenInsertFunction()
   {
	   
	  $CompanyId   = trim($_REQUEST['CompanyId']);
	  $BucketId    = trim($_REQUEST['BucketId']);
	  $ScreenName  = trim($_REQUEST['ScreenName']);
	  // For insert to db
	  $lms_screens = new lms_screens;
	  $lms_screens->lsn_CompanyId = $CompanyId;
	  $lms_screens->lsn_BucketId  = $BucketId;
	  $lms_screens->lsn_ScreenName= $ScreenName;
	  $lms_screens->save();
	  
	  // For Listing the view page
	  
	  $ListBuckets = $this->ScreenRepository->GetListBuckets();
	  $message=array('title' => 'Admin Screen',  'description' => "" , 'page' => 'Admin Screen','get_dashborad_data' => $this->get_dashborad_data,'ListBuckets'=>$ListBuckets);
	  
	  return view('Admin.Screen.screen',$message);
   }
}
?>
