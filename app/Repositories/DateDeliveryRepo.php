<?php 

namespace App\Repositories;

use App\Models\DeliveryDate;
use App\Models\History;
use App\Repositories\contracts\DateDeliveryRepoInterface;
use Illuminate\Support\Facades\DB;
use Throwable;

class DateDeliveryRepo implements DateDeliveryRepoInterface{
    public function updateDate(array $payload){
        // dd($payload);
        // try{
            // DB::beginTransaction();
            if($payload['status'] === 'on'){
                // DeliveryDate::query()->update(['status'=>'off']);
                foreach($payload['dates'] as $enabled_date){
                    DeliveryDate::updateOrCreate(['dates'=>$enabled_date],['status'=>'on']);
                }
            }
            else {
                foreach($payload['dates'] as $disable_date){
                    DeliveryDate::where(['dates'=>$disable_date,'status'=>'on'])->update(['status'=>'off']);
                }
            }
            // History::create(
            //     [
            //         'action' =>  'Added Available Dates',
            //         'name' => 'admin',
            //         'payload' => json_encode($payload),
            //         'remarks' => $payload['remarks']
            //     ]
            // );
            // DB::commit();
        // }
        // catch(Throwable $th){
        //     // DB::rollBack();
        //     throw $th;
        // }
    }
    public function getAvailableDate(array $condition)
    {
        return DeliveryDate::where($condition)->orderBy('updated_at','DESC')->get();
    }
    public function getAllAvailableDates()
    {
        return DeliveryDate::orderBy('updated_at','DESC')->get();
    }
    public function findDate(array $condition){
        return History::where($condition)->first();
    }

    public function addDate(array $payload)
    {
        DeliveryDate::create($payload); 
    }

    public function deleteDate(array $condition){
        DeliveryDate::where($condition)->delete();
    }
    public function update(array $condition,array $payload)  {
        DeliveryDate::where($condition)->update($payload);   
    }
}