<?php

namespace App\Http\Controllers\v1\web;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Repositories\contracts\DateDeliveryRepoInterface;
use App\Repositories\contracts\LocationRepoInterface;
use App\Repositories\contracts\PostalCodeRepoInterface;

class ClientController extends Controller
{
    use Helpers;
    private $dateDeliveryRepoInterface, $locationRepoInterface,$postalCodeRepoInterface;
    function __construct(DateDeliveryRepoInterface $dateDeliveryRepoInterface,LocationRepoInterface $locationRepoInterface,PostalCodeRepoInterface $postalCodeRepoInterface)
    {
        $this->dateDeliveryRepoInterface = $dateDeliveryRepoInterface;
        $this->locationRepoInterface = $locationRepoInterface;
        $this->postalCodeRepoInterface = $postalCodeRepoInterface;
    }
    public function showForm(){
        $postal_codes = $this->postalCodeRepoInterface->getAllWithLocation();
        return view('pages.client.form',['postal_codes' => $postal_codes]);
    }
}
