@extends('layouts.header')

@section('load-content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/jquery-ui-multidatespicker@1.6.6/jquery-ui.multidatespicker.css">

    <link rel="stylesheet" href="{{ asset('css/date-time-picker.css') }}" />
@endsection

<body>
    @extends('layouts.navigation')
    @extends('layouts.main-content')

    @section('main-content')
        <form class="card-body" id="editDateForm">
            <div class="form-group mt-4">
                <label for="exampleFormControlInput1">Date</label>
                <input type="text" class="form-control datepicker" readonly>
            </div>
            <div class="form-group mt-4">
                <label for="exampleFormControlInput1">Status <span class="text-danger">*</span></label>
                <div class="mt-2">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" id="inlineCheckbox1" name="status" value="on">
                        <label class="form-check-label" for="inlineCheckbox1">enable</label>
                    </div>
                    <div class="form-check form-check-inline ">
                        <input class="form-check-input" type="radio" id="inlineCheckbox2" name="status" value="off">
                        <label class="form-check-label" for="inlineCheckbox2">disable</label>
                    </div>
                </div>
            </div>
            <div class="form-group mt-2">
                <label for="exampleFormControlTextarea1">Remarks <span class="text-danger">*</span></label>
                <textarea class="form-control" id="exampleFormControlTextarea1" name="remarks" rows="3"></textarea>
            </div>
            <div class="loader" style="display: none"></div>
            <div class="mt-4">
                <button type="button" id="editDate" class="btn btn-success">Edit Date</button>
            </div>
        </form>
    @endsection

    @extends('layouts.include-scripts')
    @section('load-scripts')
    @endsection

    @extends('layouts.footer')
