<?php

namespace App\Http\Controllers\v1\api;

use App\Http\Controllers\Controller;
use App\Repositories\contracts\OrdersRepoInterface;
use App\Repositories\contracts\SchoolRepoInterface;
use App\Traits\ServiceResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class ClientController extends Controller
{
    use ServiceResponser;
    protected $request;
    protected $orderRepoInterface, $schoolRepoInterface;
    function __construct(Request $request, OrdersRepoInterface $orderRepoInterface, SchoolRepoInterface $schoolRepoInterface)
    {
        $this->request = $request;
        $this->orderRepoInterface = $orderRepoInterface;
        $this->schoolRepoInterface = $schoolRepoInterface;
    }
    public function submit()
    {
        $this->validate($this->request, [
            'name' => 'required|max:50',
            'address' => 'required|max:50',
            'primary_email_address' => 'required|email',
            'secondary_email_address' => 'nullable|email',
            'primary_contact_number' => 'required|australian_mobile_number',
            'secondary_contact_number' => 'nullable|australian_mobile_number',
            'delivery_date' => 'required|date_format:Y-m-d',
            'notification_medium' => 'required|in:sms,email,both',
            'postal_code' => 'required',
            'geolocation' => 'required',
        ]);
        

        try {
            DB::beginTransaction();
            $school_payload = [
                'name' => $this->request->name,
                'primary_contact_number' => $this->request->primary_contact_number,
                'secondary_contact_number' => $this->request->secondary_contact_number,
                'primary_email_address' => $this->request->primary_email_address,
                'secondary_email_address' => $this->request->secondary_email_address,
                'address' => $this->request->address
            ];
            $school_id = $this->schoolRepoInterface->insert($school_payload)->id;
            $order_payload = [
                'school_id' => $school_id,
                'address' => $this->request->address,
                'delivery_date' => $this->request->delivery_date,
                'postal_code' => $this->request->postal_code,
                'geolocation' => $this->request->geolocation,
                'notification_medium' => $this->request->notification_medium,
                'remarks' => $this->request->remarks
            ];
            $this->orderRepoInterface->insert($order_payload);
            DB::commit();

            return $this->successReponse("Order Placed Successfully");
        } catch (Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
