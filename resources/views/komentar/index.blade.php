@extends('template.master')
@section('title', 'Komentar')
@section('content')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>DataTable</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Komentar</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Datatables</h5>
                            <table class="table data-table" id="komentar_table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>
                                            <b>N</b>ama
                                        </th>
                                        <th>email</th>
                                        <th>pesan</th>
                                        <th>Tgl</th>
                                        <th>Delete</th>

                                    </tr>
                                </thead>
                                <tbody id="komentar_table_body">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('scripts')
        <script type="text/javascript">
            $(function() {
                var baseUrl = $('meta[name=app-url]').attr("content");
                let url = baseUrl + '/view';

                $('#komentar_table').DataTable({
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
                            data: 'nama'
                        },
                        {
                            data: 'email'
                        },
                        {
                            data: 'pesan'
                        },
                        {
                            data: 'created_at'
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
                $('#komentar_table').DataTable().ajax.reload();
            }

            function destroyKomentars(id) {
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
                        let url = $('meta[name=app-url]').attr("content") + "/komentar/" + id;
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
                                        '<div class="alert alert-success" role="alert"><b>Komentar Berhasil Di Hapus</b></div>';
                                    $("#alert-div").html(successHtml);
                                    reloadTable();
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: "Terjadi Kesalahan Saat Hapus Komentar.",
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(response) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Terjadi Kesalahan Saat Hapus Komentar.",
                                    icon: "error"
                                });

                            }
                        });
                    }
                });
            }
        </script>
    @endpush
@endsection
