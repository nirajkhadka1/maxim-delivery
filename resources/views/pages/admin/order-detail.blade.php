@extends('layouts.main-admin')

@section('load-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/jquery-ui-multidatespicker@1.6.6/jquery-ui.multidatespicker.css">
    <link rel="stylesheet" href="{{ asset('css/client-form.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endsection

@php
    $delivery_date = $order_detail->delivery_date;
@endphp

@section('main-content')
    <h1 class="mt-3 mb-5">
        Order Detail of {{ $order_detail->school->name }}
    </h1>
    <section class="form">
        <form class="form" id="client-form">
            <fieldset class="form_sections">
                <div class="label">
                    <label>School's Name</label>
                    <input type="text" name="name" id="" placeholder="Enter School's Name" name="name"
                        readonly value="{{ $order_detail->school->name }}">
                </div>
                <div class="label">
                    <label>School's Complete Address</label>
                    <input type="text" name="address" id="" placeholder="Enter School's Address" name="address"
                        value="{{ $order_detail->school->address }}" readonly>
                </div>

            </fieldset>
            <fieldset class="form_sections">
                <div class="label">
                    <label>School's Email Address</label>
                    <input type="text" name="primary_email_address" placeholder="Enter School's Email Address"
                        name="primary_email_address" value="{{ $order_detail->school->primary_email_address }}" readonly>
                </div>
                <div class="label">
                    <label>School's Phone Number</label>
                    <input type="text" name="secondary_contact_number" id=""
                        placeholder="Enter School's Address" name="secondary_contact_number"
                        value="{{ $order_detail->school->secondary_contact_number }}" readonly>
                </div>
            </fieldset>
            <fieldset class="form_sections">
                <div class="label">
                    <label>Main Contact Mobile Number</label>
                    <input type="text" name="primary_contact_number" id=""
                        placeholder="Enter Contact Person's Mobile Number" name="primary_contact_number"
                        value="{{ $order_detail->school->primary_contact_number }}" readonly>
                </div>
                <div class="label">
                    <label>Alternative Email Address</label>
                    <input type="text" name="secondary_email_address" id=""
                        placeholder="Enter an Alternative Email Address" name="secondary_email_address"
                        value="{{ $order_detail->school->secondary_email_address }}" readonly>
                </div>
            </fieldset>
            <fieldset class="form_sections">
                <div class="label">
                    <label>Delivery Date</label>
                    <input type="text" class="delivery_date" name="delivery_date" id="datetimepicker"
                        placeholder="Select Delivery Date" readonly onfocus="(this.type='date')"
                        value="{{ $order_detail->delivery_date }}">
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
                    <input type="text" value="{{ $order_detail->notification_medium }}" readonly />

                </div>
            </fieldset>
            <fieldset class="form_sections">
                <div class="label">
                    <label>Postal Code</label>
                    <input type="text" value="{{ $order_detail->postal_code }}" readonly />

                </div>
                <div class="label">
                    <label>GeoLocation</label>
                    <input type="text" value="{{ $order_detail->geolocation }}" id="geolocation" name="geolocation"
                        readonly>
                </div>
            </fieldset>
            <div class="form_buttons">
                <button class="button btn_Submit" id="modify_date">
                    Modify Date
                </button>
            </div>
        </form>
    </section>
@endsection

@section('include-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-ui-multidatespicker@1.6.6/jquery-ui.multidatespicker.js"></script>
    <script>
        var availableDates = {!! json_encode($available_dates) !!};

        $(document).ready(function() {
            $('#datetimepicker').datepicker({
                dateFormat: "yy-mm-dd",
                beforeShowDay: enableSelectedDatesAndDisableWeekends,
                minDate: 0,
            });

            $('#modify_date').click(function(e) {
                e.preventDefault();
                $('.overlay').css('visibility','visible');
                let deliveryDate = $('.delivery_date').val();
                let currentDeliveryDate = "{{ $delivery_date }}";
                let id = {{ $order_detail->id }}
                if (deliveryDate === currentDeliveryDate) {
                    alert('No changes made !!!');
                    return;
                }
                if (availableDates?.includes(deliveryDate)) {
                    $.ajax({
                        url: `{{ url('/api/admin/orders/${id}') }}`,
                        method: 'PUT',
                        data: {
                            delivery_date: deliveryDate
                        },
                        success: function(response) {
                            $('.overlay').css('visibility','hidden');
                            alert(response?.response);
                        },
                        error: function(xhr, status, error) {
                            $('.overlay').css('visibility','hidden');
                            alert(xhr?.xhr?.responseJSON?.response ?? 'Something went wrong');
                        }
                    })
                }
            });

            function enableSelectedDatesAndDisableWeekends(date) {
                var day = date.getDay();
                var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);
                var isAvailable = availableDates.includes(formattedDate);
                var cssClass = isAvailable && 'available';
                var tooltip = isAvailable ? 'Available' : 'Unavailable';
                if (day === 0 || day === 6) {
                    cssClass += ' weekend';
                    return [false, cssClass, tooltip];
                }
                return [availableDates.indexOf(formattedDate) > -1 && date.getDay() !== 0 && date.getDay() !== 6,
                    cssClass,
                    tooltip
                ];
            }
        });
    </script>
@endsection
