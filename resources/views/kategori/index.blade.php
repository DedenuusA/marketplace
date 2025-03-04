@extends('template.master')
@section('title', 'Kategori')
@section('content')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Data Tables</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Kategori</li>
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
                            <h5 class="card-title">Datatables Kategori</h5>
                            <hr>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#basicModal" onclick="createKategoris()">
                                Tambah
                            </button>
                            <hr>
                            <table id="kategoris_table" class="table data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>
                                            <b>N</b>ama Kategori
                                        </th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="kategoris_table_body">

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
                    <h5 class="modal-title">Kategori Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="error-div"></div>
                    <form>
                        @csrf
                        <input type="hidden" name="update_id" id="update_id">
                        <select class="form-control" id="user_id">
                            <option value="">Nama</option>
                            @foreach ($kategori as $users)
                                <option value="{{ $users->id }}" {{ $users->id == $selectedUserId ? 'selected' : '' }}>
                                    {{ $users->name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <select class="form-control" id="toko_id">
                            <option value="">Toko</option>
                            @foreach ($toko as $tokos)
                                <option value="{{ $tokos->id }}">{{ $tokos->nama_toko }}</option>
                            @endforeach
                        </select>
                        <div class="form-group">
                            <label for="nama_kategori" class="col-sm-2 col-form-label">Kategori</label>
                            <input type="text" class="form-control" id="nama_kategori"
                                placeholder="masukan nama kategori">
                        </div>
                        <button type="submit" class="btn btn-outline-primary mt-3" id="save-kategoris-btn">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal " tabindex="-1" role="dialog" id="view-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <b>Nama Kategori:</b>
                    <p id="nama_kategori-info"></p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            $(function() {
                var baseUrl = $('meta[name=app-url]').attr("content");
                let url = baseUrl + '/kategoris';

                $('#kategoris_table').DataTable({
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
                            data: 'nama_kategori'
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
                $('#kategoris_table').DataTable().ajax.reload(null, false);
            }

            $("#save-kategoris-btn").click(function(event) {
                event.preventDefault();
                if ($("#update_id").val() == null || $("#update_id").val() == "") {
                    storeKategoris();
                } else {
                    updateKategoris();
                }
            })

            function createKategoris() {
                $("#alert-div").html("");
                $("#error-div").html("");
                $("#update_id").val("");
                $("#user_id").val({{ $selectedUserId }}).trigger('change');
                $("#toko_id").val("");
                $("#nama_kategori").val("");
                $("#form-modal").modal('show');
            }

            function storeKategoris() {
                $("#save-kategoris-btn").prop('disabled', true);
                let url = $('meta[name=app-url]').attr("content") + "/kategoris";
                let data = {
                    user_id: $("#user_id").val(),
                    toko_id: $("#toko_id").val(),
                    nama_kategori: $("#nama_kategori").val(),

                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "POST",
                    data: data,
                    success: function(response) {
                        $("#save-kategoris-btn").prop('disabled', false);
                        let successHtml =
                            '<div class="alert alert-success" role="alert"><b>Kategori Berhasil Di Tambahkan</b></div>';
                        $("#alert-div").html(successHtml);
                        $("#user_id").val("");
                        $("#toko_id").val("");
                        $("#nama_kategori").val("");
                        $("#form-modal").modal('hide');
                        reloadTable();
                    },
                    error: function(response) {
                        $("#save-kategoris-btn").prop('disabled', false);
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

            function showKategoris(id) {
                $("#nama_kategori-info").html("");
                let url = $('meta[name=app-url]').attr("content") + "/kategoris/" + id + "";
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        let kategori = response.kategori;
                        $("#nama_kategori-info").html(kategori.nama_kategori);
                        $("#view-modal").modal('show');

                    },
                    error: function(response) {
                        console.log(response.responseJSON)
                    }
                });
            }

            function editKategoris(id) {
                let url = $('meta[name=app-url]').attr("content") + "/kategoris/" + id;
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        let kategori = response.kategori;
                        $("#alert-div").html("");
                        $("#error-div").html("");
                        $("#update_id").val(kategori.id);
                        $("#user_id").val(kategori.user_id);
                        $("#toko_id").val(kategori.toko_id);
                        $("#nama_kategori").val(kategori.nama_kategori);
                        $("#form-modal").modal('show');
                    },
                    error: function(response) {
                        console.log(response.responseJSON)
                    }
                });
            }

            function updateKategoris() {
                $("#save-kategoris-btn").prop('disabled', true);
                let url = $('meta[name=app-url]').attr("content") + "/kategoris/" + $("#update_id").val();
                let data = {
                    id: $("#update_id").val(),
                    user_id: $("#user_id").val(),
                    toko_id: $("#toko_id").val(),
                    nama_kategori: $("#nama_kategori").val(),
                };
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "PUT",
                    data: data,
                    success: function(response) {
                        $("#save-kategoris-btn").prop('disabled', false);
                        let successHtml =
                            '<div class="alert alert-success" role="alert"><b>Kategori Berhasil Di Perbarui</b></div>';
                        $("#alert-div").html(successHtml);
                        $("#user_id").val("");
                        $("#toko_id").val("");
                        $("#nama_kategori").val("");
                        reloadTable();
                        $("#form-modal").modal('hide');
                    },
                    error: function(response) {
                        $("#save-kategoris-btn").prop('disabled', false);
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

            function destroyKategoris(id) {
                let result = Swal.fire({
                    title: "Apa Kamu Yakin?",
                    text: "Kamu Tidak Bisa Mengambalikan ini!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") + "/kategoris/" + id;
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
                                        '<div class="alert alert-success" role="alert"><b>Kategori Berhasil Di Hapus</b></div>';
                                    $("#alert-div").html(successHtml);
                                    reloadTable();
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: "Terjadi Kesalahan Saat Mengahpus Kategori.",
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(response) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Terjadi Kesalahan Saat Mengahpus Kategori.",
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
