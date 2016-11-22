<?php

namespace App\Http\Controllers\Admin\Script;

use Illuminate\Http\Request;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\home;
use App\Repositories\Admin\Screen\ScreenRepository;
use App\Repositories\Admin\Script\ScriptRepository;
use App\Models\lms_scripts;
class ScriptController extends Controller
{ 
   public function __construct(home $home,ScreenRepository $ScreenRepository,ScriptRepository $ScriptRepository)
   {
	   $this->home             = $home;
	   $this->ScreenRepository = $ScreenRepository;
	   $this->ScriptRepository = $ScriptRepository;
	   $this->user_id          = session('usrs_userid');
	   $this->list_dashborad_data = $this->home->get_dashboard_menu($this->user_id);
   }
   public function ScriptFunction()
   {
	$ListProduct          = $this->ScriptRepository->GetListProducts();
    $ListBuckets         = $this->ScreenRepository->GetListBuckets();
	//$ListScreen          = $this->ScriptRepository->GetListScreen();
	$message=array('title' => 'Admin',  'description' => "" , 'page' => 'Admin','get_dashborad_data' => $this->list_dashborad_data,'ListBuckets'=>$ListBuckets,'ListProduct'=>$ListProduct);
	

	return view('Admin.Script.script',$message);
	 
   }
   public function ScriptInsertFunction()
   {
	
	// insert to database 
	$CompanyId      = trim($_REQUEST['CompanyId']);
	$BucketId       = trim($_REQUEST['BucketId']);
	$ScreenId       = trim($_REQUEST['ScreenId']);
	$lms_scripts = new lms_scripts;
	if(isset($_REQUEST['ScriptOne']) && $_REQUEST['ScriptOne']!='')
	{
	$ScriptOne      = trim($_REQUEST['ScriptOne']);
	$lms_scripts->ls_ScriptOne     = $ScriptOne;
    }
	if(isset($_REQUEST['ScriptTwo']) && $_REQUEST['ScriptTwo']!='')
	{
		$ScriptTwo      = trim($_REQUEST['ScriptTwo']);
		$lms_scripts->ls_ScripTwo      = $ScriptTwo;
	}
	if(isset($_REQUEST['ScriptThree']) && $_REQUEST['ScriptThree']!='')
	{
		$ScriptThree    = trim($_REQUEST['ScriptThree']);
		$lms_scripts->ls_ScripThree    = $ScriptThree;
	}
	if(isset($_REQUEST['descr']) && $_REQUEST['descr']!='')
	{
		$ScriptProduct  = trim($_REQUEST['descr']);
		$lms_scripts->ls_ScriptProduct = $ScriptProduct;
	}
	
	if(isset($_REQUEST['ProductCode']) && $_REQUEST['ProductCode']!='')
	{
		$Productcode  = trim($_REQUEST['ProductCode']);
		$lms_scripts->ls_ProductCode = $Productcode;
	}
    	
	$lms_scripts->ls_CompanyId     = $CompanyId;
	$lms_scripts->ls_BucketId      = $BucketId;
	$lms_scripts->ls_ScreenId      = $ScreenId;
	$lms_scripts->save();
	$success_msg = "Inserted the script details";
    //	Display for view page
	$ListBuckets         = $this->ScreenRepository->GetListBuckets();
	$ListProduct          = $this->ScriptRepository->GetListProducts();
	$message=array('title' => 'Script',  'description' => "Script" , 'page' => 'Script','get_dashborad_data' => $this->list_dashborad_data,'ListBuckets'=>$ListBuckets,'ListProduct'=>$ListProduct,'success_msg'=>$success_msg); 
	return view('Admin.Script.script',$message);
   }
}
?>
