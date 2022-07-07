<?php 

namespace App\Services;
 
use Illuminate\Http\Request;
 
class BaseService
{


	 public function list(Request $request, $model)
    {
        $result = $model::all();

        if($request->q){
            $result = $result->where('name', 'LIKE', "%{$request->q}%");
        }

        if($request->paginated == 'true') {
            $result = $result->paginate(20);
        }else {
            $result = $result->get();
        }

        return $result;
    }

}