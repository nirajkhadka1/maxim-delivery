<?php

namespace App\Http\Controllers\v1\web;

use App\Http\Controllers\Controller;
use App\Repositories\contracts\DateDeliveryRepoInterface;
use App\Repositories\contracts\OrdersRepoInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    private $dateDeliveryRepoInterface,$orderRepoInterface;
    function __construct(DateDeliveryRepoInterface $dateDeliveryRepoInterface,OrdersRepoInterface $orderRepoInterface)
    {
        $this->dateDeliveryRepoInterface = $dateDeliveryRepoInterface;
        $this->orderRepoInterface = $orderRepoInterface;
    }


    public function modifyDates(){
        try{
            $dates = $this->dateDeliveryRepoInterface->getAvailableDate(['status'=> 'on'])->pluck('dates');
            $disable_dates = $this->dateDeliveryRepoInterface->getAvailableDate(['status'=> 'off'])->pluck('dates');
            return view('pages.admin.modify-dates')->with('available_date',$dates)->with('disable_date',$disable_dates);
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
        $available_dates = $this->dateDeliveryRepoInterface->getAvailableDate(['status'=>'on'])->pluck('dates');
        $disable_dates = $this->dateDeliveryRepoInterface->getAvailableDate(['status'=>'off'])->pluck('dates');
        return view('pages.admin.order-detail',['order_detail'=> $order_detail,'available_dates'=> $available_dates,'disable_dates'=>$disable_dates]);
    }

}
