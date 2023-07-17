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
<link href="https://cdn.jsdelivr.net/npm/jquery-ui-multidatespicker@1.6.6/jquery-ui.multidatespicker.css"
rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/client-form.css')}}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />



    <style>
        .form-container {
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            padding: 30px;
            width: 400px;
        }

        .logo {
            display: flex;
            justify-content: center;
            object-fit: contain;
        }

        .logo img {
            object-fit: contain;
            height: 60px;
            width: 300px;
        }

        input,
        select {
            min-width: 100%;
        }

        .select2-container {
            width: 100% !important;
        }
    </style>
@endsection


<body>
    @section('main-content')

        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="">
        </div>
        <div class="container-fluid d-flex justify-content-center mt-5">
            <div class="form-container">
                <form id="editDateForm">
                    <div class="form-group d-flex flex-column" >
                        <label for="exampleInputEmail1">Geolocation</label>
                        @if ($is_single_page)
                            <input type="text" name="id" value="{{ $geolocations->id }}" hidden>
                            <input type="text" value="{{ $geolocations->geolocation }}" readonly>
                        @else
                            <select name="id" id="geolocation">
                                <option value="" selected disabled>Select</option>
                                @foreach ($geolocations as $geolocation)
                                    <option value="{{ $geolocation->id }}">{{ $geolocation->geolocation }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="form-group d-flex flex-column mt-3">
                        <label for="exampleInputPassword1">Config</label>
                        @php
                            $configs = config('app.regularites');
                            
                        @endphp
                        <select name="config" id="config">
                            @if ($is_single_page && $geolocations->config)
                                @php  $configs = array_diff($configs, [$geolocations->config]);@endphp
                                <option value="{{ $geolocations->config }}" selected> {{ $geolocations->config }}</option>
                            @else
                                <option value="" selected disabled>Select</option>
                            @endif

                            @foreach ($configs as $config)
                                <option value="{{ $config }}">{{ $config }}</option>
                            @endforeach
                        </select>
                    </div>
                    @if (!$is_single_page)
                        <p class="note text-danger">Please select config to choose the date</p>
                    @endif
                    <div class="form-group mt-3" id="dateDiv" style="display: none">
                        <label>Date</label>
                        <input type="text" id="datetimepicker" class="form-control" placeholder="yyyy-mm-dd"
                            name="start_date">
                    </div>

                    <div class="form-group mt-3">
                        <label>Order Limit</label>
                        @php
                            $value = $is_single_page ? $geolocations->order_limit : '';
                        @endphp
                        <input type="number" class="form-control" id="order_limit" name="order_limit"
                            value="{{ $value }}">
                    </div>

                    <button class="btn btn-success mt-2" id="editBtn" disabled>Edit</button>
                </form>
            </div>
        @endsection

        @section('include-scripts')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
            <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
            <script src="{{ asset('js/helpers.js') }}"></script>
            <script src="https://cdn.jsdelivr.net/npm/jquery-ui-multidatespicker@1.6.6/jquery-ui.multidatespicker.js"></script>

            <script>
                $(document).ready(function() {
                    let config = "{{ $is_single_page ? $geolocations->config : '' }}";
                    let customDates = "{{ $is_single_page ? $geolocations->custom_dates : '' }}";
                    let startDate = "{{ $is_single_page ? $geolocations->start_date : '' }}";
                    var option = {
                        dateFormat: 'yy-mm-dd',
                    };
                    if (config) {
                        if (config === 'custom') {
                            option.beforeShowDay = function(date) {
                                var dates = customDates.split(', ');
                                var currentDate = new Date(date.getFullYear(), date.getMonth(), date.getDate());

                                for (var i = 0; i < dates.length; i++) {
                                    var formattedDate = new Date(dates[i]);
                                    if (formattedDate.toDateString() === currentDate.toDateString()) {
                                        return [true, 'edit-active'];
                                    }
                                }
                                return [true, ''];
                            }
                            $('#datetimepicker').datepicker('destroy').multiDatesPicker(option);
                            $('#datetimepicker').val(customDates)

                        } else {
                            $('#datetimepicker').multiDatesPicker('destroy').datepicker(option);
                            $('#datetimepicker').val(startDate)
                        }
                        $('#dateDiv').show();
                        $("#editBtn").attr('disabled', false);
                    }
                    $('#geolocation,#config').select2();
                    $('#config').on('select2:select', function(e) {
                        $("#datetimepicker").val("");

                        if (e.target.value === 'custom') {
                            $('#datetimepicker').datepicker('destroy').multiDatesPicker(option);
                        } else {
                            $('#datetimepicker').multiDatesPicker('destroy').datepicker(option);
                        }
                        $('#dateDiv').show();
                        $("#editBtn").attr('disabled', false);
                        $(".note").hide();
                    });

                    $("#order_limit").keydown(function() {
                        let order_limit = $(this).val();
                        if (order_limit <= 0) {
                            $(this).val('');
                        }
                    });

                    $("#editBtn").click(function(e) {
                        e.preventDefault();
                        $(".overlay").css('visibility', 'visible');
                        let formData = $('#editDateForm').serializeArray();
                        let payload = convertFormDataToObject(formData);
                        if (!payload?.id) {
                            $(".overlay").css('visibility', 'hidden');
                            alert('Geolocation field is required !!');
                            return;
                        }
                        let url = `{{ url('/api/admin/location/${payload?.id}') }}`;
                        let ajaxConfig = {
                            url: url,
                            method: 'PUT',
                            data: payload,
                            success: function(response) {
                                alert(response?.response);
                                $(".overlay").css('visibility', 'hidden');
                            },
                            error: function(error) {
                                alert(error?.error)
                                $(".overlay").css('visibility', 'hidden');
                            },
                        }
                        $.ajax(ajaxConfig);
                    })
                });
            </script>
        @endsection
</body>
