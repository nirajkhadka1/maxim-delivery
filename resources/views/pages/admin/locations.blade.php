@extends('layouts.main-admin')

@section('load-css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM"
        crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.0/css/dataTables.dateTime.min.css" />
    <style>
        .card {
            border: none;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 1.5rem;
            overflow: auto;
        }

        .column-search input {
            width: 100%;
            padding: 0.5rem;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin-top: 1rem;
        }

        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate .pagination {
            font-size: 0.875rem;
        }

        .modify-location {
            display: flex;
            justify-content: end;
        }

        .dataTables_filter {
            margin-bottom: 10px !important;
        }
    </style>
@endsection

@section('main-content')
    <div class="heading">
        <h3>Locations</h3>
    </div>
    <div class="modify-location">
        <a href="{{ url('v1/admin/location/edit') }}"><button class="btn btn-success"> Modify Locations</button></a>
    </div>
    <div class="card mt-3 pt-2" style="width:100% !important">
        <div class="card-body px-5">
            <table id="datatable" class="table table-striped table-light">
                <thead>
                    <tr>
                        <th>Geolocation</th>
                        <th>Config</th>
                        <th>Order Limit</th>
                        <th>Actions</th>
                    </tr>
                    <tr>
                        <th><input type="text" class="column-search" data-column="0" placeholder="Search Geolocation">
                        </th>
                        <th><input type="text" class="column-search" data-column="1" placeholder="Search Config"></th>
                        <th><input type="text" class="column-search" data-column="2" placeholder="Search Order Limit">
                        </th>
                        <th></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@section('include-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            var dataTable = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                info: false,
                paging: false,
                ajax: {
                    url: "{{ route('api.datatable.search') }}",
                    data: function(data) {
                        $('.column-search').each(function() {
                            var columnData = $(this).data('column');
                            data.columns[columnData].search.value = $(this).val();
                        });
                    }
                },
                columns: [{
                        data: 'geolocation',
                        name: 'geolocation'
                    },
                    {
                        data: 'config',
                        name: 'config'
                    },
                    {
                        data: 'order_limit',
                        name: 'order_limit'
                    },
                    {
                        data: null,
                        name: 'actions',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            return `<a href="{{ url('/v1/admin/location/edit/${data?.id}') }}" ><button class="btn btn-success btn-sm btn-edit" data-id="' + data.id + '">Edit</button></a>`;
                        }
                    }
                ],
            });

            $('.column-search').on('keyup', function() {
                dataTable
                    .column($(this).data('column'))
                    .search(this.value)
                    .draw();
            });
        });
    </script>
@endsection
