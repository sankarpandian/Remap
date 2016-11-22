<?php

namespace App\Http\Controllers\Ajax_Process;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\lms_callfroms;
use App\Repositories\CallerScreenRepository;
class CommonAjaxProcessController extends Controller
{
    //
	public function __construct(lms_callfroms $lms_callfroms,CallerScreenRepository $CallerScreenRepository)
	{
	$this->lms_callfroms          = $lms_callfroms;	
    $this->CallerScreenRepository = $CallerScreenRepository;	
	}
	public function ListOfAllDataSelectFun()
	{
		//print_r($_REQUEST);
		$data = array();
		switch($_REQUEST['callFromData'])
		{
			case 'lld_CallFromId':
			$result = $this->lms_callfroms->select("lcf_CallFromId","lcf_CallFromCode","lcf_CallFromName")->get();
			for($i=0;$i<count($result);$i++)
			{
				$data[$i]['id']    = $result[$i]['lcf_CallFromId'];
				$data[$i]['value'] = $result[$i]['lcf_CallFromName'];
				$data[$i]['code']  = $result[$i]['lcf_CallFromCode'];
			}
			return json_encode($data);
			break;
			case 'lld_CallTypeId':
			$result = $this->CallerScreenRepository->lms_hdtypes_fun();
			for($i=0;$i<count($result);$i++)
			{
				$data[$i]['id']    = $result[$i]['lht_HdTypeId'];
				$data[$i]['value'] = $result[$i]['lht_HdType'];
			}
			return json_encode($data);
			break;
			case 'dnis_info':
			$result = $this->CallerScreenRepository->lms_customerhometypes_fun();
			return $result;
			case 'lld_CallFromId':
			$result = $this->CallerScreenRepository->lms_customerhometypes_fun();
			for($i=0;$i<count($result);$i++)
			{
				$data[$i]['id']    = $result[$i]['lch_HomeTypeId'];
				$data[$i]['value'] = $result[$i]['lch_HomeTypeName'];
			}
			return json_encode($data);
			break;
			case 'lch_HomeTypeId':
			$result = $this->CallerScreenRepository->lms_customerhometypes_fun();
			for($i=0;$i<count($result);$i++)
			{
				$data[$i]['id']    = $result[$i]['lch_HomeTypeId'];
				$data[$i]['value'] = $result[$i]['lch_HomeTypeName'];
			}
			return json_encode($data);
			break;
			break;
		}
	}
}