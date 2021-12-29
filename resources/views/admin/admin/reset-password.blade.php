<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Search Jobs For You | Reset password</title>

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
                    <h2 class="font-bold">Reset Password</h2>

                    <div class="row">
                        <div class="col-lg-12">
                            <form class="m-t" role="form" id="resetPasswordForm" action="{{ url('admin/submit-reset-password') }}" method="post">
                                {{ csrf_field() }}

                                <input type="hidden" name="Email" id="Email" value="{{ $Email }}">

                                <div class="form-group">
                                    <input type="password" id="Password" name="Password" class="form-control" placeholder="Please Enter New Password" autofocus>
                                </div>

                                <div class="form-group">
                                    <input type="password" id="ConfirmPassword" name="ConfirmPassword" class="form-control" placeholder="Please Enter Confirm Password">
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">Reset Password</button>
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
            $("#resetPasswordForm").validate({
                rules: {
                    Password: {
                        required: true,
                    },
                    ConfirmPassword: {
                        required: true,
                        equalTo: '#Password',
                    }
                },
                messages: {
                    Password: {
                        required: adminMessage['msgNewPasswordRequired'],
                    },
                    ConfirmPassword: {
                        required: adminMessage['msgConfirmPasswordRequired'],
                        equalTo: adminMessage['msgMatchPassword'],
                    }
                }
            });
        });
    </script>
</body>
</html>