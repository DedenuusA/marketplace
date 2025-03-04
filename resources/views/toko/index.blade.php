@extends('template.master')
@section('title', 'Toko')
@section('content')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Tables</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Toko</li>
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
                            <h5 class="card-title">Datatables Toko</h5>
                            <hr>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#basicModal" onclick="createTokos()">
                                Tambah
                            </button>
                            <hr>
                            <table id="tokos_table" class="table datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>
                                            <b>N</b>ama Toko
                                        </th>
                                        <th>no telepon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="tokos_table_body">

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
                    <h5 class="modal-title">Toko Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="error-div"></div>
                    <form>
                        @csrf
                        <input type="hidden" name="update_id" id="update_id">
                        <select class="form-control" id="user_id">
                            <option value="">nama</option>
                            @foreach ($toko as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $selectedUserId ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-group">
                            <label for="nama_toko" class="col-sm-2 col-form-label">Toko</label>
                            <input type="text" class="form-control" id="nama_toko">
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-15">
                                <textarea class="form-control" style="height: 100px" id="alamat"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="no_telepon" class="col-sm-2 col-form-label">telepon</label>
                            <input type="number" class="form-control" id="no_telepon"
                                placeholder="contoh: +8712xxxxxxx"></input>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <input type="email" class="form-control" id="email"></input>
                        </div>
                        <div class="form-group">
                            <label for="nama_owner" class="col-sm-2 col-form-label">Owner</label>
                            <input type="text" class="form-control" id="nama_owner"></input>
                        </div>
                        <button type="submit" class="btn btn-outline-primary mt-3" id="save-tokos-btn">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal " tabindex="-1" role="dialog" id="view-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Toko</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <b>Nama Toko:</b>
                    <p id="nama_toko-info"></p>
                    <b>Alamat:</b>
                    <p id="alamat-info"></p>
                    <b>No telepon:</b>
                    <p id="no_telepon-info"></p>
                    <b>Email:</b>
                    <p id="email-info"></p>
                    <b>Nama Owner:</b>
                    <p id="nama_owner-info"></p>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script type="text/javascript">
            $(function() {
                var baseUrl = $('meta[name=app-url]').attr("content");
                let url = baseUrl + '/tokos';

                $('#tokos_table').DataTable({
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
                            data: 'nama_toko'
                        },
                        {
                            data: 'no_telepon'
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
                $('#tokos_table').DataTable().ajax.reload();
            }

            $("#save-tokos-btn").click(function(event) {
                event.preventDefault();
                if ($("#update_id").val() == null || $("#update_id").val() == "") {
                    storeTokos();
                } else {
                    updateTokos();
                }
            })

            function createTokos() {
                $("#alert-div").html("");
                $("#error-div").html("");
                $("#update_id").val("");
                $("#user_id").val({{ $selectedUserId }}).trigger('change');
                $("#nama_toko").val("");
                $("#alamat").val("");
                $("#no_telepon").val("");
                $("#email").val("");
                $("#nama_owner").val("");
                $("#form-modal").modal('show');
            }

            function storeTokos() {
                $("#save-tokos-btn").prop('disabled', true);
                let url = $('meta[name=app-url]').attr("content") + "/tokos";
                let data = {
                    user_id: $("#user_id").val(),
                    nama_toko: $("#nama_toko").val(),
                    alamat: $("#alamat").val(),
                    no_telepon: $("#no_telepon").val(),
                    email: $("#email").val(),
                    nama_owner: $("#nama_owner").val(),
                };

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "POST",
                    data: data,
                    success: function(response) {
                        $("#save-tokos-btn").prop('disabled', false);
                        let
                            successHtml =
                            '<div class="alert alert-success" role="alert"><b>Toko Berhasil Di Tambahkan</b></div>';
                        $("#alert-div").html(successHtml);
                        $("#user_id").val("");
                        $("#nama_toko").val("");
                        $("#alamat").val("");
                        $("#no_telepon").val("");
                        $("#email").val("");
                        $("#nama_owner").val("");
                        $("#form-modal").modal('hide');
                        reloadTable();
                    },

                    error: function(response) {
                        $("#save-tokos-btn").prop('disabled', false);
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

            function showTokos(id) {
                $("#nama_toko-info").html("");
                let url = $('meta[name=app-url]').attr("content") + "/tokos/" + id + "";
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        let toko = response.toko;
                        $("#nama_toko-info").html(toko.nama_toko);
                        $("#alamat-info").html(toko.alamat);
                        $("#no_telepon-info").html(toko.no_telepon);
                        $("#email-info").html(toko.email);
                        $("#nama_owner-info").html(toko.nama_owner);
                        $("#view-modal").modal('show');

                    },
                    error: function(response) {
                        console.log(response.responseJSON)
                    }
                });
            }

            function editTokos(id) {
                let url = $('meta[name=app-url]').attr("content") + "/tokos/" + id;
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        let toko = response.toko;
                        $("#alert-div").html("");
                        $("#error-div").html("");
                        $("#update_id").val(toko.id);
                        $("#user_id").val(toko.user_id);
                        $("#nama_toko").val(toko.nama_toko);
                        $("#alamat").val(toko.alamat);
                        $("#no_telepon").val(toko.no_telepon);
                        $("#email").val(toko.email);
                        $("#nama_owner").val(toko.nama_owner);
                        $("#form-modal").modal('show');
                    },
                    error: function(response) {
                        console.log(response.responseJSON)
                    }
                });
            }

            function updateTokos() {
                $("#save-tokos-btn").prop('disabled', true);
                let url = $('meta[name=app-url]').attr("content") + "/tokos/" + $("#update_id").val();
                let data = {
                    id: $("#update_id").val(),
                    user_id: $("#user_id").val(),
                    nama_toko: $("#nama_toko").val(),
                    alamat: $("#alamat").val(),
                    no_telepon: $("#no_telepon").val(),
                    email: $("#email").val(),
                    nama_owner: $("#nama_owner").val(),
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "PUT",
                    data: data,
                    success: function(response) {
                        $("#save-tokos-btn").prop('disabled', false);
                        let successHtml =
                            '<div class="alert alert-success" role="alert"><b>Toko Berhasil Di Perbaharui</b></div>';
                        $("#alert-div").html(successHtml);
                        $("#user_id").val("");
                        $("#nama_toko").val("");
                        $("#alamat").val("");
                        $("#no_telepon").val("");
                        $("#email").val("");
                        $("#nama_owner").val("");
                        reloadTable();
                        $("#form-modal").modal('hide');
                    },
                    error: function(response) {
                        $("#save-tokos-btn").prop('disabled', false);
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

            function destroyTokos(id) {
                let result = Swal.fire({
                    title: "Apa Kamu Yakin?",
                    text: "Kamu Tidak Bisa Mengembalikan ini!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") + "/tokos/" + id;
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
                                        text: "Data kamu berhasil Di Hapus.",
                                        icon: "success"
                                    });

                                    let successHtml =
                                        '<div class="alert alert-success" role="alert"><b>Toko Berhasil Di Hapus</b></div>';
                                    $("#alert-div").html(successHtml);
                                    reloadTable();
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: "Terjadi Kesalahan Saat Menghapus Toko.",
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(response) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Terjadi Kesalahan Saat Menghapus Toko.",
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
