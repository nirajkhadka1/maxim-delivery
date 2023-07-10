@extends('layouts.main-client')

@section('load-css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> --}}
    {{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css"> --}}

    {{-- <link rel="stylesheet" href="{{asset('css/style.css')}}"> --}}
    <link rel="stylesheet" href="{{ asset('css/client-form.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('css/date-time-picker.css') }}" /> --}}
@endsection

@section('main-content')
    <main>
        <div class="form-container">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="">
            </div>

            <h1>
                Order Products From Maxim With Ease!
            </h1>
            <div class="paragraph">
                <p>
                    Get ready to experience the convenience of ordering your favorite products from
                    Maxim online! Simply fill in your product requirements, choose a delivery date and time
                    range, and get ready to place your order with ease!
                </p>
            </div>
            <section class="form">
                <form class="form" id="client-form">
                    <fieldset class="form_sections">
                        <div class="label">
                            <label>School's Name</label>
                            <input type="text" name="name" id="" placeholder="Enter School's Name"
                                name="name">
                        </div>
                        <div class="label">
                            <label>School's Complete Address</label>
                            <input type="text" name="address" id="" placeholder="Enter School's Address"
                                name="address">
                        </div>

                    </fieldset>
                    <fieldset class="form_sections">
                        <div class="label">
                            <label>School's Email Address</label>
                            <input type="text" name="primary_email_address" id=""
                                placeholder="Enter School's Email Address" name="primary_email_address">
                        </div>
                        <div class="label">
                            <label>School's Phone Number</label>
                            <input type="text" name="secondary_contact_number" id=""
                                placeholder="Enter School's Address" name="secondary_contact_number">
                        </div>
                    </fieldset>
                    <fieldset class="form_sections">
                        <div class="label">
                            <label>Main Contact Mobile Number</label>
                            <input type="text" name="primary_contact_number" id=""
                                placeholder="Enter Contact Person's Mobile Number" name="primary_contact_number">
                        </div>
                        <div class="label">
                            <label>Alternative Email Address</label>
                            <input type="text" name="secondary_email_address" id=""
                                placeholder="Enter an Alternative Email Address" name="secondary_email_address">
                        </div>
                    </fieldset>
                    <fieldset class="form_sections">
                        <div class="label">
                            <label>Delivery Date</label>
                            <input type="text" name="delivery_date" id="datetimepicker"
                                placeholder="Select Delivery Date" readonly onfocus="(this.type='date')"
                                name="delivery_date">

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
                            <select id="notification" name="notification_medium">
                                <option value="" disabled selected>Select Notification Medium</option>
                                <option value="sms">SMS</option>
                                <option value="email">Email</option>
                                <option value="both">Both</option>
                            </select>
                        </div>
                    </fieldset>
                    <fieldset class="form_sections">
                        <div class="label">
                            <label>Postal Code</label>
                            <select id="postal_code" name="postal_code">
                                <option value="" disabled selected>Select</option>
                                @foreach ($geolocation_details as $geolocation)
                                    <option value="{{ $geolocation->postal_code }}">{{ $geolocation->postal_code }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </fieldset>

                    <fieldset class="form_sections" id="geolocationDiv" style="display: none">
                        <div class="label">
                            <input type="text" id="geolocation" name="geolocation" readonly>
                        </div>
                    </fieldset>

                    <fieldset class="form_sections">

                        <div class="label">
                            <input type="text" id="geolocation" name="geolocation" style="display: none;"
                                placeholder="Enter Postal Code" autocomplete="off" name="geolocation" value=""
                                readonly>
                        </div>
                    </fieldset>

                    <div class="form_buttons">
                        {{-- <button class="button btn_Cancel">
                        Cancel
                    </button> --}}
                        <button class="button btn_Submit" id="place-order">
                            Submit
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>
@endsection


@section('include-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="{{ asset('js/helpers.js') }}"></script>
    <script>
        var availableDates = {!! json_encode($available_date) !!};
        var geolocationDetails = {!! json_encode($geolocation_details) !!};


        function enableSelectedDatesAndDisableWeekends(date) {
            var day = date.getDay();
            var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);

            // Check if the date is available
            var isAvailable = availableDates.includes(formattedDate);

            // Determine the CSS class for the date
            var cssClass = isAvailable && 'available';

            // Determine the tooltip for the date
            var tooltip = isAvailable ? 'Available' : 'Unavailable';

            // Determine if the date should have a custom color

            if (day === 0 || day === 6) {
                cssClass += ' weekend';
                return [false, cssClass, tooltip];
            }
            return [availableDates.indexOf(formattedDate) > -1 && date.getDay() !== 0 && date.getDay() !== 6, cssClass,
                tooltip
            ];
        }


        $(document).ready(function() {

            $('select').click(function() {
                $(this).toggleClass('open');
            });
            $('#notification').select2();
            $('#range').select2();
            $('#postal_code').select2();
            $('#postal_code').on('select2:select', function(e) {
                console.log("HERE");
                var selectedOption = e?.params?.data?.id;
                let typedVal = $("#postal_code").val();
                if (typedVal) {
                    let geoLocation = geolocationDetails?.filter(element => element.postal_code ===
                        selectedOption);
                    $("#geolocationDiv").show();
                    $('#geolocation').val(geoLocation[0]?.geolocation);
                }
            });
            // $('#postal_code').keyup(function() {
            //     console.log("HERE");
            //     clearTimeout(typingTimer);
            //     typingTimer = setTimeout(doneTyping, 2000);
            // });

            // $('#postal_code').keydown(function() {
            //     clearTimeout(typingTimer);
            //     typingTimer = setTimeout(doneTyping, 2000);
            // });

            // function doneTyping() {
            //     let typedVal = $("#postal_code").val();
            //     console.log(geolocationDetails);
            //     let is_valid_post = geolocationDetails?.filter(element => element.postal_code ===
            //         typedVal);
            //     if (is_valid_post?.length === 0) {
            //         alert("Invalid Postal Code");
            //         $("#place-order").attr("disabled", true);
            //     } else {
            //         $("#place-order").attr("disabled", false);
            //         console.log(is_valid_post);
            $('#postalCodes').select2();
            //         // $("#geolocation").val()

            //     }
            // }
            $('#datetimepicker').datepicker({
                dateFormat: "yy-mm-dd",
                beforeShowDay: enableSelectedDatesAndDisableWeekends
            });

            $("#place-order").click(function(e) {
                e.preventDefault();
                let geolocationVal = $('#geolocation').val();
                let formData = $('#client-form').serializeArray();
                formData.push({
                    name: 'geolocation',
                    value: geolocationVal
                });
                let payload = convertFormDataToObject(formData);
                let requiredFields = [
                    'name',
                    'primary_contact_number',
                    'primary_email_address',
                    'address',
                    'delivery_date',
                    'postal_code',
                    'notification_medium',
                    'geolocation',
                ];
                let validationMsg = validateReqiredFields(payload, requiredFields);
                if (validationMsg) {
                    alert(validationMsg);
                    return;
                }
                let isValidPrimaryContactNumber = isValidPhoneNumber(payload
                    ?.primary_contact_number);
                if (!isValidPhoneNumber) {
                    alert("Primary Contact Number is invalid !!");
                    return
                }
                if (payload?.secondary_contact_number) {
                    let isValidSecondaryContactNumber = isValidPhoneNumber(payload
                        ?.secondary_contact_number);
                    if (!isValidSecondaryContactNumber) {
                        alert("Secondary Contact Number is invalid !!");
                        return;
                    }
                    if (payload?.primary_contact_number === payload?.secondary_contact_number) {
                        alert("Main and School contact number cannot be same !!! ");
                        return;
                    }
                }

                let isValidPrimaryEmailAddress = isValidEmailAddress(payload
                    ?.primary_email_address);
                if (!isValidPrimaryEmailAddress) {
                    alert('Primary Email Address is invalid');
                    return;
                }
                if (payload?.secondary_email_address) {
                    let isValidSecondaryEmailAddress = isValidEmailAddress(payload
                        ?.secondary_email_address);
                    if (!isValidSecondaryEmailAddress) {
                        alert("Secondary Email Address is invalid !!");
                        return;
                    }
                    if (payload?.primary_email_address === payload?.secondary_email_address) {
                        alert("School and Alternative Email Address Cannot be same !!");
                        return
                    }
                }

                $.ajax({
                    method: 'POST',
                    url: "{{ url('/api/client_form/submit') }}",
                    data: payload,
                    success: function(response) {
                        console.log(response)
                        alert(response?.response);
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                })
            });

            function validateReqiredFields(formData, requiredFields) {
                let errorMsg = "";
                for (let i = 0; i < requiredFields?.length; i++) {
                    console.log(requiredFields[i]);
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
                const regex = /^(\+?61|0)4[0-9]{8}$/;
                return regex.test(phoneNumber);
            }

            function isValidEmailAddress(email) {
                var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return regex.test(email);
            }

        });
    </script>
@endsection
