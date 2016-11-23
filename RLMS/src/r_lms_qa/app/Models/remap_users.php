<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class remap_users extends Model
{
    //

    protected $primaryKey = 'id';
    protected $table = 'remap_users';
    protected $fillable = array('ru_CompanyId', 'usrs_firstname', 'usrs_lastname','usrs_email','usrs_username','usrs_userid','usrs_status');

    public function IsvalidUser($login_data)
    {
    	$check_company_exist = $this->select('ru_CompanyId','ru_UserId')
					  ->where('ru_UserName', '=',$login_data['login_name'] )
					  ->orWhere('ru_Email', '=',$login_data['login_name'] )
					  ->where('ru_Status', '=','1')
					  ->get();
          // print_r($check_company_exist);					  
           //$remap_comapny=array();
			if(count($check_company_exist)==1)
			{
				foreach($check_company_exist as $userinfo)
				{
                   $remap_comapny['ru_CompanyId'] = $userinfo->ru_CompanyId;
                   $remap_comapny['ru_UserId'] = $userinfo->ru_UserId;
				}	
		        
		        $remap_comapny['result']='true';
			}
			else
			{
				$remap_comapny=array();
				$remap_comapny['result']='false';

			}
			return $remap_comapny;


    }
    
}
