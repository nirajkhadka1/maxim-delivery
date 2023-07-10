<?php

namespace App\Console\Commands;

use App\Jobs\NotificationJob;
use App\Models\Order;
use App\Repositories\contracts\OrdersRepoInterface;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class NotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notification-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    protected $orderRepoInterface;
    public function __construct(OrdersRepoInterface $orderRepoInterface)
    {
        parent::__construct();
        $this->orderRepoInterface = $orderRepoInterface;
        
    }
    public function handle()
    {
        try{
            Order::chunk(100,function($orders){
               foreach($orders as $order){
                $currentDate = Carbon::now();
                $deliveryDate = Carbon::parse($order->delivery_date);
                if($currentDate->addDay(4)->isSameDay($deliveryDate)){
                    $recipients = $order->school->secondary_contact_number ? [$order->school->primary_contact_number,$order->school->secondary_contact_number] : [$order->school->primary_contact_number];
                    dispatch(new NotificationJob($recipients,'Test'));
                } 
               }
            });
            Log::info("Notification send successfully");

        }
        catch(Exception $ex){
            dd($ex);
        }
    }
}
