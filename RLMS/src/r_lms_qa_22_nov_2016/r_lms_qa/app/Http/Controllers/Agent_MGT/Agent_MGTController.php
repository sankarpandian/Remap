<?php

namespace App\Http\Controllers\Agent_MGT;
use Illuminate\support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\remap_users;
use App\Models\lms_accessmanagement;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\LoginRepository;
use App\Http\Controllers\home;

class Agent_MGTController extends Controller
{
    //
	 public function __construct(remap_users $remap_users,home $home)
	{
		$this->remap_users = $remap_users;
		$this->home= $home;
	}
	
	
	public function InsertAgentDetails(remap_users $remap_users)
	{
		//echo 'I am here';
		//$remap_users->
		//print_r($_POST);
		extract($_POST);
		$remap_users->ru_FirstName     = $usrs_firstname;
		$remap_users->ru_LastName      = $usrs_lastname;
		$remap_users->ru_Email         = $usrs_email;
		$remap_users->ru_UserName      = $usrs_username;
		$remap_users->ru_Status        = 1;
		$remap_users->ru_CompanyId    = 3;
		$remap_users->ru_Role          = $usrs_role;
		$remap_users->ru_Password      = '123';
		$remap_users->ru_Userid        = $usrs_username.'123';
		$remap_users->save();
		//return array('success' => true, 'last_insert_id' => $remap_users->id);
		//$home=new home();
		$agent_access=$this->home->get_dashboard_menu($sess_user_id);
		
		return view('agent_access.agent_mgt', array('title' => 'Agent Profile', 'description' =>'Agent Page' , 'page' => 'Agent','get_dashborad_data' => $agent_access));
		//return view('agent_access.agent_mgt');
	}
	public function InsertAgentApplication(lms_accessmanagement $lms_accessmanagement)
	{
		
		//print_r($_POST);
		extract($_POST);
		$implode_lmsa_app_type=implode(',',$lmsa_app_type);
		$lms_accessmanagement->lam_AppType =$implode_lmsa_app_type;
		$lms_accessmanagement->lam_AgentType =$lmsa_agent_type;
		$lms_accessmanagement->lam_AgentTsr =$lmsa_agent_tsr;
		$lms_accessmanagement->lam_AgentConfig =$lmsa_agent_config;
		$lms_accessmanagement->lam_Branch =$lmsa_branch;
		$lms_accessmanagement->lam_Store =$lmsa_store;
		$lms_accessmanagement->save();
		return view('agent_access.agent_mgt');
		
	}
	public function agentAccessFun(LoginRepository $LoginRepository)
	{
		//extract($_POST);
		//$agentAccess        = new LoginRepository; 
		$get_all_user_data  = Session::all();
		//print_r($get_all_user_data);
	    $sess_user_id       = $get_all_user_data['usrs_userid'];
		$agentAccessDetails = $LoginRepository->dashborad_data($sess_user_id);
		$get_agent_access   = $LoginRepository->get_agent_access();
		$UserList_data      = $LoginRepository->UserList_function();
		//print_r($UserList_data);
		
		//$home=new home();
		$agent_access=$this->home->get_dashboard_menu($sess_user_id);
		
		return view('agent_access.agent_mgt', array('title' => 'Agent Profile', 'description' =>'Agent Page' , 'page' => 'Agent','get_dashborad_data' => $agent_access,'agentDetailsGetAccess' => $agentAccessDetails,'get_agent_access_list' => $get_agent_access,'UserData_display' => $UserList_data));
		
		
	//	return view('agent_access.agent_mgt', ['agentDetailsGetAccess' => $agentAccessDetails,'get_agent_access_list' => $get_agent_access,'UserData_display' => $UserList_data]);
	}
	
	
	
		
	
}
