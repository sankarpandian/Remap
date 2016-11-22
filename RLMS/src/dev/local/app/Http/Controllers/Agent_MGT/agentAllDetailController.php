<?php

namespace App\Http\Controllers\Agent_MGT;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\remap_dashboardrelations;
use Illuminate\support\Facades\Session;
use App\Models\remap_users;
use App\Models\lms_accessmanagement;
use App\Repositories\LoginRepository;

class agentAllDetailController extends Controller
{
    //
	public function InsertAgentAllDetails(LoginRepository $LoginRepository)
	{
		//print_r($_POST);
		$remap_users         = new remap_users;
		$lmsa_agent_applicat = new lmsa_agent_applicat;
		//$LoginRepository     = new LoginRepository;
		
		$get_all_user_data  = Session::all();
	    $sess_user_id       = $get_all_user_data['usrs_userid'];
		$agentAccessDetails = $LoginRepository->dashborad_data($sess_user_id);
		$UserList_data      = $LoginRepository->UserList_function();
		$get_agent_access   = $LoginRepository->get_agent_access();
		//echo 'hii ';
		//print_r($_POST);
		$sub_menu              = "";
		$menu                  = "";
		$section               = "";
		extract($_POST);
		if(isset($Finish) && $Finish=='Finish')
        {			
		if(isset($_POST['section']) && $_POST['section']!='')
	    $section     = $_POST['section'];		
	    else
		$section     = array();
	    if(isset($_POST['menu']) && $_POST['menu']!='')
		$menu        = $_POST['menu'];
	    else
		$menu        = array(); 
	    if(isset($_POST['sub_menu']) && $_POST['sub_menu']!='')
		$sub_menu    = $_POST['sub_menu']; 
	    else
		$sub_menu    =array();
		
		//slide1
		$remap_users->ru_FirstName     = $usrs_firstname;
		$remap_users->ru_LastName      = $usrs_lastname;
		$remap_users->ru_Email         = $usrs_email;
		$remap_users->ru_UserName      = $usrs_username;
		$remap_users->ru_Status        = 1;
		$remap_users->ru_CompanyId    = 3;
		$remap_users->ru_Role          = $usrs_role;
		$remap_users->ru_Password      = '123';
		$remap_users->ru_UserId        = $usrs_username.'123';
		
		$remap_agentm_user = $remap_users
					   ->select('ru_UserId')
					   ->where('ru_UserId', '=',$usrs_username.'123' )
					   ->where('ru_Status', '=','1')
					   ->get();
		if(count($remap_agentm_user)>0)
		{
		   // return false;	
		}
		else
		{
			$remap_users->save();
		}
		
		
		//slide2
		
		$implode_lmsa_app_type=implode(',',$lmsa_app_type);
		$lmsa_agent_applicat->lmsa_app_type    = $implode_lmsa_app_type;
		$lmsa_agent_applicat->lmsa_agent_type  = $lmsa_agent_type;
		$lmsa_agent_applicat->lmsa_agent_tsr   = $lmsa_agent_tsr;
		$lmsa_agent_applicat->lmsa_agent_config= $lmsa_agent_config;
		$lmsa_branch                           = implode(',',$lmsa_branch);
		$lmsa_store                            = implode(',',$lmsa_store);
		$lmsa_agent_applicat->lmsa_branch      = $lmsa_branch;
		$lmsa_agent_applicat->lmsa_store       = $lmsa_store;
		$lmsa_agent_applicat->lmsa_user_id     = $usrs_username.'123';
		
		
		$lmsa_agent_applicat->save();
		
		
		// slide 3
		
		$section_arr_exist     = "";
		$menu_arr_exist        = "";
		$sub_menu_arr_exist    = "";
		$flag=0;
		$get_all_user_data  = Session::all();
        $sess_user_id       = $get_all_user_data['usrs_userid'];
		
        if(count($sub_menu)>0 || count($menu)>0 ||count($section)>0)		
		{
			$remap_dashboardrelations1 = new remap_dashboardrelations;	
			$remap_dashboardrelations1->where('rdr_UserId', '=', $usrs_username.'123')->delete();	
		}
		               for($k=0;$k<count($sub_menu);$k++)
						 {
							if($sub_menu_arr_exist!=$sub_menu[$k])
								{
									$remap_dashboardrelations = new remap_dashboardrelations;
									$sub_menu_arr_exist=$sub_menu[$k];
									$sub_menu_arr      = explode('_',$sub_menu_arr_exist);
									$section_get       = $sub_menu_arr[0];
									$menu_get          = $sub_menu_arr[1];
									$sub_menu_get      = $sub_menu_arr[2];
									
									$remap_dashboardrelations->rdr_UserId =$usrs_username.'123';
									$remap_dashboardrelations->rdr_SectionId =$section_get;
									$remap_dashboardrelations->rdr_MenuId =$menu_get;
									$remap_dashboardrelations->rdr_SubMenuId =$sub_menu_get;
									
									$remap_dashboardrelations->rdr_Status =0;
									$remap_dashboardrelations->rdr_CreatedBy ='chris';
									$remap_dashboardrelations->rdr_UpdatedBy ='chris';
									$remap_dashboardrelations->save();
                                    //echo 'I am insert';
								}
						 }	
						 
						for($j=0;$j<count($menu);$j++)
						{
							if($menu_arr_exist!=$menu[$j])
							{
								$remap_dashboardrelationsForMenu = new remap_dashboardrelations;
								$menu_arr_exist            = $menu[$j];
								$menu_sec_arr              = explode('_',$menu_arr_exist);
								$section_get_in_menu       = $menu_sec_arr[0];
								$menu_get_in_menu          = $menu_sec_arr[1];
								$check_sec_menu_exist = $remap_dashboardrelationsForMenu
										->select('rdr_UserId')
										->where('rdr_SectionId', '=',$section_get_in_menu )
										->where('rdr_MenuId', '=',$menu_get_in_menu)
										->where('rdr_UserId', '=',$sess_user_id)
										->where('rdr_Status', '=','0')
										->get();	
								if(count($check_sec_menu_exist)==1)
								{
								$result = 'false';
								}
								else
								{
								//$result = 'false';
								$remap_dashboardrelationsForMenu->rdr_UserId =$usrs_username.'123';
								$remap_dashboardrelationsForMenu->rdr_SectionId =$section_get_in_menu;
								$remap_dashboardrelationsForMenu->rdr_MenuId =$menu_get_in_menu;
															
								$remap_dashboardrelationsForMenu->rdr_Status =0;
								$remap_dashboardrelationsForMenu->rdr_CreatedBy ='chris';
								$remap_dashboardrelationsForMenu->rdr_UpdatedBy ='chris';
								$remap_dashboardrelationsForMenu->save();
								}
							}
							
							   
						}
						
						for($i=0;$i<count($section);$i++)
						{
							
							if($section_arr_exist!=$section[$i])
							{
							 $remap_dashboard_relatForSec = new remap_dashboardrelations;
							 $section_arr_exist=$section[$i];
							 $check_secExist = $remap_dashboard_relatForSec
										->select('relat_user_id')
										->where('relat_section_id', '=',$section_arr_exist )
										->where('relat_user_id', '=',$usrs_username.'123')
										->where('relat_status', '=','0')
										->get();	
								if(count($check_secExist)==1)
								{
									//echo 'flase';
								 $result = 'false';
								}
								else
								{
								///	echo 'tru';
								//$result = 'false';
								$remap_dashboard_relatForSec->relat_user_id =$usrs_username.'123';
								$remap_dashboard_relatForSec->relat_section_id =$section_arr_exist;
																					
								$remap_dashboard_relatForSec->relat_status =0;
								$remap_dashboard_relatForSec->relat_created_by ='chris';
								$remap_dashboard_relatForSec->relat_updated_by ='chris';
								$remap_dashboard_relatForSec->save();
								}	
							}
					    }
						return redirect('agent_mgt');
		}
		
	else if(isset($Save) && $Save=='Save')
	{
		//slide1
		$remap_users->ru_FirstName     = $usrs_firstname;
		$remap_users->ru_LastName      = $usrs_lastname;
		$remap_users->ru_Email         = $usrs_email;
		$remap_users->ru_UserName      = $usrs_username;
		$remap_users->ru_Status        = 1;
		$remap_users->ru_CompanyId    = 3;
		$remap_users->ru_Role          = $usrs_role;
		$remap_users->ru_Password      = '123';
		$remap_users->ru_UserId        = $usrs_username.'123';
		
		$remap_agentm_user = $remap_users
					   ->select('ru_UserId')
					   ->where('ru_UserId', '=',$usrs_username.'123' )
					   ->where('ru_Status', '=','1')
					   ->get();
		if(count($remap_agentm_user)>0)
		{
		  // return false;	
		}
		else
		{
			$remap_users->save();
			return redirect('agent_mgt');
		}
		
	}
	else if(isset($Insert) && $Insert=='Save')
	{
		
		//slide1
		
		print_r($_POST);
	
		$remap_users->ru_FirstName     = $usrs_firstname;
		$remap_users->ru_LastName      = $usrs_lastname;
		$remap_users->ru_Email         = $usrs_email;
		$remap_users->ru_UserName      = $usrs_username;
		$remap_users->ru_Status        = 1;
		$remap_users->ru_CompanyId    = 3;
		$remap_users->ru_Role          = $usrs_role;
		$remap_users->ru_Password      = '123';
		$remap_users->ru_UserId        = $usrs_username.'123';
		//$remap_users->save();
		$remap_agentm_user = array();
		$remap_agentm_user = $remap_users
					   ->select('ru_UserId')
					   ->where('ru_UserId', '=',$usrs_username.'123' )
					   ->where('ru_Status', '=','1')
					   ->get();
		if(count($remap_agentm_user)>0)
		{
		  // return false;	
		}
		else
		{
		$remap_users->save();
		}
		//slide2
		if(count($lmsa_app_type)>1)
		{
		$implode_lmsa_app_type=implode(',',$lmsa_app_type);
		}
		else
		{
			$implode_lmsa_app_type=$lmsa_app_type;
		}
		$lmsa_agent_applicat->lmsa_app_type =$implode_lmsa_app_type;
		$lmsa_agent_applicat->lmsa_agent_type =$lmsa_agent_type;
		$lmsa_agent_applicat->lmsa_agent_tsr =$lmsa_agent_tsr;
		$lmsa_agent_applicat->lmsa_agent_config =$lmsa_agent_config;
		if(count($lmsa_branch)>1)
		{
		$lmsa_branch    = implode(',',$lmsa_branch);
		}
		else
		{
		 $lmsa_branch    = 	$lmsa_branch[0];
		
		}
		
		if(count($lmsa_store)>1)
		{
		$lmsa_store     = implode(',',$lmsa_store);
		}
		else
		{
			
		$lmsa_store     =  $lmsa_store[0];	
		
		}
		$lmsa_agent_applicat->lmsa_branch =$lmsa_branch;
		$lmsa_agent_applicat->lmsa_store =$lmsa_store;
		$lmsa_agent_applicat->lmsa_user_id =$usrs_username.'123';
		$lmsa_agent_applicat->save();
		
		return redirect('agent_mgt');
	}
	else if(isset($Update) && $Update=='Update')
	{
		//echo "hihihi";
		/*$remap_users->usrs_firstname     = $usrs_firstname;
		$remap_users->usrs_lastname      = $usrs_lastname;
		$remap_users->usrs_email         = $usrs_email;
		$remap_users->usrs_username      = $usrs_username;
		$remap_users->usrs_role          = $usrs_role;
		$remap_users->usrs_userid        = $user_id;
		*/
	
		$remap_users					  
		->where('usrs_userid', $user_id)
		->update(['usrs_firstname' => $usrs_firstname,'usrs_lastname'=>$usrs_lastname,'usrs_email'=>$usrs_email,'usrs_username'=>$usrs_username,'usrs_role'=>$usrs_role]);
		return redirect('agent_mgt');

		
	}
	else if(isset($Update_two) && $Update_two=='Update')
	{
		/*$remap_users->usrs_firstname     = $usrs_firstname;
		$remap_users->usrs_lastname      = $usrs_lastname;
		$remap_users->usrs_email         = $usrs_email;
		$remap_users->usrs_username      = $usrs_username;
		$remap_users->usrs_role          = $usrs_role;
		$remap_users->usrs_userid        = $user_id;*/
		
		$implode_lmsa_app_type=implode(',',$lmsa_app_type);
		/*$lmsa_agent_applicat->lmsa_app_type =$implode_lmsa_app_type;
		$lmsa_agent_applicat->lmsa_agent_type =$lmsa_agent_type;
		$lmsa_agent_applicat->lmsa_agent_tsr =$lmsa_agent_tsr;
		$lmsa_agent_applicat->lmsa_agent_config =$lmsa_agent_config;*/
		$lmsa_branch    = implode(',',$lmsa_branch);
		$lmsa_store     = implode(',',$lmsa_store);
		//$lmsa_agent_applicat->lmsa_branch =$lmsa_branch;
		//$lmsa_agent_applicat->lmsa_store =$lmsa_store;
		
		$remap_users
		->where('usrs_userid', $user_id)
		->update(['usrs_firstname' => $usrs_firstname,'usrs_lastname'=>$usrs_lastname,'usrs_email'=>$usrs_email,'usrs_username'=>$usrs_username,'usrs_role'=>$usrs_role]);
		
		
		$lmsa_agent_applicat
		->where('lmsa_user_id', $user_id)
		->update(['lmsa_app_type'=>$implode_lmsa_app_type,'lmsa_agent_type'=>$lmsa_agent_type,'lmsa_agent_tsr'=>$lmsa_agent_tsr,'lmsa_agent_config'=>$lmsa_agent_config,'lmsa_branch'=>$lmsa_branch,'lmsa_store'=>$lmsa_store]);
		return redirect('agent_mgt');
	}
	else if(isset($Edit_Finish) && $Edit_Finish=='Finish')
	{
		//print_r($_POST);
		$implode_lmsa_app_type=implode(',',$lmsa_app_type);
		$lmsa_branch    = implode(',',$lmsa_branch);
		$lmsa_store     = implode(',',$lmsa_store);
		
		$remap_users
		->where('usrs_userid', $user_id)
		->update(['usrs_firstname' => $usrs_firstname,'usrs_lastname'=>$usrs_lastname,'usrs_email'=>$usrs_email,'usrs_username'=>$usrs_username,'usrs_role'=>$usrs_role]);
		
		
		$lmsa_agent_applicat
		->where('lmsa_user_id', $user_id)
		->update(['lmsa_app_type'=>$implode_lmsa_app_type,'lmsa_agent_type'=>$lmsa_agent_type,'lmsa_agent_tsr'=>$lmsa_agent_tsr,'lmsa_agent_config'=>$lmsa_agent_config,'lmsa_branch'=>$lmsa_branch,'lmsa_store'=>$lmsa_store]);
		
		$section_arr_exist     = "";
		$menu_arr_exist        = "";
		$sub_menu_arr_exist    = "";
		
		
        if(count($sub_menu)>0 || count($menu)>0 ||count($section)>0)		
		{
			$remap_dashboardrelations1 = new remap_dashboardrelations;	
			$remap_dashboardrelations1->where('rdr_UserId', '=', $user_id)->delete();	
		}
		              if($sub_menu!='')
					  {
					   for($k=0;$k<count($sub_menu);$k++)
						 {
							if($sub_menu_arr_exist!=$sub_menu[$k])
								{
									$remap_dashboardrelations = new remap_dashboardrelations;
									$sub_menu_arr_exist=$sub_menu[$k];
									$sub_menu_arr      = explode('_',$sub_menu_arr_exist);
									$section_get       = $sub_menu_arr[0];
									$menu_get          = $sub_menu_arr[1];
									$sub_menu_get      = $sub_menu_arr[2];
									
									$remap_dashboardrelations->rdr_UserId =$user_id;
									$remap_dashboardrelations->rdr_SectionId =$section_get;
									$remap_dashboardrelations->rdr_MenuId =$menu_get;
									$remap_dashboardrelations->rdr_SubMenuId =$sub_menu_get;
									
									$remap_dashboardrelations->rdr_Status =0;
									$remap_dashboardrelations->rdr_CreatedBy ='chris';
									$remap_dashboardrelations->rdr_UpdatedBy ='chris';
									$remap_dashboardrelations->save();
                                    //echo 'I am insert';
								}
						 }	
					  }
					  if($menu!='')
					  {
						for($j=0;$j<count($menu);$j++)
						{
							if($menu_arr_exist!=$menu[$j])
							{
								$remap_dashboardrelationsForMenu = new remap_dashboardrelations;
								$menu_arr_exist            = $menu[$j];
								$menu_sec_arr              = explode('_',$menu_arr_exist);
								$section_get_in_menu       = $menu_sec_arr[0];
								$menu_get_in_menu          = $menu_sec_arr[1];
								$check_sec_menu_exist = $remap_dashboardrelationsForMenu
										->select('relat_user_id')
										->where('relat_section_id', '=',$section_get_in_menu )
										->where('relat_menu_id', '=',$menu_get_in_menu)
										->where('relat_user_id', '=',$user_id)
										->where('relat_status', '=','0')
										->get();	
								if(count($check_sec_menu_exist)==1)
								{
								$result = 'false';
								}
								else
								{
								//$result = 'false';
								$remap_dashboardrelationsForMenu->rdr_UserId =$user_id;
								$remap_dashboardrelationsForMenu->rdr_SectionId =$section_get_in_menu;
								$remap_dashboardrelationsForMenu->rdr_MenuId =$menu_get_in_menu;
															
								$remap_dashboardrelationsForMenu->rdr_Status =0;
								$remap_dashboardrelationsForMenu->rdr_CreatedBy ='chris';
								$remap_dashboardrelationsForMenu->rdr_UpdatedBy ='chris';
								$remap_dashboardrelationsForMenu->save();
								}
							}
							
							   
						}
					  }
					  if($section)
					  {
						for($i=0;$i<count($section);$i++)
						{
							
							if($section_arr_exist!=$section[$i])
							{
							 $remap_dashboard_relatForSec = new remap_dashboardrelations;
							 $section_arr_exist=$section[$i];
							 $check_secExist = $remap_dashboard_relatForSec
										->select('rdr_UserId')
										->where('rdr_SectionId', '=',$section_arr_exist )
										->where('rdr_UserId', '=',$user_id)
										->where('rdr_Status', '=','0')
										->get();	
								if(count($check_secExist)==1)
								{
									//echo 'flase';
								 $result = 'false';
								}
								else
								{
								///	echo 'tru';
								//$result = 'false';
								$remap_dashboard_relatForSec->relat_user_id =$user_id;
								$remap_dashboard_relatForSec->relat_section_id =$section_arr_exist;
																					
								$remap_dashboard_relatForSec->relat_status =0;
								$remap_dashboard_relatForSec->relat_created_by ='chris';
								$remap_dashboard_relatForSec->relat_updated_by ='chris';
								$remap_dashboard_relatForSec->save();
								}	
							}
					    }
					  }
		return redirect('agent_mgt');
	}
//close fun
}
public function access_mgt_fun()
{
	$remap_users               = new remap_users;
	$remap_dashboardrelations = new remap_dashboardrelations;
	$get_send_id           = $_REQUEST['send_id'];
	
	/*$remap_agentm_user = $remap_users
					   ->select('*')
					   ->leftJoin('remap_dashboardrelations','remap_users.usrs_userid', '=','remap_dashboardrelations.relat_user_id')
					   ->leftJoin('lmsa_agent_applicats','lmsa_agent_applicats.lmsa_user_id', '=','remap_users.usrs_userid')
					   ->where('remap_users.usrs_userid', '=',$get_send_id )
					    //->where('relat_status', '=','0')
					   ->get();
    
  	*/
	$remap_agentm_user = $remap_users
					   ->select('*')
					   ->leftJoin('lms_accessmanagement','lms_accessmanagement.lam_UserId', '=','remap_users.ru_Userid')
					   ->where('remap_users.ru_UserId', '=',$get_send_id )
					    //->where('relat_status', '=','0')
					   ->get();
					   
	$remap_agentm_user['relation'] = $remap_dashboardrelations
					   ->select('*')
					   ->where('rdr_UserId', '=',$get_send_id )
					    //->where('relat_status', '=','0')
					   ->get();				   
	//$remap_agentm_user1 = 
	return $remap_agentm_user;
	//return ['data' => $remap_agentm_user];
}
public function Delete_access_mgt()
{
	//echo 'hihihih';
	$remap_users1               = new remap_users;
	$remap_dashboardrelations1 = new remap_dashboardrelations;
	$lmsa_agent_applicat1       = new lms_accessmanagement;
	$user_delete_id            = $_REQUEST['send_id'];
	$remap_users1->where('ru_UserId', '=', $user_delete_id)->delete();
	$remap_dashboardrelations1->where('rdr_UserId', '=', $user_delete_id)->delete();
	$lmsa_agent_applicat1->where('lmsa_user_id', '=', $user_delete_id)->delete();
	
	return redirect('agent_mgt');
}

	
//close class		
}
