@extends('layouts.header')

@section('load-content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('css/date-time-picker.css') }}" />
@endsection

<body style="background: lightgray">
    <div class="container d-flex justify-content-center">
        <div class="card mt-5" style="width:40%;">
            <form class="card-body my-3" id="placeOrderForm">
                <div class="form-group">
                    <label for="exampleFormControlInput1">School Name <span class="text-danger">*</span></label>
                    <input type="text" id="fromDate" name="name" class="form-control"
                        placeholder="eg: SRGN Australian Education">
                </div>
                <div class="form-group mt-4">
                    <label for="exampleFormControlInput1">Primary Contact Number <span
                            class="text-danger">*</span></label>
                    <input type="text" id="fromDate" name="primary_contact_number" class="form-control"
                        placeholder="eg: +61XXXXXXXXXX">
                </div>
                <div class="form-group mt-4">
                    <label for="exampleFormControlInput1">Secondary Contact Number</label>
                    <input type="text" id="fromDate" name="secodary_contact_number" class="form-control"
                        placeholder="eg: +61XXXXXXXXXX">
                </div>
                <div class="form-group mt-4">
                    <label for="exampleFormControlInput1">Primary Email Address <span
                            class="text-danger">*</span></label>
                    <input type="text" id="fromDate" name="primary_email_address" class="form-control"
                        placeholder="eg: johndoe@gmail.com">
                </div>
                <div class="form-group mt-4">
                    <label for="exampleFormControlInput1">Secondary Email Address</label>
                    <input type="text" id="fromDate" name="secondary_email_address" class="form-control"
                        placeholder="eg: johndoe@gmail.com">
                </div>
                <div class="form-group mt-4">
                    <label for="exampleFormControlInput1">School Address </label>
                    <input type="text" id="fromDate" name="address" class="form-control"
                        placeholder="eg: Palais Trautson Museumstraße 7 1070 Wien">
                </div>
                <div class="form-group mt-4">
                    <label for="exampleFormControlInput1">Shipping Address <span class="text-danger">*</span></label>
                    <input type="text" id="fromDate" name="shipping address" class="form-control"
                        placeholder="eg: Palais Trautson Museumstraße 7 1070 Wien">
                </div>
                <div class="form-group mt-4">
                    <label for="exampleFormControlInput1">Delivery Date <span class="text-danger">*</span></label>
                    <input type="text" class="form-control datepicker" id="datetimepicker"
                        name="available_deliver_date" id="toDate" placeholder="Select" readonly>
                </div>

                <div class="form-group mt-2">
                    <label for="exampleFormControlTextarea1">Remarks</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="remarks" rows="3"></textarea>
                </div>
                <div class="loader" style="display: none"></div>
                <div class="mt-4 d-flex justify-content-center">
                    <button type="button" id="placeOrderBtn" class="btn btn-danger">Place Order</button>
                </div>
            </form>
        </div>
    </div>
    @extends('layouts.include-scripts');
    @section('load-scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
        <script src="{{ asset('js/helpers.js') }}"></script>
        <script>
            var availableDates = {!! json_encode($available_date) !!};

            function enableSelectedDatesAndDisableWeekends(date) {
                var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);
                return [availableDates.indexOf(formattedDate) > -1 && date.getDay() !== 0 && date.getDay() !== 6];
            }


            $(document).ready(function() {
                $('#datetimepicker').datepicker({
                    dateFormat: "yy-mm-dd",
                    beforeShowDay: enableSelectedDatesAndDisableWeekends
                });

                $("#placeOrderBtn").click(function() {
                    console.log('clicked')
                    let formData = $('#placeOrderForm').serializeArray();
                    let payload = convertFormDataToObject(formData);
                    let requiredFields = [
                        'name',
                        'primary_contact_number',
                        'primary_email_address',
                        'shipping_address',
                        'delivery_date'
                    ]
                    let validationMsg = validateReqiredFields(payload, requiredFields);
                    if (validationMsg) {
                        alert(validationMsg);
                        return;
                    }
                    let isValidPrimaryContactNumber = isValidPhoneNumber(payload?.primary_contact_number);
                    if (!isValidPhoneNumber) {
                        alert("Primary Contact Number is invalid !!");
                    }
                    if (payload?.secondary_contact_number) {
                        let isValidSecondaryContactNumber = isValidPhoneNumber(payload
                            ?.secondary_contact_number);
                        if (!isValidSecondaryContactNumber) {
                            alert("Secondary Contact Number is invalid !!");
                        }
                    }

                    let isValidPrimaryEmailAddress = isValidEmailAddress(payload?.primary_email_address);
                    if (!isValidPrimaryEmailAddress) {
                        alert('Primary Email Address is invalid');
                    }




                });

                function validateReqiredFields(formData, requiredFields) {
                    let errorMsg = "";
                    for (let i = 0; i < requiredFields?.length; i++) {
                        console.log(formData[requiredFields[i]]);
                        if (!formData[requiredFields[i]]) {
                            errorMsg = "Please Fill Up the fields with * ";
                            break;
                        }
                    }
                    console.log(errorMsg);
                    return errorMsg;
                }

                function isValidPhoneNumber(phoneNumber) {
                    var regex = /^\d{10}$/;
                    return regex.test(phoneNumber);
                }

                function isValidEmailAddress(email) {
                    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    return regex.test(email);
                }

            });
        </script>
    @endsection

    @extends('layouts.footer')
