<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="templateadmin/assets/img/favicon.png" rel="icon">
    <link href="templateadmin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="templateadmin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="templateadmin/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="templateadmin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="templateadmin/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="templateadmin/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="templateadmin/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="templateadmin/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="templateadmin/assets/css/style.css" rel="stylesheet">

</head>

<body>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="templateadmin/assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">Market Place</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login ke akun anda</h5>
                                    </div>

                                    <form class="row g-3 needs-validation" novalidate>

                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" class="form-control" id="email" required>
                                                <div class="invalid-feedback">Masukan email anda.</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" required>
                                            <div class="invalid-feedback">Masukan password anda!</div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-login btn-block btn-primary w-100"
                                                type="button">Login</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Belum punya akun? <a
                                                    href="{{ route('register.index') }}">Buat
                                                    akun anda</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>

    <script src="templateadmin/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="templateadmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="templateadmin/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="templateadmin/assets/vendor/echarts/echarts.min.js"></script>
    <script src="templateadmin/assets/vendor/quill/quill.js"></script>
    <script src="templateadmin/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="templateadmin/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="templateadmin/assets/vendor/php-email-form/validate.js"></script>

    <script src="templateadmin/assets/js/main.js"></script>

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

                        url: "{{ route('login.check_login') }}",
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
                                    window.location.href =
                                        "{{ route('dashboard.index') }}";
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
                    timer: 3000, // Optional: auto-close after 3 seconds
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
                    timer: 3000, // Optional: auto-close after 3 seconds
                    showConfirmButton: false
                });
            });
        </script>
    @endif
</body>

</html>
