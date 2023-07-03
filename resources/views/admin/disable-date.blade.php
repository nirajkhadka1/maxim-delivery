@extends('layouts.header')

@section('load-content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('css/date-time-picker.css') }}" />
@endsection

<body>
    @extends('layouts.navigation')
    @extends('layouts.main-content')

    @section('main-content')
        <div class="card">
            <form class="card-body" id="editDateForm">
                <div class="form-group">
                    <label for="exampleFormControlInput1">From Date</label>
                    <input type="text" id="fromDate" name="from" class="form-control datepicker" readonly>

                </div>
                <div class="form-group mt-4">
                    <label for="exampleFormControlInput1">To Date</label>
                    <input type="text" class="form-control datepicker" name="to" id="toDate" readonly>
                </div>
                <div class="form-group mt-4">
                    <label for="exampleFormControlInput1">Status</label>
                    <div class="mt-2">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="status"
                                value="on">
                            <label class="form-check-label" for="inlineCheckbox1">enable</label>
                        </div>
                        <div class="form-check form-check-inline ">
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="status"
                                value="off">
                            <label class="form-check-label" for="inlineCheckbox2">disable</label>
                        </div>
                    </div>
                </div>
                <div class="form-group mt-2">
                    <label for="exampleFormControlTextarea1">Remarks</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="remarks" rows="3"></textarea>
                </div>
                <div class="loader" style="display: none"></div>
                <div class="mt-4">
                    <button type="button" id="editDate" class="btn btn-success">Edit Date</button>
                </div>
            </form>
        </div>
    @endsection

    @extends('layouts.include-scripts')
    @section('load-scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
        <script src="{{ asset('js/helpers.js') }}"></script>
        <script>
            $(document).ready(function() {
                let startDate = new Date("{{ $available_dates->from }}");
                let endDate = new Date("{{ $available_dates->to }}");
                $('.datepicker').datepicker({
                    dateFormat: "yy-mm-dd",
                    minDate: startDate,
                    maxDate: endDate
                });
                ('input[type=radio][name=status]').change(function() {
                    if (this.value == 'allot') {
                    } else if (this.value == 'transfer') {
                        // ...
                    }
                });
                $('#editDate').click(function() {
                    $('.loader').show();
                    $(this).hide();
                    let formData = $('#editDateForm').serializeArray();
                    let payload = convertFormDataToObject(formData);
                    let startDate = new Date(payload?.from);
                    let endDate = new Date(payload?.to);
                    if (!payload?.from || !payload?.status) {
                        alert('From Date and Status is required');
                        return;
                    }
                    if (startDate > endDate) {
                        alert('From Date is must be less than To Date');
                        return;
                    }
                    $.ajax({
                        url: "{{ url('/api/admin/date') }}", // Replace with your actual endpoint URL
                        method: 'POST',
                        data: payload,
                        success: function(response) {
                            alert(response?.response);
                            $('.loader').hide();
                            $("#editDate").show();
                        },
                        error: function(xhr, status, error) {
                            console.log('POST request failed');
                            console.log(xhr?.responseJSON?.response ?? 'Something Went Wrong');
                            alert(xhr?.responseJSON?.response ?? 'Something Went Wrong')
                            $('.loader').hide();
                            $('#editDate').show();
                        }
                    });
                })
            });
        </script>
    @endsection

    @extends('layouts.footer')
