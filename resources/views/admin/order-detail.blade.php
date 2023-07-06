@extends('layouts.header')

@section('load-content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="stylesheet" href="{{asset('css/style.css')}}"/> 
<link rel="stylesheet" href="{{asset('css/client-form.css')}}"/> 

@endsection

<body>
    @extends('layouts.navigation')
    @extends('layouts.main-content')

    @section('main-content')
    <h1 class="mt-3 mb-5">
        Order Detail of {{{$order_detail->school->name}}}
    </h1>
            <section class="form">
                <form class="form" id="client-form">
                    <fieldset class="form_sections">
                        <div class="label">
                            <label>School's Name</label>
                            <input type="text" name="name" id="" placeholder="Enter School's Name"
                                name="name" readonly value="{{$order_detail->school->name}}" >
                        </div>
                        <div class="label">
                            <label>School's Complete Address</label>
                            <input type="text" name="address" id="" placeholder="Enter School's Address"
                                name="address" value="{{$order_detail->school->address}}" readonly>
                        </div>

                    </fieldset>
                    <fieldset class="form_sections">
                        <div class="label">
                            <label>School's Email Address</label>
                            <input type="text" name="primary_email_address" 
                                placeholder="Enter School's Email Address" name="primary_email_address" value="{{$order_detail->school->primary_email_address}}" readonly>
                        </div>
                        <div class="label">
                            <label>School's Phone Number</label>
                            <input type="text" name="secondary_contact_number" id=""
                                placeholder="Enter School's Address" name="secondary_contact_number" value="{{$order_detail->school->secondary_contact_number}}" readonly>
                        </div>
                    </fieldset>
                    <fieldset class="form_sections">
                        <div class="label">
                            <label>Main Contact Mobile Number</label>
                            <input type="text" name="primary_contact_number" id=""
                                placeholder="Enter Contact Person's Mobile Number" name="primary_contact_number"
                                value="{{$order_detail->school->primary_contact_number}}" readonly>
                        </div>
                        <div class="label">
                            <label>Alternative Email Address</label>
                            <input type="text" name="secondary_email_address" id=""
                                placeholder="Enter an Alternative Email Address" name="secondary_email_address" value="{{$order_detail->school->secondary_email_address}}" readonly>
                        </div>
                    </fieldset>
                    <fieldset class="form_sections">
                        <div class="label">
                            <label>Delivery Date</label>
                            <input type="text" name="delivery_date" 
                                name="delivery_date" value="{{\Carbon\Carbon::createFromFormat('Y-m-d h:m:s',$order_detail->delivery_date)->format('Y-m-d')}}" readonly>

                        </div>
                        {{-- <div class="label">
                        <label>Delivery Time Range</label>
                        <select class="select" name="range">
                            <option value="" disabled selected>Select Time Range</option>
                            <option value="morning">Morning (9:00 AM - 12:00 PM)</option>
                            <option value="afternoon">Afternoon (12:00 PM - 3:00 PM)</option>
                            <option value="evening">Evening (3:00 PM - 6:00 PM)</option>
                            <option value="night">Night (6:00 PM - 9:00 PM)</option>
                        </select>
                    </div> --}}
                        <div class="label">
                            <label>Notification Medium</label>
                            <input type="text" value="{{$order_detail->notification_medium}}" readonly/>
                            
                        </div>
                    </fieldset>
                    <fieldset class="form_sections">
                        <div class="label">
                            <label>Postal Code</label>
                            <input type="text" value="{{$order_detail->postal_code}}" readonly/>
                            
                        </div>
                        <div class="label">
                            <label>GeoLocation</label>
                            <input type="text" value="{{$order_detail->geolocation}}" id="geolocation" name="geolocation" readonly>
                        </div>
                    </fieldset>

                </form>
            </section>
    @endsection

    @extends('layouts.include-scripts')
    @include('layouts.footer')