<?php

namespace App\Repositories\Admin\Script;
use Illuminate\Database\Eloquent\Model;
use App\Models\lms_screens;
use App\Models\lms_products;
class ScriptRepository extends Model
{
	public function __construct(lms_screens $lms_screens)
	{
	  $this->lms_screens = $lms_screens;	
	}
	
  public function GetListScreen()
  {
  	$resultScreen = $this->lms_screens->select("*")
						 ->get();
	  
	return $resultScreen;
	
  }
  
   public function GetListProducts()
  {
	   $lms_products = new lms_products;
  	$resultProduct = $lms_products->select("lp_ProductCode","lp_ProductName")->get();
	  
	return $resultProduct;
	
  }
	
		
}
