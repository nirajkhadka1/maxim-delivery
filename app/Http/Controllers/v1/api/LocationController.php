<?php 

namespace App\Http\Controllers\v1\api;

use App\Http\Controllers\Controller;
use App\Repositories\contracts\LocationRepoInterface;
use App\Repositories\contracts\PostalCodeRepoInterface;
use App\Traits\ServiceResponser;
use App\Helpers\Helpers;
use App\Models\PostalCode;
use App\Repositories\contracts\OrdersRepoInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class LocationController extends Controller{
    use ServiceResponser,Helpers;
    private $request,$locationRepoInterface,$postalCodeRepoInterface,$orderRepoInterface;
    function __construct(Request $request,LocationRepoInterface $locationRepoInterface,PostalCodeRepoInterface $postalCodeRepoInterface,OrdersRepoInterface $orderRepoInterface)
    {
        $this->request = $request;
        $this->locationRepoInterface = $locationRepoInterface;
        $this->postalCodeRepoInterface = $postalCodeRepoInterface;
        $this->orderRepoInterface = $orderRepoInterface;
        
    }

    public function storeLocation(){
        
        try{
            DB::beginTransaction();
            foreach($this->request->all() as $request){
                $location_payload  =[
                    "geolocation" => $request["geolocation"],
                ];
                $location = $this->locationRepoInterface->updateOrInsert(["geolocation"=>$location_payload["geolocation"]],$location_payload);
                $postal_code_payload = [
                    "code" => $request["postal_code"],
                    "suburb" => $request["suburb"],
                    "location_id" =>$location->id
                ];
                $this->postalCodeRepoInterface->insert($postal_code_payload);
               
            }
            DB::commit();
            return $this->successReponse("Successfully Inserted");
        }
        catch(Throwable $th){
            DB::rollBack();
            throw $th;
        }
    }
    
    public function update($id){
        $this->validate($this->request,[
            "config" => "required|in:daily,monthly,weekly,custom"
        ]);
        try{
            if($this->request->config === "custom"){
                $this->request->merge(["custom_dates"=>$this->request->start_date]);
                $this->request->request->remove("start_date");
            }
            $this->locationRepoInterface->update(["id"=>$id],$this->request->all());
            return $this->successReponse("Location info has been updated");
        }
        catch(Throwable $th){
            throw $th;
        }
    }

    public function getEnabledDate($id){
        try{
         $location = $this->locationRepoInterface->getSingle(["id"=>$id]);
         $available_dates = $this->getAvailableDays($location);
         if(count($available_dates) === 0){
            return $this->successReponse([]);
         }
         $disabled_dates = $this->orderRepoInterface->getOrderExceedsDate([
            ["delivery_date",">=",$available_dates["start_date"]],
            ["delivery_date","<=",$available_dates["end_date"]],
            ["geolocation","=",$location->geolocation]
         ],"delivery_date","count(delivery_date) >= $location->order_limit");
         $response = array_values(array_diff($available_dates['enabled_dates'],$disabled_dates));
         return $this->successReponse($response);
        }   
        catch(Throwable $th){
            throw $th;
        }
    }

    
}