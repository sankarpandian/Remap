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
use App\Models\lms_managefields;
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
	 
	 $ScriptOne     = "";
	 $ScriptTwo     = "";
	 $ScriptThree   = "";
	 $ScriptProduct = "";
	 $scriptContent = "";
	// insert to database 
	$CompanyId      = trim($_REQUEST['CompanyId']);
	$BucketId       = trim($_REQUEST['BucketId']);
	$ScreenId       = trim($_REQUEST['ScreenId']);
	$ProductCode    = trim($_REQUEST['ProductCode']);
	$scriptContent  = trim($_REQUEST['txtEditor']);
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
	if(isset($_REQUEST['txtEditor']) && $_REQUEST['txtEditor']!='')
	{
		$scriptContent  = trim($_REQUEST['txtEditor']);
		$lms_scripts->ls_ScriptProduct = $scriptContent;
	}
	
	if(isset($_REQUEST['ProductCode']) && $_REQUEST['ProductCode']!='')
	{
		$Productcode  = trim($_REQUEST['ProductCode']);
		$lms_scripts->ls_ProductCode = $Productcode;
		$result = $lms_scripts->select('*')
	                      ->where("ls_ScreenId","=",$ScreenId)
						  ->where("ls_BucketId","=",$BucketId)
						  ->where("ls_ProductCode","=",$Productcode)
						  ->where("ls_CompanyId","=",3)
						  ->get();
		if(count($result)>0)						  
		{
			$lms_scripts ->where("ls_ScreenId","=",$ScreenId)
							  ->where("ls_BucketId","=",$BucketId)
							  ->where("ls_CompanyId","=",3)
							  ->where("ls_ProductCode","=",$Productcode)
							  ->update(["ls_ScriptProduct"=>$scriptContent]);
			$success_msg = "Updated the script details";
		}
		else
		{
		$lms_scripts->ls_CompanyId     = $CompanyId;
		$lms_scripts->ls_BucketId      = $BucketId;
		$lms_scripts->ls_ProductCode   = $ProductCode;
		$lms_scripts->ls_ScriptProduct = $scriptContent;
		$lms_scripts->ls_ScreenId      = $ScreenId;
		$lms_scripts->save();
		$success_msg = "Inserted the script details";
		}	
	}
	else
	{
		
		$result1 = $lms_scripts->select('*')
	                      ->where("ls_ScreenId","=",$ScreenId)
						  ->where("ls_BucketId","=",$BucketId)
						  ->where("ls_CompanyId","=",3)
						  ->get();
	 if(count($result1)>0)						  
		{
			$lms_scripts ->where("ls_ScreenId","=",$ScreenId)
							  ->where("ls_BucketId","=",$BucketId)
							  ->where("ls_CompanyId","=",3)
							  ->update(["ls_ScriptProduct"=>$scriptContent]);
			$success_msg = "Updated the script details";
		}
		else
		{
		$lms_scripts->ls_CompanyId     = $CompanyId;
		$lms_scripts->ls_BucketId      = $BucketId;
		$lms_scripts->ls_ScreenId      = $ScreenId;
		$lms_scripts->save();
		$success_msg = "Inserted the script details";
		}				  
	}
	
    
   
	
    //	Display for view page
	$ListBuckets         = $this->ScreenRepository->GetListBuckets();
	$ListProduct          = $this->ScriptRepository->GetListProducts();
	$message=array('title' => 'Script',  'description' => "Script" , 'page' => 'Script','get_dashborad_data' => $this->list_dashborad_data,'ListBuckets'=>$ListBuckets,'ListProduct'=>$ListProduct,'success_msg'=>$success_msg); 
	return view('Admin.Script.script',$message);
   }
    public function ManageFieldFunction()
    {
        $message=array('title' => 'Script',  'description' => "Script" , 'page' => 'Script','get_dashborad_data' => $this->list_dashborad_data);
        return view('Admin.Script.managefield',$message);
    }

    public function ManageFieldInsertFunction()
    {
        extract($_REQUEST);
        $lms_managefields = new lms_managefields();
        $result = $lms_managefields->select('*')
            ->where("lm_FieldName","=",$FieldName)
            ->where("lm_FieldClass","=",$FieldClass)
            ->where("lm_FieldID","=",$FieldID)
            ->get();

        if(count($result)>0)
        {
            $lms_managefields ->where("lm_FieldName","=",$FieldName)
                ->where("lm_FieldClass","=",$FieldClass)
                ->where("lm_FieldID","=",$FieldID)
				->update(['lm_FieldType'=>$FieldType,'lm_MasterData'=>$lm_MasterData,'lm_ElementValidStatus'=>$lm_ElementValidStatus]);
        }
        else {

            $lms_managefields->lm_FieldName  = $FieldName;
            $lms_managefields->lm_FieldClass = $FieldClass;
            $lms_managefields->lm_FieldID    = $FieldID;
            $lms_managefields->lm_FieldType  = $FieldType;
			$lms_managefields->lm_ScreenId   = $ScreenId;
			$lms_managefields->lm_MasterData = $lm_MasterData;
			$lms_managefields->lm_ElementValidStatus   = $lm_ElementValidStatus;
            $lms_managefields->Save();
			
        }
        $success_msg = "Updated the form details";
        $message=array('title' => 'Manage Fields',  'description' => "Manage Fields" , 'page' => 'Manage Fields','get_dashborad_data' => $this->list_dashborad_data,'success_msg'=>$success_msg);
        return view('Admin.Script.managefield',$message);
    }


}
?>
