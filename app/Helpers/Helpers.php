<?php

namespace App\Helpers;

use App\Models\Order;
use Carbon\Carbon;

trait Helpers
{
//     $orders = SELECT COUNT(delivery_date) as deliveries, delivery_date FROM `orders` WHERE geolocation='Geelong Melb' AND delivery_date >= '2019-11-16' AND delivery_date <= '2019-11-20' GROUP BY delivery_date;
// $days   = array( .., ... );
// $limit  = 5;


// $days = array_filter( $days, function($day) use ($orders, $limit) {
//    $order = array_search( $day, array_column( $orders, 'delivery_date' ) );
//    $count = 0;

//    if ( $order !== false ) {
//     $count = $orders[$order]['deliveries'];
//    }

//    return $count < $limit;
// } ); 

    public function getAvailableDays($location)
    {
        switch ($location->config) {
            case "daily":
                return $this->dailyRegularity($location->start_date);
            case "weekly":
                return $this->weeklyRegularity($location->start_date);
            case "monthly":
                return $this->monthlyRegularity($location->start_date);
            case "custom":
                return $this->customRegularity($location->custom_dates);
            default :   
                return [];
        }
    }

    public function dailyRegularity($date)
    {   
        $startDate = $date < Carbon::now() ? Carbon::now() : Carbon::parse($date);
        $currentDate = Carbon::parse($startDate);
        $endDate = $startDate->addMonths(3);
        $enabledDate = [];

        while ($currentDate <= $endDate) {
            $enabledDate[] = $currentDate->format('Y-m-d');
            $currentDate->addDay();
        }

        return ['start_date'=> $date,'end_date'=> $endDate->format('Y-m-d'),'enabled_dates'=> $enabledDate];

    }

    public function weeklyRegularity($date)
    {
        $carbonDate = Carbon::parse($date);
        $desiredDayOfWeek = $carbonDate->dayOfWeek;
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addMonths(6);

        $enabledDates = [];
        for ($startDate; $startDate->lte($endDate); $startDate->addDay()) {
            if ($startDate->dayOfWeek == $desiredDayOfWeek) {
                $enabledDates[] = $startDate->format('Y-m-d');
            }
        }
        return ['start_date'=> $date,'end_date'=> $endDate->format('Y-m-d'),'enabled_dates'=> $enabledDates];
        
    }

    public function monthlyRegularity($date){
        $carbonDate = Carbon::parse($date);
        $day = $carbonDate->format('d');
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addMonths(6);
        $enabledDates = [];
        for($startDate;$startDate->lte($endDate);$startDate->addDay()){
            if($startDate->format('d') == $day){
                $enabledDates[] = $startDate->format('Y-m-d');
            }
        }
        return ['start_date'=> $date,'end_date'=> $endDate->format('Y-m-d'),'enabled_dates'=> $enabledDates];
    }

    public function customRegularity($dates)
    {
        $available_dates = explode(", ", $dates);
        $sorted_dates = collect($available_dates)->sort(function($date){
            return strtotime($date);
        })->toArray();

        return ['start_date'=> $sorted_dates[0],'end_date'=> $sorted_dates[1],'enabled_dates'=> $available_dates];
    }

}
