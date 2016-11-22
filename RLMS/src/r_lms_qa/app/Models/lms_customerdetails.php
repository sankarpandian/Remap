<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class lms_customerdetails extends Model
{
	 protected $primaryKey = 'lcd_CustomerId';
	 protected $table = 'lms_customerdetails';
	 
	 
      protected $fillable = ['lcd_FirstName', 'lcd_LastName', 'lcd_Zipcode', 'lcd_HomePhone'];
	/*  public function create($data)
	  {
		  //
		  print_r($data);
	  } */
}
