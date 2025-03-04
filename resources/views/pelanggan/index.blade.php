@extends('template.master')
@section('title', 'Pelanggan')
@section('content')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Tables</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Pelanggan</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <br>
                            <div id="alert-div"></div>
                            <h5 class="card-title">Datatables Pelanggan</h5>
                            <hr>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#basicModal" onclick="createPelanggans()">
                                Tambah
                            </button>
                            <hr>
                            <table id="pelanggans_table" class="table data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>
                                            <b>N</b>ama
                                        </th>
                                        <th>email</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="pelanggans_table_body">

                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <div class="modal" tabindex="-1" role="dialog" id="form-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pelanggan Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="error-div"></div>
                    <form>
                        <input type="hidden" name="update_id" id="update_id">
                        {{-- <select name="user_id" id="user_id" class="form-control">
                            <option value="">PILIH</option>
                            @foreach ($pelanggan as $users)
                                <option value="{{ $users->id }}">{{ $users->name }}</option>
                            @endforeach
                        </select> --}}
                        <div class="form-group">
                            <label for="nama_pelanggan" class="col-sm-2 col-form-label">Nama</label>
                            <input type="text" class="form-control" id="nama_pelanggan">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <input type="email" class="form-control" id="email"></input>
                        </div>
                        <div class="form-group">
                            <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                            <input type="number" class="form-control" id="telepon"></input>
                        </div>
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin">
                            <option value="laki-laki">Laki - Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                        <div class="form-group">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-15">
                                <textarea class="form-control" style="height: 100px" id="alamat"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary mt-3" id="save-pelanggans-btn">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal " tabindex="-1" role="dialog" id="view-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Pelanggan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <b>Nama:</b>
                    <p id="nama_pelanggan-info"></p>
                    <b>Email:</b>
                    <p id="email-info"></p>
                    <b>No telepon:</b>
                    <p id="telepon-info"></p>
                    <P>Jenis_kelamin</P>
                    <p id="jenis_kelamin-info"></p>
                    <b>alamat:</b>
                    <p id="alamat-info"></p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            $(function() {
                var baseUrl = $('meta[name=app-url]').attr("content");
                let url = baseUrl + '/pelanggans';

                $('#pelanggans_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: url,
                    "order": [
                        [0, "desc"]
                    ],
                    columns: [{
                            data: null,
                            orderable: false,
                            searchable: false
                        },

                        {
                            data: 'nama_pelanggan'
                        },
                        {
                            data: 'email'
                        },
                        {
                            data: 'action'
                        },
                    ],
                    order: [
                        [1, 'asc']
                    ],
                    drawCallback: function(settings) {
                        var api = this.api();
                        var startIndex = api.context[0]._iDisplayStart;
                        api.column(0, {
                            search: 'applied',
                            order: 'applied'
                        }).nodes().each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                    }

                });
            });


            function reloadTable() {
                $('#pelanggans_table').DataTable().ajax.reload();
            }

            $("#save-pelanggans-btn").click(function(event) {
                event.preventDefault();
                if ($("#update_id").val() == null || $("#update_id").val() == "") {
                    storePelanggans();
                } else {
                    updatePelanggans();
                }
            })

            function createPelanggans() {
                $("#alert-div").html("");
                $("#error-div").html("");
                $("#update_id").val("");
                $("#nama_pelanggan").val("");
                $("#email").val("");
                $("#telepon").val("");
                $("#jenis_kelamin").val("");
                $("#alamat").val("");
                $("#form-modal").modal('show');
            }

            function storePelanggans() {
                $("#save-pelanggans-btn").prop('disabled', true);
                let url = $('meta[name=app-url]').attr("content") + "/pelanggans";
                let data = {
                    nama_pelanggan: $("#nama_pelanggan").val(),
                    email: $("#email").val(),
                    telepon: $("#telepon").val(),
                    jenis_kelamin: $("#jenis_kelamin").val(),
                    alamat: $("#alamat").val(),
                };

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "POST",
                    data: data,
                    success: function(response) {
                        $("#save-pelanggans-btn").prop('disabled', false);
                        let
                            successHtml =
                            '<div class="alert alert-success" role="alert"><b>Pelanggan Berhasil Di Tambahkan</b></div>';
                        $("#alert-div").html(successHtml);
                        $("#nama_pelanggan").val("");
                        $("#email").val("");
                        $("#telepon").val("");
                        $("#jenis_kelamin").val("");
                        $("#alamat").val("");
                        reloadTable();
                        $("#form-modal").modal('hide');
                    },
                    error: function(response) {
                        $("#save-pelanggans-btn").prop('disabled', false);
                        if (typeof response.responseJSON.errors !== 'undefined') {
                            let errors = response.responseJSON.errors;
                            let errorHtml = '<div class="alert alert-danger" role="alert">' +
                                '<b>Kesalahan Validasi!</b>' +
                                '<ul>';

                            $.each(errors, function(key, value) {
                                $.each(value, function(index, message) {
                                    errorHtml += '<li>' + message + '</li>';
                                });
                            });

                            errorHtml += '</ul></div>';
                            $("#error-div").html(errorHtml);
                        }
                    }
                });
            }

            function showPelanggans(id) {
                $("#nama_pelanggan-info").html("");
                $("#email-info").html("");
                $("#telepon-info").html("");
                $("#jenis_kelamin").html("");
                $("#alamat-info").html("");
                let url = $('meta[name=app-url]').attr("content") + "/pelanggans/" + id + "";
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        let pelanggan = response.pelanggan;
                        $("#nama_pelanggan-info").html(pelanggan.nama_pelanggan);
                        $("#email-info").html(pelanggan.email);
                        $("#telepon-info").html(pelanggan.telepon);
                        $("#jenis_kelamin").html(pelanggan.jenis_kelamin);
                        $("#alamat-info").html(pelanggan.alamat);
                        $("#view-modal").modal('show');

                    },
                    error: function(response) {
                        console.log(response.responseJSON)
                    }
                });
            }

            function editPelanggans(id) {
                let url = $('meta[name=app-url]').attr("content") + "/pelanggans/" + id;
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        let pelanggan = response.pelanggan;
                        $("#alert-div").html("");
                        $("#error-div").html("");
                        $("#update_id").val(pelanggan.id);
                        $("#user_id").val(pelanggan.user_id);
                        $("#nama_pelanggan").val(pelanggan.nama_pelanggan);
                        $("#email").val(pelanggan.email);
                        $("#alamat").val(pelanggan.alamat);
                        $("#telepon").val(pelanggan.telepon);
                        $("#jenis_kelamin").val(pelanggan.jenis_kelamin);
                        $("#form-modal").modal('show');
                    },
                    error: function(response) {
                        console.log(response.responseJSON)
                    }
                });
            }

            function updatePelanggans() {
                $("#save-pelanggans-btn").prop('disabled', true);
                let url = $('meta[name=app-url]').attr("content") + "/pelanggans/" + $("#update_id").val();
                let data = {
                    id: $("#update_id").val(),
                    user_id: $("#user_id").val(),
                    nama_pelanggan: $("#nama_pelanggan").val(),
                    email: $("#email").val(),
                    telepon: $("#telepon").val(),
                    jenis_kelamin: $("#jenis_kelamin").val(),
                    alamat: $("#alamat").val(),
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "PUT",
                    data: data,
                    success: function(response) {
                        $("#save-pelanggans-btn").prop('disabled', false);
                        let successHtml =
                            '<div class="alert alert-success" role="alert"><b>Pelanggan Berhasil Di Perbarui</b></div>';
                        $("#alert-div").html(successHtml);
                        $("#user_id").val("");
                        $("#nama_pelanggan").val("");
                        $("#email").val("");
                        $("#telepon").val("");
                        $("#jenis_kelamin").val("");
                        $("#alamat").val("");
                        reloadTable();
                        $("#form-modal").modal('hide');
                    },
                    error: function(response) {
                        $("#save-pelanggans-btn").prop('disabled', false);
                        if (typeof response.responseJSON.errors !== 'undefined') {
                            let errors = response.responseJSON.errors;
                            let errorHtml = '<div class="alert alert-danger" role="alert">' +
                                '<b>Kesalahan Validasi!</b>' +
                                '<ul>';

                            $.each(errors, function(key, value) {
                                $.each(value, function(index, message) {
                                    errorHtml += '<li>' + message + '</li>';
                                });
                            });

                            errorHtml += '</ul></div>';
                            $("#error-div").html(errorHtml);
                        }
                    }
                });
            }

            function destroyPelanggans(id) {
                let result = Swal.fire({
                    title: "Apa Kamu Yakin?",
                    text: "Kamu Tidak Bisa Mengembalikan Ini!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") + "/pelanggans/" + id;
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url,
                            type: "DELETE",
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Data Kamu Berhasil Di Hapus.",
                                        icon: "success"
                                    });

                                    let successHtml =
                                        '<div class="alert alert-success" role="alert"><b>Pelanggan Berhasil Di Hapus</b></div>';
                                    $("#alert-div").html(successHtml);
                                    reloadTable();
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: "Terjadi Kesalahan Saat Hapus Pelanggan.",
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(response) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Terjadi Kesalahan Saat Hapus Pelanggan.",
                                    icon: "error"
                                });
                                console.log(response.responseJSON);
                            }
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection
