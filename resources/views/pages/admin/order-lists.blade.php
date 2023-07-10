@extends('layouts.main-admin')

@section('load-css')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.0/css/dataTables.dateTime.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/data-table.css') }}" />
@endsection

@section('main-content')
    <div class="container mt-5">
        <table border="0" cellspacing="5" cellpadding="5" class="hover">
            <tbody>
                <tr>
                    <td>Starting Date:</td>
                    <td><input type="text" id="min" name="min" readonly></td>
                </tr>
                <tr>
                    <td>Ending Date:</td>
                    <td><input type="text" id="max" name="max" readonly></td>
                </tr>
            </tbody>
        </table>
        <a href="{{ url('v1/admin/view-orders') }}"><button style="width:125px" class="btn btn-success mt-1 mb-3"
                id="reset">Reset Filter</button></a>
        <table id="example" class="display hover cell-border table table-striped" style="width:100%">

            <thead>
                <tr>
                    <th scope="col">School Name</th>
                    <th scope="col">Contact Number</th>
                    <th scope="col">Delivery Date</th>
                    <th scope="col">Geo Location</th>
                    <th scope="col">View</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order_details as $order_detail)
                    <tr>
                        <td scope="row">{{ $order_detail->school->name }}</td>
                        <td scope="row">{{ $order_detail->school->primary_contact_number }}</td>
                        <td scope="row">{{ $order_detail->delivery_date }}</td>
                        <td scope="row">{{ $order_detail->geolocation }}</td>
                        <td scope="row"><a
                                href='{{ url("/v1/admin/order/$order_detail->id") }}'><button>Details</button></a></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>School Name</th>
                    <th>Contact Number</th>
                    <th>Delivery Date</th>
                    <th>Geo Location</th>
                    <th style="display: none"></th>
                </tr>
            </tfoot>
        </table>
        {{-- <div class="d-flex justify-content-end flex-end w-100">
            {{ $order_details->links() }}
        </div> --}}
    </div>
    {{-- {{dd(count($order_details))}} --}}
@endsection

@section('include-scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
        integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.0/js/dataTables.dateTime.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

    <script>
        $(document).ready(function() {
            let minDate, maxDate;
            let table = $("#example").DataTable({
                initComplete: function() {
                    let api = this.api();

                    api.columns().every(function() {
                        let column = this;
                        let title = $(column.footer()).text();

                        let input = $('<input type="text" placeholder="' + title + '" />')
                            .appendTo($(column.footer()).empty())
                            .on("keyup change", function() {
                                if (column.search() !== this.value) {
                                    column.search(this.value).draw();
                                }
                            });
                    });
                },

            });

            minDate = $("#min").datepicker({
                dateFormat: "yy-mm-dd",
                onSelect: function(selectedDate) {
                    maxDate.datepicker("option", "minDate", selectedDate);
                    filterByDateRange();
                }
            });

            maxDate = $("#max").datepicker({
                dateFormat: "yy-mm-dd",
                onSelect: function(selectedDate) {
                    minDate.datepicker("option", "maxDate", selectedDate);
                    filterByDateRange();
                },
                minDate: new Date(minDate)
            });

            function filterByDateRange() {
                let min = minDate.datepicker("getDate");
                let max = maxDate.datepicker("getDate");

                let filteredData = $.fn.dataTable.ext.search.push(function(settings, data) {
                    let date = new Date(data[2]);

                    if ((min === null && max === null) ||
                        (min === null && date <= max) ||
                        (min <= date && max === null) ||
                        (min <= date && date <= max)) {
                        return true;
                    }
                    return false;
                });

                if (filteredData.length === 0) {
                    minDate.datepicker("setDate", null);
                    maxDate.datepicker("setDate", null);
                }

                table.draw();
            }

            $("#reset").on("click", function() {
                window.location.reload();
            });

        });
    </script>
@endsection
