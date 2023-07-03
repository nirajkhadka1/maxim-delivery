<?php

namespace App\Http\Controllers;

use App\Repositories\contracts\DateDeliveryRepoInterface;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $dateDeliveryRepoInterface;
    function __construct(DateDeliveryRepoInterface $dateDeliveryRepoInterface)
    {
        $this->dateDeliveryRepoInterface = $dateDeliveryRepoInterface;
    }
    public function showForm(){
        $dates = $this->dateDeliveryRepoInterface->getAvailableDate(['status'=> 'on'])->pluck('dates');
        return view('client.form')->with('available_date',$dates);
    }
}
