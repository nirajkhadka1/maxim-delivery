<?php

namespace App\Http\Controllers\v1\api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Order;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PostalCode;

class DatatableController extends Controller
{
    public function search(Request $request)
    {
        $query = Location::query();

        return DataTables::of($query)
            ->toJson();
    }

    public function orderSearch(Request $request){
        $query = Order::with('school')->select('orders.*')->join('schools', 'schools.id', '=', 'orders.school_id');

    // Apply column search
    if ($request->has('search_value')) {
        $searchValue = $request->input('search_value');
        $query->where(function ($q) use ($searchValue) {
              $q->orWhere('schools.name', 'LIKE', '%' . $searchValue . '%');
        });
    }

    // Apply date range filter
    if ($request->has('start_date') && $request->has('end_date')) {
            if($request->input('start_date') && $request->input('end_date')){
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');
                $query->whereBetween('orders.delivery_date', [$startDate, $endDate]);
        }

    }

    // Order the results based on the 'name' column from the 'schools' table
    $query->orderBy('schools.name', 'asc');

    // Get the data and prepare it for DataTables
    $data = $query->get()->map(function ($order) {
        return [
            'id' => $order->id,
            'name' => $order->school->name,
            'primary_contact_number' => $order->school->primary_contact_number,
            'delivery_date' => $order->delivery_date,
            'geolocation' => $order->geolocation,
        ];
    });

    // Process the DataTables request and return the JSON response
    return DataTables::of($data)->toJson();
}
}
