<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" nama="viewport">

    <title>Register</title>
    <meta nama="csrf-token" content="{{ csrf_token() }}">
    <meta content="" nama="description">
    <meta content="" nama="keywords">

    <style>
        body {
            background: #456;
            font-family: 'Open Sans', sans-serif;

        }

        .center {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 45%;
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

        .custom-select {
            border-width: 350px;
        }

        .custom-select select {
            appearance: none;
            width: 100%;
            font-size: 1.15rem;
            padding: 0.675em 6em 0.675em 1em;
            background-color: #fff;
            border: 1px solid #caced1;
            border-radius: 0.25rem;
            color: #000;
            cursor: pointer;
        }
        textarea {
            width: 100%;
            height: 150px;
            padding: 12px 20px;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            background-color: #f8f8f8;
            font-size: 16px;
            resize: none;
        }
    </style>
</head>

<div class="center">
    <div class="login">
        <h2 class="login-header">Form Register</h2>
        <form class="login-container">
            @csrf
            <div class="custom-select">
                <p>
                    <input type="text" id="nama" placeholder="Masukan Nama Anda">
                </p>
                <p>
                    <input type="email" id="email" placeholder="Masukan Email Anda">
                </p>
                <p>
                    <input type="password" id="password" placeholder="Masukan Password Anda">
                </p>
                <p>
                    <input type="number" id="phone_number" placeholder="Masukan No Telepon Anda">
                </p>
                <p>
                    <select id="jenis_kelamin">
                        <option>Pilih</option>
                        <option value="laki-laki">Laki - Laki</option>
                        <option value="perempuan">Perempuan</option>
                    </select>
                </p>
                <p>
                    <textarea id="alamat" cols="43" rows="5" placeholder="Masukan Alamat Lengkap"></textarea>
                </p>
                <p>
                    <input type="button" class="btn btn-register" id="" value="REGISTER">
                </p>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {

        $(".btn-register").click(function() {

            var nama = $("#nama").val();
            var email = $("#email").val();
            var password = $("#password").val();
            var phone_number = $("#phone_number").val();
            var jenis_kelamin = $("#jenis_kelamin").val();
            var alamat = $("#alamat").val();
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

                $.ajax({

                    url: "{{ route('customer.store') }}",
                    type: "POST",
                    cache: false,
                    data: {
                        "nama": nama,
                        "email": email,
                        "password": password,
                        "phone_number": phone_number,
                        "jenis_kelamin": jenis_kelamin,
                        "alamat": alamat,
                        "_token": token
                    },

                    success: function(response) {
                        console.log(response)
                        if (response.success) {

                            Swal.fire({
                                type: 'success',
                                title: 'Register Berhasil!',
                                text: 'silahkan login!'
                            }).
                            then(function() {
                                window.location.href =
                                    "{{ route('customer.login') }}";
                            });

                            $("#nama").val('');
                            $("#email").val('');
                            $("#password").val('');
                            $("#phone_number").val('');
                            $("#jenis_kelamin").val('');
                            $("#alamat").val('');

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
