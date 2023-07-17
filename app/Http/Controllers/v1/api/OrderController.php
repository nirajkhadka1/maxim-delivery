<?php

namespace App\Http\Controllers\v1\api;

use App\Http\Controllers\Controller;
use App\Repositories\contracts\OrdersRepoInterface;
use App\Traits\ServiceResponser;
use Illuminate\Http\Request;
use Throwable;

class OrderController extends Controller
{
    use ServiceResponser;

    private $request;
    private $ordersRepoInterface;
    public function __construct(Request $request,OrdersRepoInterface $ordersRepoInterface)
    {
        $this->request = $request;
        $this->ordersRepoInterface = $ordersRepoInterface;
    }

    public function updateOrder($id):object{
        $this->validate($this->request,[
            'delivery_date' => 'nullable|date_format:Y-m-d'
        ]);
        try{
            $this->ordersRepoInterface->update($this->request->all(),['id'=> $id]);
            return $this->successReponse("Successfully updated order $id");
        }
        catch(Throwable $th){
            throw $th;
        }
    }
}
