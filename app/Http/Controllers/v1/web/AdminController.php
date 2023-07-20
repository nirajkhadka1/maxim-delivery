<?php

namespace App\Http\Controllers\v1\web;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Models\PostalCode;
use App\Repositories\contracts\DateDeliveryRepoInterface;
use App\Repositories\contracts\LocationRepoInterface;
use App\Repositories\contracts\OrdersRepoInterface;
use App\Repositories\contracts\PostalCodeRepoInterface;
use App\Repositories\LocationRepo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdminController extends Controller
{
    use Helpers;
    private $dateDeliveryRepoInterface,$orderRepoInterface,$locationRepoInterface,$postalCodeRepoInterface;
    function __construct(DateDeliveryRepoInterface $dateDeliveryRepoInterface,OrdersRepoInterface $orderRepoInterface,LocationRepoInterface $locationRepoInterface,PostalCodeRepoInterface $postalCodeRepoInterface)
    {
        $this->dateDeliveryRepoInterface = $dateDeliveryRepoInterface;
        $this->orderRepoInterface = $orderRepoInterface;
        $this->locationRepoInterface = $locationRepoInterface;
        $this->postalCodeRepoInterface = $postalCodeRepoInterface;
    }


    public function modifyLocations(){
        try{
            // $dates = $this->dateDeliveryRepoInterface->getAvailableDate(['status'=> 'on'])->pluck('dates');
            // $disable_dates = $this->dateDeliveryRepoInterface->getAvailableDate(['status'=> 'off'])->pluck('dates');
            // return view('pages.admin.location-wise-date')->with('available_date',$dates)->with('disable_date',$disable_dates);
            $locations = $this->locationRepoInterface->getAll();
            return view('pages.admin.location-wise-date',['is_single_page'=>false])->with('geolocations',$locations);
            
        }
        catch(Exception $ex){
            Log::info($ex->getMessage());
        }
    }

    public function dateLists(){
        $availableDates = $this->dateDeliveryRepoInterface->getAllAvailableDates();
        return view('pages.admin.dates',['available_dates'=> $availableDates]);
    }
    
    public function orderView(){
        $order_details = $this->orderRepoInterface->getAll();
        return view('pages.admin.order-lists',compact('order_details'));
    }

    public function viewOrderDetails($id){
        $order_detail = $this->orderRepoInterface->getSingle(['id'=>$id]);
        $location = $this->locationRepoInterface->getSingle(['geolocation'=>$order_detail->geolocation]);
        $available_dates = $this->getAvailableDays($location);
        if(count($available_dates) > 0 ){
            $disabled_dates = $this->orderRepoInterface->getOrderExceedsDate(
                $available_dates["start_date"],
                $available_dates["end_date"],
                $location->geolocation,
                $location->order_limit
            );
            $available_dates = array_values(array_diff($available_dates['enabled_dates'],$disabled_dates));
        }
        return view('pages.admin.order-detail',['order_detail'=> $order_detail,'available_dates'=> $available_dates]);
    }

    // public function locationLists(){
    //     $locations = $this->postalCodeRepoInterface->getAllWithLocation();
    //     dd($locations);
    //     return view
    // }
    public function locationLists()
    {
        return view('pages.admin.locations');
    }

    public function editLocation($id){
        $location_detail = $this->locationRepoInterface->getSingle(['id'=>$id]);
        return view('pages.admin.location-wise-date',['geolocations'=>$location_detail,'is_single_page'=>true]);
    }

}
