@extends('components.master.auth-master')

@section('auth-content')
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-4">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="../assets/images/logos/dark-logo.svg" width="180" alt="">
                                </a>

                                @isset($status)
                                    <div class="alert alert-success" role="alert">{{ $status }}</div>
                                @endisset
                                <form method="POST" action="{{ url('/signup') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="FullName" class="form-label">Full Name</label>
                                        <input type="text" name="fname" class="form-control" id="FullName"
                                            aria-describedby="textHelp" required>
                                        @error('fname')
                                            <p class="text-danger fw-semibold ms-2 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="Email" class="form-label">Email Address</label>
                                        <input type="email" name="email" class="form-control" id="Email"
                                            aria-describedby="emailHelp" required>
                                        @error('email')
                                            <p class="text-danger fw-semibold ms-2 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="Password" class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" id="Password" required>
                                        @error('password')
                                            <p class="text-danger fw-semibold ms-2 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="ConfirmPassword" class="form-label">Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            id="ConfirmPassword" required>
                                        @error('password_confirmation')
                                            <p class="text-danger fw-semibold ms-2 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="DOB" class="form-label">Birth Date</label>
                                        <input type="date" name="dob" class="form-control" id="DOB" required>
                                        @error('dob')
                                            <p class="text-danger fw-semibold ms-2 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="mobile" class="form-label">Mobile</label>
                                        <input type="text" name="mobile" pattern="^[6-9]\d{9}$" class="form-control" id="mobile" required>
                                        @error('mobile')
                                            <p class="text-danger fw-semibold ms-2 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-4 d-flex justify-content-evenly">
                                        <div>
                                            <label for="Male" class="form-radio-label">Male</label>
                                            <input type="radio" name="gender" value="0" class="form-radio-input"
                                                id="Male" required>

                                        </div>
                                        <div>
                                            <label for="Female" class="form-radio-label">Female</label>
                                            <input type="radio" name="gender" value="1" placeholder="Female"
                                                class="form-radio-input" id="Female" required>
                                        </div>
                                        @error('gender')
                                            <p class="text-danger fw-semibold ms-2 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label for="pincode" class="form-label">pincode</label>
                                        <input type="text" name="pincode" id="pincode" class="form-control"
                                            pattern="^[1-9][0-9]{5}$" id="pincode">
                                        @error('pincode')
                                            <p class="text-danger fw-semibold ms-2 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="state" class="form-label">State</label>
                                        <input type="text" name="state" id="state" class="form-control">
                                        @error('state')
                                            <p class="text-danger fw-semibold ms-2 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="city" class="form-label">City</label>
                                        <input type="text" name="city" id="city" class="form-control">

                                        @error('city')
                                            <p class="text-danger fw-semibold ms-2 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <input type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2"
                                        value="Sign Up">
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                                        <a class="text-primary fw-bold ms-2" href="{{ url('/login') }}">Sign
                                            In</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $('#pincode').on('change', function() {
            var searchValue = $('#pincode').val()
            $.ajax({
                type: 'GET',
                url: `{{ url('/api/get-pincode') }}`,
                headers: {
                    'Content-Type': 'application/json'
                },
                success: function(data) {
                    var dataByPin = data.find(pin => pin.pincode == searchValue)
                    var city = $('#city').val(dataByPin.taluk)
                    var state = $('#state').val(dataByPin.stateName)
                }
            });
        })
    </script>
@endsection
