<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Search Jobs For You | OTP</title>

    <link rel="icon" type="image/png" sizes="32x32" href="#">

    <!-- Header links Start -->
    @include('admin.template.header-links')
    <!-- End Header links -->
</head>

<body class="gray-bg">
    <div class="passwordBox animated fadeInDown">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox-content">
                    <h2 class="font-bold">One Time Password</h2>

                    <p>
                        OTP has been send to your email.
                        <br>
                        Please verify.
                    </p>

                    <div class="row">
                        <div class="col-lg-12">
                            <form class="m-t" role="form" id="otpForm" action="{{ url('admin/reset-password') }}" method="post">
                                {{ csrf_field() }}

                                <input type="hidden" name="ResponseOTP" id="ResponseOTP" value="{{ $OTP }}">
                                <input type="hidden" name="Email" id="Email" value="{{ $Email }}">

                                <div class="form-group">
                                    <input type="password" id="OTP" name="OTP" class="form-control" placeholder="Please Enter One Time Password" autofocus>
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer links Start -->
    @include('admin.template.footer-scripts')
    <!-- End Footer links -->

    <script>
        $(document).ready(function() {
            $("#otpForm").validate({
                rules: {
                    OTP: {
                        required: true,
                        equalTo: '#ResponseOTP',
                    }
                },
                messages: {
                    OTP: {
                        required: adminMessage['msgOtpRequired'],
                        equalTo: adminMessage['msgCheckOtp'],
                    }
                }
            });
        });
    </script>
</body>
</html>