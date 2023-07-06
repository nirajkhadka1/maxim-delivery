<?php

namespace App\Http\Controllers;

use App\Repositories\contracts\DateDeliveryRepoInterface;
use App\Repositories\contracts\LocationRepoInterface;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $dateDeliveryRepoInterface, $locationRepoInterface;
    function __construct(DateDeliveryRepoInterface $dateDeliveryRepoInterface,LocationRepoInterface $locationRepoInterface)
    {
        $this->dateDeliveryRepoInterface = $dateDeliveryRepoInterface;
        $this->locationRepoInterface = $locationRepoInterface;
    }
    public function showForm(){
        $dates = $this->dateDeliveryRepoInterface->getAvailableDate(['status'=> 'on'])->pluck('dates');
        $geolocationDetails = $this->locationRepoInterface->getAll();
        // dd($geolocationDetails);
        return view('client.form',['geolocation_details' => $geolocationDetails])->with('available_date',$dates);
    }
}
