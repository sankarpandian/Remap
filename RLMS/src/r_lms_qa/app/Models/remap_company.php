<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\remap_users;
use GuzzleHttp\Client;

class remap_company extends Model
{
    //
	protected $primaryKey = 'rc_CompanyId';
    protected $table = 'remap_company';
    protected $fillable = array('remp_auth_flag', 'remp_url');

    public function user_company_authentication_url($return_user_companyid,$Login_data)
	{
//print_r($return_user_companyid); exit;
			$get_company_url = $this->select('rc_Url','rc_AuthFlag')
					  ->where('rc_CompanyId', '=',$return_user_companyid['ru_CompanyId'])
					  ->get();
					  //echo 'check flag'.$get_company_url;
			 $fet_remp_auth_flag='';
		     if(count($get_company_url)==1)					  
			 {
			 	$get_url=array();
			 	foreach($get_company_url as $company_auth_url)
			 	{
		            $get_url['rc_AuthFlag']=$company_auth_url->rc_AuthFlag;
					$get_url['rc_Url']=$company_auth_url->rc_Url;
			 	}


			 	//print_r($get_url);
			 //	exit;

			    $result_arr=array();
				if(!empty($get_url))					  
				{
						
						$fet_remp_auth_flag = $get_url['rc_AuthFlag'];
						$fet_remp_url       = $get_url['rc_Url'];

						if($fet_remp_auth_flag=='E')
						{
								$client = new Client();
									$res    = $client->request('POST', $fet_remp_url, [
										'form_params'  => [
											'username' => $Login_data['login_name'],
											'password' => $Login_data['password'],
											'ldapapp'  => 'lms-agent',
										]
									]);
								$result= $res->getBody()->getContents();
								
							
						}
						else if($fet_remp_auth_flag=='I')
						{
								
							 $client = new Client();
							 $res = $client->request('POST', $fet_remp_url, [
								'form_params' => [
									'username' => $Login_data['username'],
									'password' => $Login_data['password'],
									'ldapapp' => 'remap-lms',
								]
							]);

							$result= $res->getBody()->getContents();
						}
						else if($fet_remp_auth_flag=='D')
						{

							$remap_users=new remap_users;
							$check_company_exist = $remap_users::where('ru_UserName', '=',$Login_data['login_name'] )
									  ->where('ru_Password', '=',$Login_data['password'])
									  ->orWhere('ru_Email', '=',$Login_data['login_name'] )
									  ->where('ru_Password', '=',$Login_data['password'])
									  ->where('ru_Status', '=','1')
									  ->get();	

								 //echo $check_company_exist[0]->usrs_username;
									if(count($check_company_exist)==1)
									{
										$result='true';
									}
									else
									{
										$result= 'false';
									}
							
						}
						else
						{
							$result='false';
						}
						
				}
				else
				{
				$result= 'false';
				}
				
			 }
			 else
			 {
				$result= 'false';
			 }
		
		$result_arr=$this->response($result,$fet_remp_auth_flag);

		return 	$result_arr;		  
				
	}
	public function response($result,$mode)
	{
        $result_arr=array();
		$error_message='contact adminstrator';
		if($result=='true')
		{
			$result_arr['result']='true';
			$result_arr['result_message']='logged in successfully';
		}
		else
		{

			$result_arr['result']='false';
			if($mode=='E')    // External System auth url 
			{
				$error_message='contact Comapny Helpdesk';
			}
			else if($mode=='I')      // insternal System Remap SSO auth url 
			{
				$error_message='contact Remap Helpdesk';
			}
			else if($mode=='D')  // Database auth url from database
			{
				$error_message='Remap Helpdesk to reset password.';
			}
			else
			{
				$error_message='contact Remap Helpdesk';
			}
		
			$result_arr['result_message']='Invalid Username or Password.Please'.$error_message;

			
		}
		return $result_arr;
	}
}
