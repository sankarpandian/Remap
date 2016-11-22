<?php

namespace App\Repositories\Admin\Screen;
use Illuminate\Database\Eloquent\Model;
use App\Models\lms_buckets;
class ScreenRepository extends Model
{
	public function __construct(lms_buckets $lms_buckets)
	{
		$this->lms_buckets     = $lms_buckets;
		
	}
	
  public function GetListBuckets()
  {
  $ResultBuckets = $this->lms_buckets
  ->select('*')
  ->get();	
	  
  return $ResultBuckets;
	
  }
	
		
}
