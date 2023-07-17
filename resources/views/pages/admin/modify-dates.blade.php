@extends('layouts.main-admin')

@section('load-css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" /> 
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/jquery-ui-multidatespicker@1.6.6/jquery-ui.multidatespicker.css">
    <link rel="stylesheet" href="{{asset('css/loader.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/style.css')}}"/>  
    <link rel="stylesheet" href="{{asset('css/client-form.css')}}"/>  

    <link rel="stylesheet" href="{{ asset('css/date-time-picker.css') }}" />
@endsection

@section('main-content')
        <div class="card mt-5">
            <form class="card-body" id="addDateForm">
                <div class="form-group mt-4">
                    <label for="exampleFormControlInput1">Status</label>

                    <div class="mt-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="inlineCheckbox1" name="status"
                                value="on">
                            <label class="form-check-label" for="inlineCheckbox1">enable</label>
                        </div>
                        <div class="form-check form-check-inline ">
                            <input class="form-check-input" type="radio" id="inlineCheckbox2" name="status"
                                value="off">
                            <label class="form-check-label" for="inlineCheckbox2">disable</label>
                        </div>
                    </div>
                </div>
                <div id="rest">

                </div>
            </form>
        </div>
    @endsection

    
    @section('include-scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-ui-multidatespicker@1.6.6/jquery-ui.multidatespicker.js"></script>

        <script src="{{ asset('js/helpers.js') }}"></script>
        <script>
            var availableDates = {!! json_encode($available_date) !!};
            var disableDates = {!! json_encode($disable_date) !!};

            function enableSelectedDatesAndDisableWeekends(date) {
                var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);
                var day = date.getDay();
                var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);

                // Check if the date is available
                var isAvailable = availableDates.includes(formattedDate);

                // Determine the CSS class for the date
                var cssClass = isAvailable ? 'available' : 'unavailable';

                // Determine the tooltip for the date
                var tooltip = isAvailable ? 'Available' : 'Unavailable';

                // Determine if the date should have a custom color

                if (disableDates.includes(formattedDate)) {
                    cssClass += ' disable-color';
                }

                if (day === 0 || day === 6) {
                    cssClass += ' weekend';
                    return [false, cssClass, tooltip];
                }
                return [availableDates.indexOf(formattedDate) > -1 && date.getDay() !== 0 && date.getDay() !== 6, cssClass,
                    tooltip
                ];
            }
            $(document).ready(function() {
                var option = {
                    dateFormat: "yy-mm-dd",
                    minDate: 0,
                }

                $('input[type=radio][name=status]').change(function() {
                    var html = `
                    <div class="form-group mt-4">
                        <label for="exampleFormControlInput1">Select Range</label>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input dates-fields" type="checkbox" id="range">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <label for="exampleFormControlInput1" class="fromDateText">Dates</label>
                        <input type="text" id="fromDate" name="dates" class="form-control datepicker dates-fields" readonly>
                    </div>
                    <div class="form-group mt-4 toDateInput" style="display: none;">
                        <label for="exampleFormControlInput1">To Date</label>
                        <input type="text" class="form-control datepicker dates-fields" id="toDate" readonly>
                    </div>
                    <div class="form-group mt-2">
                        <label for="exampleFormControlTextarea1">Remarks</label>
                        <textarea class="form-control dates-fields" id="exampleFormControlTextarea1" name="remarks"
                            rows="3"></textarea>
                    </div>
                    <div class="loader" style="display: none"></div>
                    <div class="mt-4">
                        <button type="button" id="addDate" class="btn btn-success">Modify Date</button>
                    </div>`;

                    if (this.value == 'on') {
                        $("#rest").html(html);
                        $('.dates-fields').val('');
                        option.beforeShowDay = function(date) {
                            var day = date.getDay();
                            var formattedDate = $.datepicker.formatDate('yy-mm-dd', date);

                            // Check if the date is available
                            var isAvailable = availableDates.includes(formattedDate);

                            // Determine the CSS class for the date
                            var cssClass = isAvailable ? 'available' : 'unavailable';

                            // Determine the tooltip for the date
                            var tooltip = isAvailable ? 'Available' : 'Unavailable';

                            // Determine if the date should have a custom color

                            if (disableDates.includes(formattedDate)) {
                                cssClass += ' custom-color';
                            }

                            if (day === 0 || day === 6) {
                                cssClass += ' weekend';
                                return [false, cssClass, tooltip];
                            }
                            // Return an array with the CSS class and tooltip
                            return [true, cssClass, tooltip];
                        };
                        $('.datepicker').multiDatesPicker('destroy').multiDatesPicker(option);
                    } else if (this.value == 'off') {
                        $("#rest").html(html);
                        $('.dates-fields').val('');
                        option.beforeShowDay = enableSelectedDatesAndDisableWeekends;
                        if (availableDates && availableDates.length > 0) {
                            $('.datepicker').multiDatesPicker('destroy').multiDatesPicker(option);
                            $("#rest").show();
                        }
                    }
                });

                $("#rest").on("change", "#range", function() {
                    if (this.checked) {
                        $('.datepicker').multiDatesPicker("destroy");
                        $('.datepicker').datepicker(option);
                        $("#fromDate").val("");
                        $('.toDateInput').show();
                        $('.fromDateText').text('From Date');
                    } else {
                        $('.datepicker').datepicker("destroy");
                        $('.datepicker').multiDatesPicker(option);
                        $('.toDateInput').hide();
                        $('#toDate').val("");
                        $('.fromDateText').text('Dates');
                    }
                });
                $("#rest").on("click", "#addDate", function() {
                    $(this).hide();
                    $('.loader').show();
                    let formData = $('#addDateForm').serializeArray();
                    let payload = convertFormDataToObject(formData);
                    if (!payload?.dates || !payload?.status) {
                        alert('Date and Status field are required');
                        return;
                    }
                    var isToDateVisible = $('#toDate').is(":visible");
                    if (isToDateVisible) {
                        let toDate = $('#toDate').val();
                        if (!toDate) {
                            $('.loader').hide();
                            $('#addDate').show();
                            alert("To Date is required");
                            return;
                        }
                        let startDate = new Date(payload?.dates);
                        let endDate = new Date(toDate);
                        if (startDate > endDate) {
                            $('.loader').hide();
                            $('#addDate').show();
                            alert('From Date must be less than To Date');
                            return;
                        }
                        payload.dates = getDatesBetween(startDate, endDate);
                    } else {
                        payload.dates = payload.dates.split(",");
                    }
                    $.ajax({
                        url: "{{ url('/api/admin/date') }}", // Replace with your actual endpoint URL
                        method: 'POST',
                        data: payload,
                        success: function(response) {
                            alert(response?.response);
                            $('.loader').hide();
                            $('#addDate').show();
                        },
                        error: function(xhr, status, error) {
                            console.log('POST request failed');
                            console.log(xhr?.responseJSON?.response ?? 'Something went wrong');
                            alert(xhr?.responseJSON?.response ?? 'Something went wrong');
                            $('.loader').hide();
                            $('#addDate').show();
                        }
                    });
                })
            });

            function getDatesBetween(startDate, endDate) {
                var dates = [];
                var currentDate = new Date(startDate);

                while (currentDate <= endDate) {
                    var year = currentDate.getFullYear().toString();
                    var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);
                    var day = ("0" + currentDate.getDate()).slice(-2);
                    var formattedDate = year + "-" + month + "-" + day;
                    dates.push(formattedDate);
                    currentDate.setDate(currentDate.getDate() + 1);
                }

                return dates;
            }
        </script>
    @endsection
