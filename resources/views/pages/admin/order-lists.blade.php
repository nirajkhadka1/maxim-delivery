    @extends('layouts.main-admin')

    @section('load-css')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.0/css/dataTables.dateTime.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/data-table.css') }}" />
        <style>
            .date-search {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }

            .active {
                background-color: #0d6efd !important;
                border-color: #0d6efd !important;
            }

            .form-input {
                width: 25% !important;
                display: flex;
                justify-content: space-between;
            }

            .head-title {
                color: #0c7f40;
                font-weight: 700;
                /* text-align: center; */
                /* font-size: 24px; */
                /* font-family: 'Poppins'; */
                /* font-style: normal; */
                /* font-weight: 700; */
                /* text-transform: capitalize; */
                margin-top: 17px;
            }
        </style>
    @endsection


    @section('main-content')
        <div class="container">
            <h1 class='head-title'>Orders</h1>
            <div class="date-search">
                <div class="form-input mt-2">
                    <label for="start-date">Start Date:</label>
                    <input type="date" id="start_date" placeholder="Start Date">
                </div>
                <div class="form-input mt-2">
                    <label for="end-date">End Date:</label>
                    <input type="date" id="end_date" placeholder="End Date">
                </div>
                <div class="form-input mt-2">
                    <button id="apply-filter" class="btn btn-danger w-50">Apply Filter</button>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <table id="orders-table" class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact Number</th>
                                <th>Geolocation</th>
                                <th>Date Delivery</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                                <th><input type="text" id="search-name" data-column="0" placeholder="Search Name"></th>
                                <th><input type="text" id="search-primary_contact_number" data-column="1"
                                        placeholder="Search Contact"></th>
                                <th><input type="text" id="search-geolocation" data-column="2"
                                        placeholder="Search Geolocation"></th>
                                <th><input type="text" id="search-delivery_date" data-column="3"
                                        placeholder="Search Delivery"></th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    @endsection

    @section('include-scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
        <script>
            $(document).ready(function() {
                var dataTable = $('#orders-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('api.datatable.order-search') }}",
                        data: function(data) {
                            // Pass additional parameters if needed
                            data.search_name = $('#search_name').val();
                            data.search_primary_contact_number = $('#search_primary_contact_number').val();
                            data.start_date = $('#start_date').val();
                            data.end_date = $('#end_date').val();
                        }
                    },
                    columns: [{
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'primary_contact_number',
                            name: 'primary_contact_number'
                        },
                        {
                            data: 'geolocation',
                            name: 'geolocation'
                        },
                        {
                            data: 'delivery_date',
                            name: 'delivery_date'
                        },
                        {
                            data: null,
                            name: 'actions',
                            orderable: false,
                            searchable: false,
                            render: function(data) {
                                return `<a href="{{ url('/v1/admin/order/${data?.id}') }}" ><button class="btn btn-success btn-sm btn-edit" data-id="${data?.id}">Edit</button></a>`;
                            }
                        }
                    ],
                    dom: 'lrtip', // Show only the table, processing indicator, search input, and pagination
                    pageLength: 10,
                    searching: true,
                });
                $('#search-name').on('keyup', function() {
                    dataTable.column('name:name').search(this.value).draw();
                });
                $('#search-primary_contact_number').on('keyup', function() {
                    dataTable.column(1).search(this.value).draw();
                });
                $('#search-geolocation').on('keyup', function() {
                    dataTable.column(2).search(this.value).draw();
                });
                $('#search-delivery_date').on('keyup', function() {
                    dataTable.column(3).search(this.value).draw();
                });

                $('#apply-filter').on('click', function() {
                    dataTable.draw();
                });
            });
        </script>
    @endsection
