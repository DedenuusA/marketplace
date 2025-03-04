<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" nama="viewport">

    <title>Register</title>
    <meta nama="csrf-token" content="{{ csrf_token() }}">
    <meta content="" nama="description">
    <meta content="" nama="keywords">

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
                            </div>

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Buat Akun Anda</h5>
                                    </div>

                                    <form class="row g-3 needs-validation" novalidate>
                                        <div class="col-12">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" class="form-control" id="nama" required>
                                            <div class="invalid-feedback">Masukan Nama Anda!</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" class="form-control" id="email" required>
                                                <div class="invalid-feedback">Masukan Email Anda.</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" required>
                                            <div class="invalid-feedback">Masukan Password Anda!</div>
                                        </div>
                                        <div class="col-12">
                                            <label for="no_telepon" class="form-label">No HP</label>
                                            <input type="number" class="form-control" id="no_telepon" required>
                                            <div class="invalid-feedback">Masukan No Telepon Anda!</div>
                                        </div>
                                        <div class="col-12">
                                            <option>Kelamin</option>
                                            <select id="jenis_kelamin" class="form-control">
                                                <option>Pilih</option>
                                                <option value="laki-laki">Laki - Laki</option>
                                                <option value="perempuan">Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-register btn-block btn-primary w-100"
                                                type="button">Buat
                                                Akun</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Sudah Punya Akun? <a
                                                    href="{{ route('login.index') }}">Log
                                                    in</a></p>
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

            $(".btn-register").click(function() {

                var nama = $("#nama").val();
                var email = $("#email").val();
                var password = $("#password").val();
                var no_telepon = $("#no_telepon").val();
                var jenis_kelamin = $("#jenis_kelamin").val();
                var token = $("meta[nama='csrf-token']").attr("content");

                if (nama.length == "") {

                    Swal.fire({
                        type: 'warning',
                        title: 'Oops...',
                        text: 'Nama Lengkap Wajib Diisi !'
                    });

                } else if (email.length == "") {

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

                    //ajax
                    $.ajax({

                        url: "{{ route('register.store') }}",
                        type: "POST",
                        cache: false,
                        data: {
                            "nama": nama,
                            "email": email,
                            "password": password,
                            "no_telepon": no_telepon,
                            "jenis_kelamin": jenis_kelamin,
                            "_token": token
                        },

                        success: function(response) {

                            if (response.success) {

                                Swal.fire({
                                    type: 'success',
                                    title: 'Register Berhasil!',
                                    text: 'silahkan login!'
                                }).
                                then(function() {
                                    window.location.href = "{{ route('login.index') }}";
                                });

                                $("#nama").val('');
                                $("#email").val('');
                                $("#password").val('');
                                $("#no_telepon").val('');
                                $("#jenis_kelamin").val('');

                            } else {

                                Swal.fire({
                                    type: 'error',
                                    title: 'Register Gagal!',
                                    text: 'silahkan coba lagi!'
                                });

                            }

                            console.log(response);

                        },

                        error: function(response) {
                            Swal.fire({
                                type: 'error',
                                title: 'Opps!',
                                text: 'email anda sudah terdaftar!'
                            });
                        }

                    })

                }

            });

        });
    </script>

</body>

</html>
