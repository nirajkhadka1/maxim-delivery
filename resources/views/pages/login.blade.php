@extends('layouts.main-client')

@section('load-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel='stylesheet' href="{{ asset('css/login-form.css') }}" />
@endsection

@section('main-content')
    <div id="login">
        <div class="container justify-content-center w-25">
            <div class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="">
            </div>
            <div id="login-row">
                <div id="login-column" class="justify-content-center">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="{{ url('v1/authenticate') }}" method="post">
                            @csrf
                            @if (isset($error_msg))
                                <p class="w-100 text-center text-danger" id='error_msg'>{{ $error_msg }}</span>
                            @endif
                            {{-- <h3 class="text-center text-success">Login</h3> --}}
                            <div class="form-group mt-2">   
                                <label for="username" class="w-100 text-success text-center">Username:</label><br>
                                <div class="d-flex justify-content-center">
                                    <input type="text" name="username" id="username" class="form-control w-50">
                                </div>
                            </div>
                            <div class="form-group mt-2">
                                <label for="password" class="w-100 text-success text-center">Password:</label><br>
                                <div class="d-flex justify-content-center">
                                    <input type="password" name="password" id="password" class="form-control w-50">
                                </div>
                            </div>
                            <div class="form-group mt-2 d-flex flex-direction-column justify-content-center">
                                <label for="remember-me" class="text-success"><span>Remember me</span> <span><input
                                            id="remember-me" name="remember" type="checkbox"></span></label><br>
                            </div>
                            <div class="w-100 d-flex justify-content-center">
                                <button type="submit" class="w-25 btn btn-success mt-3">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('include-scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#error_msg').delay(1000).fadeOut('slow');

        });
    </script>
@endsection
@endsection
