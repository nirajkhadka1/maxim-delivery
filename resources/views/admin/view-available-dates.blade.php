@extends('layouts.header')

@section('load-content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/client-form.css') }}" />
    <style>
        .form-check-input:checked {
            background-color: #0dfd31 !important;
            border-color: #39b34c !important;
        }
    </style>
@endsection

<body>
    @extends('layouts.navigation')

    @extends('layouts.main-content')
    @include('components.modal')
    @section('main-content')
        <div class="container-fluid d-flex justify-content-end mb-2">
            <a href="{{ url('/v1/admin/add-available-date') }}"><button type="button" class="btn btn-success"> Date
                    Form</button></a>
        </div>
        <div class="card bg-dark">
            <div class="card-body">
                <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                            <th scope="col">Enable/Disable Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($available_dates as $available_date)
                            <tr>
                                <td>{{ $available_date->dates }}</td>
                                <td>{{ $available_date->status }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger deleteDateBtn"
                                        data-id={{ $available_date->id }}>Delete</button>
                                </td>
                                <td>
                                    <div class="btn-group btn-toggle" style="background: #cbc9c9">
                                        <button
                                            class="btn btn-xs  {{ $available_date->status === 'on' ? 'btn-success active' : 'btn-default' }} onButton on-btn-{{ $available_date->id }}"
                                            data-id={{ $available_date->id }} data-date={{ $available_date->dates }}
                                            data-status={{ $available_date->status }}
                                            {{ $available_date->status == 'on' ? 'disabled' : '' }}>Enable</button>
                                        <button
                                            class="btn btn-xs {{ $available_date->status === 'off' ? 'btn-warning' : 'btn-default' }} offButton off-btn-{{ $available_date->id }}"
                                            data-id={{ $available_date->id }} data-date={{ $available_date->dates }}
                                            data-status={{ $available_date->status }}
                                            {{ $available_date->status == 'off' ? 'disabled' : '' }}>Disable</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection

    @extends('layouts.include-scripts')
    @section('load-scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
            integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous">
        </script>
        <script src="{{ asset('js/helpers.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.deleteDateBtn').click(function() {
                    $('.modal-footer').html(`
                        <button type="button" class="btn btn-danger editActionBtn">Delete</button>
                        <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                    `);
                    $('#myModal').modal('show');
                    $('.is_delete').val(true);
                    let id = $(this).attr('data-id');
                    $('.edit_id').val(id);
                    // window.location.href = `{{ url('/v1/admin/edit-date/${id}') }}`
                    // $.ajax({
                    //     method:"DELETE",
                    //     url:`{{ url('/api/admin/date/${id}') }}`,
                    //     success:function(response){
                    //         console.log(response)
                    //     },
                    //     error: function(xhr,status,error){
                    //         console.log("XHR",xhr);
                    //         console.log("Status",status);
                    //         console.log("Error",error);
                    //     }}
                    // );
                });

                $('.onButton').click(function() {
                    $('.modal-footer').html(`
                        <button type="button" class="btn btn-success editActionBtn">Enable</button>
                        <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                    `);
                    let status = $(this).data('status')
                    let id = $(this).data('id');
                    let date = $(this).data('date')
                    if (status === 'off') {
                        $('#myModal').modal('show');
                        $('.edit_id').val(id);
                        $('.dates').val(date)
                        $('.status').val('on');
                    }
                });

                $('.modal-footer').on('click', '.editActionBtn', function() {
                    let apiRequestData = {
                        method: '',
                        payload: ''
                    };
                    let isDelete = $('.is_delete').val();
                    let formArray = $('#modificationForm').serializeArray();
                    let payload = convertFormDataToObject(formArray);

                    if (!payload?.remarks) {
                        alert("Remarks is required !!");
                        return;
                    }

                    let confirmation = confirm('Are you sure to make this change?');
                    if (confirmation) {
                        if (isDelete) {
                            apiRequestData.method = 'DELETE',
                                apiRequestData.payload = {
                                    remarks: payload?.remarks
                                }
                        } else {
                            apiRequestData.method = 'PUT',
                                apiRequestData.payload = {
                                    status: payload?.status,
                                    remarks: payload?.remarks
                                }

                        }
                        $.ajax({
                            url: `{{ url('/api/admin/date/${payload?.id}') }}`, // Replace with your actual endpoint URL
                            method: apiRequestData?.method,
                            data: apiRequestData?.payload,
                            success: function(response) {
                                alert(response?.response);
                                window.location.reload();
                            },
                            error: function(xhr, status, error) {
                                console.log('POST request failed');
                                console.log(xhr?.responseJSON?.response ??
                                    'Something went wrong');
                                alert(xhr?.responseJSON?.response ?? 'Something went wrong');
                                window.location.reload();
                            }
                        });
                    }
                });

                $('.offButton').click(function() {
                    $('.modal-footer').html(`
                        <button type="button" class="btn btn-danger editActionBtn">Disable</button>
                        <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                    `);
                    let id = $(this).data('id');
                    let date = $(this).data('date')
                    let status = $(this).data('status')

                    if (status === 'on') {
                        $('#myModal').modal('show');
                        $('.edit_id').val(id);
                        $('.status').val("off");
                        $('.dates').val(date)
                    }
                });

                $('.changeStatusBtn').click(function() {
                    $(this).attr('disabled', true);
                    let formArray = $('#changeStatusBtn').serializeArray();
                    let payload = convertFormDataToObject(formArray);

                    if (!payload?.remarks) {
                        alert("Remarks is required !!");
                        return;
                    }

                    let confirmation = confirm('Are you sure to make this change?');
                    if (confirmation) {
                        $.ajax({
                            url: `{{ url('/api/admin/date/${payload?.id}') }}`, // Replace with your actual endpoint URL
                            method: 'PUT',
                            data: payload,
                            success: function(response) {
                                alert(response?.response);
                                $('.loader').hide();
                                $('#addDate').show();
                                window.location.reload();
                            },
                            error: function(xhr, status, error) {
                                console.log('POST request failed');
                                console.log(xhr?.responseJSON?.response ?? 'Something went wrong');
                                alert(xhr?.responseJSON?.response ?? 'Something went wrong');
                                $('.loader').hide();
                                $('#addDate').show();
                                window.location.reload();
                            }
                        });
                    }

                });

                $(document).on('click', '.close-modal', function() {
                    $('#myModal').modal('hide');
                });
            });
        </script>
    @endsection

    @extends('layouts.footer');
