<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class AreaController extends Controller
{
    public function getarea(Request $request)
    {
    	$size = $request->size;
    	if(!is_null($size)){
    		return response()->json([
	    		'code' => 0, 
	    		'data' => DB::table('areas')
	    					->select(['id', 'name'])
							->paginate($size)
			], 200);
    	}else{
    		return response()->json([
	    		'code' => 0, 
	    		'data' => DB::table('areas')
	    					->select(['id', 'name'])
							->paginate()
			], 200);
    	}
    }
}
