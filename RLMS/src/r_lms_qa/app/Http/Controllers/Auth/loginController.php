<?php

namespace App\Http\Controllers\Auth;
use App\Models\remap_users;
use App\Models\remap_company;
use App\Models\remap_dashboardrelations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\home;
use Illuminate\support\Facades\session;
use GuzzleHttp\Client;
use App\Repositories\CalendarRepository;
use App\Models\lms_customerdetails;
use App\Models\lms_calldetails;
use App\Models\lms_customerslots;
use App\Models\lms_callstatus;
use App\Models\lms_products;

class loginController extends Controller
{

    public function __construct(remap_users $remap_users,remap_company $remap_company,home $home,CalendarRepository $CalendarRepository,lms_customerdetails $lms_customerdetails)
	{
		$this->remap_users = $remap_users;
		$this->remap_company_model=$remap_company;
		$this->home= $home;
		$this->remap_dashboardrelations=remap_dashboardrelations::all();
		$this->lms_customerdetails= $lms_customerdetails;
		$this->CalendarRepository=$CalendarRepository;
	}
 public function login() {
        return view('Auth\login', array('title' => 'Welcome'));
    }

  public function authenticate_user(Request $Requested_data)
  {
 //  echo 'hihihihihi';exit;
  	    $login_check = new remap_users();
	 
        $Login_data=array("login_name"=>$Requested_data['username'],"password"=>$Requested_data['password']);
   //  print_r($Login_data);
    // exit;
     /*   $flights = remap_users::where('usrs_username',$Login_data['login_name'])
       				  ->orWhere('usrs_email', '=',$Login_data['login_name'] )
					  ->where('usrs_status', '=','1')
					  ->get();

		print_r($flights);
		exit(); */
		$return_user_details = $login_check->IsvalidUser($Login_data);


		if($return_user_details['result']=='true')
		{
			//print_r($this->remap_company_model);

			$user_company_authentication_method=$this->remap_company_model->user_company_authentication_url($return_user_details,$Login_data);
			

			
			if($user_company_authentication_method['result']=='true')
			{

               
				$list_dashborad_data = $this->home->get_dashboard_menu($return_user_details['ru_UserId']);
				$Login_data['usrs_userid']=$return_user_details['ru_UserId'];
				$Login_data['usrs_company_id']=$return_user_details['ru_CompanyId'];

                session::put($Login_data);
				
				
				/*return view('cust_lookup.gridview', array('title' => 'Home1', 'description' => $user_company_authentication_method['result_message'], 'page' => 'Home','get_dashborad_data' => $list_dashborad_data)); */
				$cust_det=lms_customerdetails::all();
     // echo $cust_det;
     $call_det=lms_calldetails::all();
     //echo $call_det;
     $cust_slot=lms_customerslots::all();
     $cust_status=lms_callstatus::all();
     $cust_products=lms_products::all();

     //print_r($cust_status);
     //echo $cust_slot;
     $cust_lookup_res= $this->lms_customerdetails
     			 ->join('lms_calldetails', 'lms_calldetails.lld_CustomerId', '=', 'lms_customerdetails.lcd_CustomerId')
     			 ->join('lms_customerslots', 'lms_customerslots.lcs_CustomerId', '=', 'lms_customerdetails.lcd_CustomerId')
     			 ->join('lms_products', 'lms_calldetails.lld_ProductCode', '=', 'lms_products.lp_ProductCode')
     			 ->join('lms_callstatus', 'lms_calldetails.lld_CallStatusId', '=', 'lms_callstatus.lls_CallStatusId')
     			 ->join('lms_branches', 'lms_branches.lb_TerritoryId', '=', 'lms_customerdetails.lcd_Territory')
     			 ->get();

    //return view('gridview')->with(array("cust"  => $cust));	
       $user_id = session('usrs_userid');
		$agent_access        = $this->home->get_dashboard_menu($user_id);
		$existing_calendar_data     = $this->CalendarRepository->lms_existing_calendar_fun();
		return view('cust_lookup.gridview',array('title' => 'Customer Lookup', 'description' =>'Customer Lookup' , 'page' => 'New Calendar','get_dashborad_data' => $agent_access,'cust_lookup'=>$cust_lookup_res,'existing_calendar_data'=>$existing_calendar_data));
				
				
				
				
			}
			else
			{
				//return redirect()->intended('/');
				//return redirect('/');
				//return redirect()->route('login');
				//return redirect()->back('login', ['title' => 'Login', 'description' => $user_company_authentication_method['result_message'], 'page' => 'login']);
				$error_message=array('title' => 'Login', 'description' => $user_company_authentication_method['result_message'], 'page' => 'login');
				//return redirect()->route('Auth.login', [$error_message]);
				return view('Auth\login',$error_message);
				//return view('Auth\login', );


			}
            
		}else
		{
           
             //return redirect()->route('login');
             //return redirect()->back('login', ['title' => 'Login', 'description' =>'User does not exist', 'page' => 'login']);
			//$error_message=array('title' => 'Login', 'description' => 'User does not exist', 'page' => 'login');
			//return redirect('/',[$error_message]);
			//return redirect()->route('Auth.login', [$error_message]);
			return view('Auth\login', array('title' => 'Login', 'description' => 'User does not exist', 'page' => 'login')); 
			//return redirect()->intended('/');
		}

	

	
		
		
  }
  
  function logout()
  {
	 // Session::flush(); 
	   return view('auth.login');
  }

}
