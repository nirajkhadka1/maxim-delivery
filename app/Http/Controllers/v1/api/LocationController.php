<?php 

namespace App\Http\Controllers\v1\api;

use App\Http\Controllers\Controller;
use App\Repositories\contracts\LocationRepoInterface;
use App\Traits\ServiceResponser;
use Illuminate\Http\Request;
use Throwable;

class LocationController extends Controller{
    use ServiceResponser;
    private $request,$locationRepoInterface;
    function __construct(Request $request,LocationRepoInterface $locationRepoInterface)
    {
        $this->request = $request;
        $this->locationRepoInterface = $locationRepoInterface;
    }

    public function storeLocation(){
        try{
            $this->locationRepoInterface->insert($this->request->all());
            return $this->successReponse('Successfully Inserted');
        }
        catch(Throwable $th){
            throw $th;
        }
    }

    public function get(){
        
    }

}