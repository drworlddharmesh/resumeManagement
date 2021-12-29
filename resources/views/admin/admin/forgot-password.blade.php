<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Search Jobs For You | Forgot password</title>

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
                    <h2 class="font-bold">Forgot password</h2>

                    <p>
                        Enter your email address and your one time password will be emailed to you.
                    </p>

                    <div class="row">
                        <div class="col-lg-12">
                            <form class="m-t" role="form" id="forgotPasswordForm" action="{{ url('admin/otp') }}" method="post">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <input type="text" id="Email" name="Email" class="form-control" placeholder="Please Enter Email" autofocus>
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">Reset</button>
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
            $("#forgotPasswordForm").validate({
                rules: {
                    Email: {
                        required: true,
                        lexemail: true,
                        checkadminemail: true,
                    }
                },
                messages: {
                    Email: {
                        required: adminMessage['msgEmailRequired'],
                    }
                }
            });
        });

        $.validator.addMethod("lexemail", function(value, element) {
          // allow any non-whitespace characters as the host part
          return this.optional( element ) || /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test( value );
        }, adminMessage['msgValidEmail']);

        $.validator.addMethod('checkadminemail', function(value, element) {
            var rtn_val = true;

            $.ajax({
                url: 'check-admin-email',
                type: 'POST',
                async: false,
                data: {
                    _token: '{{ csrf_field() }}',
                    Email: value
                },
                success: function(data) {
                    if(data == 1){
                        rtn_val = false;
                    }
                }
            });

            return rtn_val;
        }, adminMessage['msgIncorrectEmail']);
    </script>
</body>
</html>