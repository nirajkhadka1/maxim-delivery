<?php

namespace App\Http\Controllers\v1\api;

use App\Http\Controllers\Controller;
use App\Models\PostalCode;
use App\Repositories\contracts\DateDeliveryRepoInterface;
use App\Repositories\contracts\HistoryRepoInterface;
use Exception;
use Illuminate\Http\Request;
use App\Traits\ServiceResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class AdminController extends Controller
{
    use ServiceResponser;

    private $request;
    private $dateDeliveryRepoInterface,$historyRepoInterface;

    function __construct(Request $request, DateDeliveryRepoInterface $dateDeliveryRepoInterface,HistoryRepoInterface $historyRepoInterface)
    {
        $this->request = $request;
        $this->dateDeliveryRepoInterface = $dateDeliveryRepoInterface;
        $this->historyRepoInterface = $historyRepoInterface;
    }
    
    public function addDate(){
        $this->validate($this->request,[
            'dates' => 'required|array',
            'status' => 'required|in:on,off'
        ]);
        try{
            $this->dateDeliveryRepoInterface->updateDate($this->request->all());
            return $this->successReponse('Date Added SucessFullly',200);
        }
        catch(Throwable $th){
            return $this->errorResponse($th->getMessage(),$th->getCode());
        }
    }

    public function deleteDate($id){
        $this->validate($this->request,[
            'remarks' => 'required|string|max:255'
        ]);

        try{
            DB::beginTransaction();
            $deliveryDate = $this->dateDeliveryRepoInterface->findDate([ 'id' => $id]);
            if(!$deliveryDate){
                return $this->errorResponse("Date does not Exists !!",400);
            }
            $this->dateDeliveryRepoInterface->deleteDate(['id'=>$id],$this->request->all());
            $this->request->merge(['id'=>$id]);
            $this->historyRepoInterface->storeHistory(
                [
                    'action' => 'Deleted Date',
                    'name' => 'admin',
                    'payload' => json_encode($this->request->all()),
                    'remarks' => $this->request->remarks
                ]
            );
            DB::commit();
            return $this->successReponse("Successfully Deleted !!");
        }
        catch(Throwable $th){
            dd($th);
            DB::rollBack();
            return $this->errorResponse($th->getMessage(),$th->getCode());
        }
    }

    public function updateDate($id){
        $this->validate($this->request,[
            'status' => 'required|required',
            'remarks' => 'required',
        ]);
        $payload = $this->request->all();
        try{
            DB::beginTransaction();
            unset($payload['remarks']);
            $this->dateDeliveryRepoInterface->update(['id'=> $id],$payload);
            $this->historyRepoInterface->storeHistory([
                'action' => 'Edited Date',
                'name' => 'admin',
                'payload' => json_encode($this->request->all()),
                'remarks' => $this->request->remarks
            ]);
            DB::commit();
            return $this->successReponse('Successfully updated !!');
        }
        catch(Throwable $th){
            DB::rollBack();
            throw $th;
        }
    }

    public function login(){
        $credentials = $this->request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            return $this->successReponse("SUCCESS");
        } else {
           dd("Failed");
        }
    }
}
