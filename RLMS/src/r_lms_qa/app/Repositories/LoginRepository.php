<?php namespace App\Repositories;

use App\Models\remap_users;
use App\Models\remap_company;
use App\Models\remap_dashboardrelations;
use App\Models\remap_section;
use App\Models\lms_callstatus;
use GuzzleHttp\Client;
class loginRepository extends BaseRepository {

	/**
	 * Create a new ContactRepository instance.
	 *
	 * @param  App\Models\Contact $contact
	 * @return void
	 */
	public function __construct(remap_users $remap_users,remap_company $remap_company,remap_dashboardrelations $remap_dashboardrelations,remap_section $remap_section,lms_callstatus $lms_callstatus)
	{
		$this->model = $remap_users;
		$this->remap_company_model=$remap_company;
		$this->remap_dashboardrelations=$remap_dashboardrelations;
		$this->remap_section=$remap_section;
		$this->lms_callstatus=$lms_callstatus;
		
	}

	/**
	 * Get contacts collection.
	 *
	 * @return Illuminate\Support\Collection
	 */
	public function index()
	{
		return $this->model
		->latest()
		->get();
	}

	/**
	 * Store a contact.
	 *
	 * @param  array $inputs
	 * @return void
	 */
	/*public function store($inputs)
	{
		$contact = new $this->model;

		$contact->name = $inputs['name'];
		$contact->email = $inputs['email'];
		
		
		$contact->text = $inputs['message'];
        $contact->nickname=$inputs['nickname'];
		$contact->contact_number=$inputs['phone'];
		$contact->save();
	}*/

	/**
	 * Update a contact.
	 *
	 * @param  bool  $vu
	 * @param  int   $id
	 * @return void
	 */
	/*public function update($seen, $id)
	{
		$contact = $this->getById($id);

		$contact->seen = $seen == 'true';

		$contact->save();
	}
    */
	/*public function check_users($input)
	{
		//$total = $this->model->count();
		$check_credentials = $this->model
		              ->where('usrs_username', '=',$input['username'] )
					  ->where('usrs_password', '=',$input['password'])
					  ->orWhere('usrs_email', '=',$input['username'] )
					   ->where('usrs_password', '=',$input['password'])
					  ->count();
		  
		return $check_credentials;
	}
	*/
	public function get_company_details($input)
	{
			$check_company_exist = $this->model
		              ->select('ru_CompanyId','ru_UserId')
					  ->where('ru_UserName', '=',$input['username'] )
					  ->where('ru_Status', '=','1')
					  ->orWhere('ru_Email', '=',$input['username'] )
					  ->where('ru_Status', '=','1')
					  ->get();
          // print_r($check_company_exist);					  
			if(count($check_company_exist)==1)
			{
		    $get_user_details['usrs_company_id'] = $check_company_exist[0]->ru_CompanyId;
			$get_user_details['usrs_userid']     = $check_company_exist[0]->ru_UserId;
			return $get_user_details;
			}
			else
			{
			return 0;	
			}
						  
				
	}
	public function get_company_login_type($company_id_for_type,$input)
	{
	$get_company_url = $this->remap_company_model
		              ->select('rc_Url','rc_AuthFlag')
					  ->where('rc_CompanyId', '=',$company_id_for_type)
					  ->get();
					  //echo 'check flag'.$get_company_url;
     if(count($get_company_url)==1)					  
	 {
	    $fet_remp_auth_flag = $get_company_url[0]->rc_AuthFlag;
		$fet_remp_url       = $get_company_url[0]->rc_Url;
		if($fet_remp_auth_flag=='E')
		{
		$client = new Client();
			$res    = $client->request('POST', $fet_remp_url, [
				'form_params'  => [
					'username' => $input['username'],
					'password' => $input['password'],
					'ldapapp'  => 'lms-agent',
				]
			]);
		$result1= $res->getBody()->getContents();
			if($result1=='true')	
			{
			$result='true';	
			}
			else
			{
			$result='false';		
			}
		}
		else if($fet_remp_auth_flag=='I')
		{
			
		 $client = new Client();
			 $res = $client->request('POST', $fet_remp_url, [
				'form_params' => [
					'username' => $input['username'],
					'password' => $input['password'],
					'ldapapp' => 'remap-lms',
				]
			]);
		$result2= $res->getBody()->getContents();
		if($result2=='true')	
			{
			$result='true';	
			}
			else
			{
			$result='false';		
			}	
			
		}
		else if($fet_remp_auth_flag=='D')
		{
			$check_company_exist = $this->model
		              ->select('ru_CompanyId')
					  ->where('ru_UserName', '=',$input['username'] )
					  ->where('ru_Password', '=',$input['password'])
					   ->where('ru_Status', '=','1')
					  ->orWhere('ru_Email', '=',$input['username'] )
					  ->where('ru_Password', '=',$input['password'])
					   ->where('ru_Status', '=','1')
					  ->get();	
					if(count($check_company_exist)==1)
					{
					$result = 'true';
					}
					else
					{
					$result = 'false';
					}
			
		}
		else
		{
			$result = 'false';
		}
	 }
	 else
	 {
		$result = 'false';
	 }
	 
	       if($result=='true')
			{
				return 'true';
			}
			else
			{
				return 'false';
			}
	}
	
	
	public function dashborad_data($user_id)
	{
		$list_dashborad_data = $this->remap_dashboardrelations
		 ->leftJoin('remap_sections','remap_dashboardrelations.rdr_SectionId', '=','remap_sections.rs_SectionId')
		 ->leftJoin('remap_menus','remap_dashboardrelations.rdr_MenuId', '=','remap_menus.rm_MenuId')
		 ->leftJoin('remap_submenus','remap_dashboardrelations.rdr_SubMenuId', '=','remap_submenus.rsm_SubMenuId')
		 ->select('remap_dashboardrelations.*','remap_sections.rs_SectionName', 'remap_menus.rm_MenuName', 'remap_submenus.rsm_SubMenuName')
		 ->where('remap_dashboardrelations.rdr_UserId', '=',$user_id)
		 ->orderBy('remap_sections.rs_SectionId', 'Asc')
		 ->get();
	    return $list_dashborad_data;
	}
	
	public function get_agent_access()
	{
		$get_agent_access_data = $this->remap_section
		 ->leftJoin('remap_menus','remap_sections.rs_SectionId', '=','remap_menus.rm_SectionId')
		 ->leftJoin('remap_submenus','remap_menus.rm_MenuId', '=','remap_submenus.rsm_MenuId')
		 ->select('remap_sections.rs_SectionId as remap_sections_id','remap_sections.rs_SectionName','remap_menus.rm_MenuId as remap_menus_id','remap_menus.rm_MenuName','remap_submenus.rsm_SubMenuId as remap_submenus_id','remap_submenus.rsm_SubMenuName')
		 ->orderBy('remap_sections.rs_SectionId', 'Asc')
		 ->orderBy('remap_menus.rm_MenuId', 'Asc')
		 ->orderBy('remap_submenus.rsm_SubMenuId', 'Asc')
		 ->get();
	    return $get_agent_access_data;
	}
	
	public function UserList_function()
	{
		$agent_front_list_data = $this->model
		->where('ru_Status', '=',1)
		->select('*')
		->orderBy('ru_UserId', 'Desc')
		->get();
		
	    return $agent_front_list_data;
	}
	public function getCallStatus()
		{
			
			$result = $this->lms_callstatus->select('lms_callstatus.lls_CallStatusId','lms_callstatus.lls_CallStatus')
			->where('lls_StatusType','=','final')
			->get();
			
									   
		    return $result;
		}
}