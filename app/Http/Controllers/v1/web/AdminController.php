<?php

namespace App\Http\Controllers\v1\web;

use App\Http\Controllers\Controller;
use App\Repositories\contracts\DateDeliveryRepoInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $dateDeliveryRepoInterface;
    function __construct(DateDeliveryRepoInterface $dateDeliveryRepoInterface)
    {
        $this->dateDeliveryRepoInterface = $dateDeliveryRepoInterface;
    }


    public function addAvailableDates(){
        $dates = $this->dateDeliveryRepoInterface->getAvailableDate(['status'=> 'on'])->pluck('dates');
        $disable_dates = $this->dateDeliveryRepoInterface->getAvailableDate(['status'=> 'off'])->pluck('dates');
        return view('admin.add-available-date')->with('available_date',$dates)->with('disable_date',$disable_dates);
    }

    public function viewAvailableDates(){
        $availableDates = $this->dateDeliveryRepoInterface->getAllAvailableDates();
        return view('admin.view-available-dates',['available_dates'=> $availableDates]);
    }

    public function editAvailableDates(){
        $dates = $this->dateDeliveryRepoInterface->getAvailableDate(['status'=> 'on'])->pluck('dates');
        $disable_dates = $this->dateDeliveryRepoInterface->getAvailableDate(['status'=> 'off'])->pluck('dates');
        return view('admin.disable-date')->with('available_date',$dates)->with('disable_date',$disable_dates);
    }
    
    public function editSingleDateForm($id){
        $date_details = $this->dateDeliveryRepoInterface->findDate(['id'=>$id]);
        return view('admin.edit-single',['date_details'=> $date_details]);
    }

}
