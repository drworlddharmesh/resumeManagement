<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Search Jobs For You | Login</title>

    <link rel="icon" type="image/png" sizes="32x32" href="#">

    <!-- Header links Start -->
    @include('admin.template.header-links')
    <!-- End Header links -->
</head>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>
                <!-- <h1 class="logo-name">RF</h1> -->
                 <img  src="{{ url('storage/app/common/logo.png') }}" class="rf-logo">
            </div>

            <form class="m-t" role="form" id="loginForm" action="{{ url('admin/login') }}" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Please Enter Email" name="Email" id="Email" value="{!! Session::get('Email') !!}" autofocus>
                </div>

                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Please Enter Password" name="Password" id="Password" value="{!! Session::get('Password') !!}">
                </div>

                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>

                <a href="{{ url('admin/forgot-password') }}">
                    <small>Forgot password?</small>
                </a>
            </form>
        </div>
    </div>

    <!-- Footer links Start -->
    @include('admin.template.footer-scripts')
    <!-- End Footer links -->

    <script>
        $(document).ready(function() {
            $("#loginForm").validate({
                rules: {
                    Email: {
                        required: true,
                        lexemail: true,
                    },
                    Password: {
                        required: true,
                    }
                },
                messages: {
                    Email: {
                        required: adminMessage['msgEmailRequired'],
                    },
                    Password: {
                        required: adminMessage['msgPasswordRequired'],
                    }
                }
            });

            @if(Session::has('SuccessMessage'))
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 3000
                    };

                    toastr.success('{!! Session::get("SuccessMessage") !!}', '');
                }, 1000);
            @endif

            @if(Session::has('ErrorMessage'))
                setTimeout(function() {
                    toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        showMethod: 'slideDown',
                        timeOut: 3000
                    };

                    toastr.error('{!! Session::get("ErrorMessage") !!}', '');
                }, 1000);
            @endif
        });

        $.validator.addMethod("lexemail", function(value, element) {
          // allow any non-whitespace characters as the host part
          return this.optional( element ) || /^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test( value );
        }, adminMessage['msgValidEmail']);
    </script>
</body>
</html>