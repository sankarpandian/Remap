<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\lms_callfroms;
use App\Models\lms_hdtypes;
use App\Models\lms_products;
use App\Models\lms_nonproducts;
use App\Models\lms_customerhometypes;
use App\Models\remap_users;
use App\Models\mdm_remapdnis;
use App\Models\lms_scripts;
class CallerScreenRepository extends Model
{
    //
	public function __construct(lms_callfroms $lms_callfroms, lms_hdtypes $lms_hdtypes,lms_products $lms_products,lms_nonproducts $lms_nonproducts,lms_customerhometypes $lms_customerhometypes,remap_users $remap_users,mdm_remapdnis $mdm_remapdnis)
	{
		$this->lms_callfroms         = $lms_callfroms;
		$this->lms_hdtypes           = $lms_hdtypes;
		$this->lms_products           = $lms_products;
		$this->lms_nonproducts       = $lms_nonproducts;
		$this->lms_customerhometypes = $lms_customerhometypes;
		$this->remap_users            = $remap_users;
		$this->mdm_remapdnis         = $mdm_remapdnis;
	}
		public function lms_callfroms_fun()
		{
			
			$remap_agentm_user = $this->lms_callfroms
						   ->select('*')
						   ->get();				   
			//$remap_agentm_user1 = 
			return $remap_agentm_user;
		}
		
		public function lms_hdtypes_fun()
		{
			$remap_lms_hdtypes = $this->lms_hdtypes
						   ->select('*')
						   ->where("lht_HdTypeId","!=","3")
						   ->get();				   
			//$remap_agentm_user1 = 
			return $remap_lms_hdtypes;
		}
		
		public function listNonProductFun()
		{
		  $result = $this->lms_nonproducts
            ->join('lms_products', 'lms_products.lp_ProductId', '=', 'lms_nonproducts.lnp_ProductId')
            ->select('lms_nonproducts.*', 'lms_products.lp_ProductName', 'lms_products.lp_ProductCode')
            ->get();
		  return $result;
		}
		
		public function lms_customerhometypes_fun()
		{
			$lms_customerhometypes_res = $this->lms_customerhometypes
						   ->select('*')
						   ->where('lch_HomeTypeId','!=','6')
						   ->get();
			return $lms_customerhometypes_res;
		}
		public function list_lms_agent_users()
		{
		   $resultAgentUser = $this->remap_users
                                   ->select('ru_FirstName','ru_LastName','ru_UserId')
                                   ->where("ru_Status","=",1)
								   ->get();	
           return $resultAgentUser;								   
		}
		
		public function associate_dnis_desc($call_from)
		{
		if($call_from!='')
		{
		   $associate_dnis_desc = $this->mdm_remapdnis->select('*')
				              ->where('mrd_Category','=',$call_from)
				              ->get();
           return $associate_dnis_desc;	
		}
        else
		{
			$associate_dnis_desc = $this->mdm_remapdnis->select('*')
				                        ->get();
           return $associate_dnis_desc;	
		}
	
		}
		
		public function ScriptDetailsFun($bucketId,$productCode)
		{
		 
		  $lms_scripts  = new lms_scripts;
		  $ScriptDetailsRes = $lms_scripts->select('*')
				              ->where('ls_BucketId','=',$bucketId)
							  ->where('ls_ProductCode','=',$productCode)
				              ->orderBy('ls_ScriptId', 'desc')->first();
           return $ScriptDetailsRes;	
		}
		
		public function ScriptQuestionFun($bucketId,$ScreenId)
		{
		 
		  $lms_scripts  = new lms_scripts;
		  $ScriptDetailsRes = $lms_scripts->select('*')
				              ->where('ls_BucketId','=',$bucketId)
							  ->where('ls_ScreenId','=',$ScreenId)
							  ->orderBy('ls_ScriptId', 'desc')->first();
           return $ScriptDetailsRes['ls_ScriptProduct'];	
		}
		
}
