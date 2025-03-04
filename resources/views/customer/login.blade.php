<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">


    <style>
        body {
            background: #456;
            font-family: 'Open Sans', sans-serif;

        }

        .center {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            flex: 1 0 100%;
        }

        .login {
            width: 400px;
            height: 300px;
            margin: 16px auto;
            font-size: 16px;

        }

        .login-header,
        .login p {
            margin-top: 0;
            margin-bottom: 0;
        }

        .login-header {
            background: #28d;
            padding: 20px;
            font-size: 1.4em;
            font-weight: normal;
            text-align: center;
            text-transform: uppercase;
            color: #fff;
        }

        .login-container {
            background: #ebebeb;
            padding: 12px;
        }

        .login p {
            padding: 12px;
        }

        .login input {
            box-sizing: border-box;
            display: block;
            width: 100%;
            border-width: 1px;
            border-style: solid;
            padding: 16px;
            outline: 0;
            font-family: inherit;
            font-size: 0.95em;
        }

        .login input[type="email"],
        .login input[type="password"] {
            background: #fff;
            border-color: #bbb;
            color: #555;
        }

        .login input[type="email"]:focus,
        .login input[type="password"]:focus {
            border-color: #888;
        }

        .login input[type="submit"] {
            background: #28d;
            border-color: transparent;
            color: #fff;
            cursor: pointer;
        }

        .login input[type="submit"]:hover {
            background: #17c;
        }

        .login input[type="submit"]:focus {
            border-color: #05a;
        }

        .btn {
            cursor: pointer;
            background-color: cornflowerblue;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="center">
        <div class="login">
            <h2 class="login-header">Form Login</h2>
            <form class="login-container">
                @csrf
                <p>
                    <input type="email" id="email" placeholder="Email">
                </p>
                <p>
                    <input type="password" id="password" placeholder="Password">
                </p>
                <p>
                    <input type="button" class="btn btn-login" value="LOG IN">
                </p>
                <p>Belum Punya Akun?<a href="{{ route('customer.register') }}"> Register</a></p>
            </form>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {

            $(".btn-login").click(function() {

                var email = $("#email").val();
                var password = $("#password").val();
                var token = $("meta[name='csrf-token']").attr("content");

                if (email.length == "") {

                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Alamat Email Wajib Diisi !'
                    });

                } else if (password.length == "") {

                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Password Wajib Diisi !'
                    });

                } else {

                    $.ajax({

                        url: "{{ route('customer.check_login') }}",
                        type: "POST",
                        dataType: "JSON",
                        cache: false,
                        data: {
                            "email": email,
                            "password": password,
                            "_token": token
                        },

                        success: function(response) {

                            if (response.success) {

                                Swal.fire({
                                    type: 'success',
                                    title: 'Login Berhasil!',
                                    text: 'Anda akan di arahkan dalam 3 Detik',
                                    timer: 3000,
                                    showCancelButton: false,
                                    showConfirmButton: false
                                }).then(function() {
                                    var redirectUrl = sessionStorage.getItem(
                                            'redirectUrl') ||
                                        "{{ route('market_place.index') }}";
                                    window.location.href = redirectUrl;
                                });

                            } else {

                                Swal.fire({
                                    type: 'error',
                                    title: 'Login Gagal!',
                                    text: 'Silahkan coba lagi!'
                                });

                            }

                        },

                        error: function(response) {

                            Swal.fire({
                                type: 'error',
                                title: 'Oops!',
                                text: 'Buat Akun Dulu!'
                            });

                        }

                    });

                }

            });

        });
    </script>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    type: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    type: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif
</body>

</html>
