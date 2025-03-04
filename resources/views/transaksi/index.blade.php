@extends('template.master')
@section('title', 'Transaksi')
@section('content')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Data Tables</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Transaksi</li>
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
                            <h5 class="card-title">Datatables Transaksi</h5>
                            <hr>
                            <table id="transaksis_table" class="table datatable table-hover">
                                <thead>
                                    <tr>
                                        <th hidden>id</th>
                                        <th>No</th>
                                        <th>
                                            <b>N</b>ama
                                        </th>
                                        <th>Email</th>
                                        <th>Alamat</th>
                                        <th>No hp</th>
                                        <th>Catatan</th>
                                        <th>Pembayaran</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="transaksis_table_body">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <div id="orderDetailsModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Order Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="form-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Form Transaksi Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="error-div"></div>
                    <form>
                        @csrf
                        <input type="hidden" name="update_id" id="update_id">
                        {{-- <div class="form-group">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <input type="text" class="form-control" id="customer_name">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <input type="email" class="form-control" id="customer_email">
                        </div>
                        <div class="form-group">
                            <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                            <div class="col-sm-15">
                                <textarea class="form-control" style="height: 100px" id="shipping_address"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="no_telepon" class="col-sm-2 col-form-label">telepon</label>
                            <input type="number" class="form-control" id="no_hp"
                                placeholder="contoh: +8712xxxxxxx"></input>
                        </div>
                        <div class="form-group">
                            <label for="catatn" class="col-sm-2 col-form-label">Catatan</label>
                            <div class="col-sm-15">
                                <textarea class="form-control" style="height: 100px" id="catatan"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pembayaran" class="col-sm-2 col-form-label">Pembayaran</label>
                            <input type="text" class="form-control" id="jenis_pembayaran"></input>
                        </div>
                        <div class="form-group">
                            <label for="amount" class="col-sm-2 col-form-label">Total</label>
                            <input type="number" class="form-control" id="total_amount"></input>
                        </div> --}}
                        <div class="form-group">
                            <label class="col-sm-2 col-form-label">Status</label>
                            <div class="col-sm-15">
                                <select class="form-select form_control" id="status">
                                    <option value="">Pilih</option>
                                    <option value="belum_bayar">Belum Bayar</option>
                                    <option value="dikemas">Dikemas</option>
                                    <option value="dikirim">Dikirim</option>
                                    <option value="pengembalian">Pengembalian</option>
                                    <option value="selesai">Selesai</option>
                                    <option value="dibatalkan">Dibatalkan</option>
                                </select>
                            </div>
                            </label>
                        </div>
                        {{-- <button type="submit" class="btn btn-outline-primary mt-3"
                            id="save-transaksis-btn">Simpan</button> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            $(function() {
                var baseUrl = $('meta[name=app-url]').attr("content");
                let url = baseUrl + '/transaksi';

                // Inisialisasi DataTable
                var table = $('#transaksis_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: url,
                    order: [
                        [2, 'asc']
                    ],
                    columns: [{
                            data: 'id'
                        },
                        {
                            data: null, // Kolom nomor urut
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: 'customer_name'
                        },
                        {
                            data: 'customer_email'
                        },
                        {
                            data: 'shipping_address'
                        },
                        {
                            data: 'no_hp'
                        },
                        {
                            data: 'catatan'
                        },
                        {
                            data: 'jenis_pembayaran'
                        },
                        {
                            data: 'total_amount',
                            render: function(data, type) {
                                return type === 'display' ? 'Rp ' + Number(data).toLocaleString(
                                    'id-ID') : data;
                            }
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'action'
                        }
                    ],
                    order: [
                        [1, 'asc']
                    ],
                    drawCallback: function(settings) {
                        // Menginisialisasi Tabledit setelah tabel di-refresh
                        initTabledit();
                    }
                });

                // Setup CSRF Token untuk AJAX
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': $("input[name=_token]").val()
                    }
                });

                // Fungsi untuk inisialisasi Tabledit
                function initTabledit() {
                    if ($('#transaksis_table').length) { // Cek apakah tabel ada
                        $('#transaksis_table').Tabledit({
                            url: '{{ route('tabledit.action') }}',
                            editButton: false,
                            deleteButton: false,
                            hideIdentifier: true,
                            columns: {
                                identifier: [0, 'id'],
                                editable: [
                                    [9, 'status',
                                        '{"belum_bayar": "belum_bayar", "dikemas": "dikemas", "dikirim": "dikirim", "pengembalian": "pengembalian", "selesai": "selesai", "dibatalkan": "dibatalkan"}'
                                    ]
                                ]
                            },
                        });
                    }
                }

            });

            // Fungsi untuk reload DataTable
            function reloadTable() {
                $('#transaksis_table').DataTable().ajax.reload(null, false);
            }

            // Event untuk tombol simpan
            $("#save-transaksis-btn").click(function(event) {
                event.preventDefault();
                if ($("#update_id").val() == null || $("#update_id").val() == "") {
                    storeTransaksis();
                } else {
                    updateTransaksis();
                }
            });

            function showTransaksi(orderId) {
                let url = $('meta[name=app-url]').attr("content") + "/transaksi/" + orderId;
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        const orderItems = response.orderItems;
                        let details = `
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Owner</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
                        orderItems.forEach(item => {
                            let harga = item.product.harga;
                            let diskon = item.product.diskon;
                            let hargaSetelahDiskon = harga - (harga * (diskon / 100));

                            // Cek apakah ada diskon
                            let displayPrice = diskon > 0 ?
                                `<del>${Number(harga).toLocaleString('id-ID')}</del> <br> ${Number(hargaSetelahDiskon).toLocaleString('id-ID')}` :
                                Number(harga).toLocaleString('id-ID');

                            details += `
                    <tr>
                        <td><img src="/storage/images/${item.product.image}" alt="${item.product.image}" height="50" width="100"></td>
                        <td>${item.product.nama_product}</td>
                        <td>${item.quantity}</td>
                        <td>${displayPrice}</td>
                        <td>${item.user.name}</td>
                    </tr>
                `;
                        });
                        details += '</tbody></table>';
                        $('#orderDetailsModal .modal-body').html(details);
                        $('#orderDetailsModal').modal('show');
                    },
                    error: function(error) {
                        console.error('Error fetching order details:', error);
                    }
                });
            }

            function destroyTransaksi(id) {
                let result = Swal.fire({
                    title: "Apa Kamu yakin?",
                    text: "Kamu Tidak Bisa Mengembalikan Ini!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let url = $('meta[name=app-url]').attr("content") + "/transaksi/" + id;
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
                                        '<div class="alert alert-success" role="alert"><b>Transaksi Berhasil Di Hapus</b></div>';
                                    $("#alert-div").html(successHtml);
                                    reloadTable();
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: "Terjadi Kesalahan Saat Hapus Transaksi.",
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(response) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Terjadi Kesalahan Saat Hapus Transaksi.",
                                    icon: "error"
                                });
                                console.log(response.responseJSON);
                            }
                        });
                    }
                });
            }
            // function editTransaksis(id) {
            //     let url = $('meta[name=app-url]').attr("content") + "/transaksis/" + id;
            //     $.ajax({
            //         url: url,
            //         type: "GET",
            //         success: function(response) {
            //             let transaksi = response.transaksi;
            //             $("#alert-div").html("");
            //             $("#error-div").html("");
            //             $("#update_id").val(transaksi.id);
            //             $("#customer_name").val(transaksi.customer_name);
            //             $("#customer_email").val(transaksi.customer_email);
            //             $("#shipping_address").val(transaksi.shipping_address);
            //             $("#no_hp").val(transaksi.no_hp);
            //             $("#catatan").val(transaksi.catatan);
            //             $("#jenis_pembayaran").val(transaksi.jenis_pembayaran);
            //             $("#total_amount").val(transaksi.total_amount);
            //             $("#status").val(transaksi.status);
            //             $("#form-modal").modal('show');
            //         },
            //         error: function(response) {
            //             console.log(response.responseJSON)
            //         }
            //     });
            // }

            // function updateTransaksis() {
            //     $("#save-transaksis-btn").prop('disabled', true);
            //     let url = $('meta[name=app-url]').attr("content") + "/transaksis/" + $("#update_id").val();
            //     let data = {
            //         id: $("#update_id").val(),
            //         customer_name: $("#customer_name").val(),
            //         customer_email: $("#customer_email").val(),
            //         shipping_address: $("#shipping_address").val(),
            //         no_hp: $("#no_hp").val(),
            //         catatan: $("#catatan").val(),
            //         jenis_pembayaran: $("#jenis_pembayaran").val(),
            //         total_amount: $("#total_amount").val(),
            //         status: $("#status").val(),
            //     };
            //     $.ajax({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         },
            //         url: url,
            //         type: "PUT",
            //         data: data,
            //         success: function(response) {
            //             $("#save-transaksis-btn").prop('disabled', false);
            //             let successHtml =
            //                 '<div class="alert alert-success" role="alert"><b>Transaksi Berhasil Di Perbaharui</b></div>';
            //             $("#alert-div").html(successHtml);
            //             $("#customer_name").val("");
            //             $("#customer_email").val("");
            //             $("#shipping_address").val("");
            //             $("#no_hp").val("");
            //             $("#catatan").val("");
            //             $("#jenis_pembayaran").val("");
            //             $("#total_amount").val("");
            //             $("#status").val("");
            //             reloadTable();
            //             $("#form-modal").modal('hide');
            //         },
            //         error: function(response) {
            //             $("#save-transaksis-btn").prop('disabled', false);
            //             if (typeof response.responseJSON.errors !== 'undefined') {
            //                 let errors = response.responseJSON.errors;
            //                 let errorHtml = '<div class="alert alert-danger" role="alert">' +
            //                     '<b>Kesalahan Validasi!</b>' +
            //                     '<ul>';

            //                 $.each(errors, function(key, value) {
            //                     $.each(value, function(index, message) {
            //                         errorHtml += '<li>' + message + '</li>';
            //                     });
            //                 });

            //                 errorHtml += '</ul></div>';
            //                 $("#error-div").html(errorHtml);
            //             }
            //         }
            //     });
            // }

            function printTransaksi(slug) {
                // Ambil nilai URL dasar dari meta tag
                let baseUrl = document.querySelector('meta[name="app-url"]').getAttribute("content");
                let url = `${baseUrl}/generate-pdf/stream/${slug}`;

                // Melakukan permintaan Ajax ke server
                fetch(url, {
                        method: 'GET',
                    })
                    .then(response => {
                        if (!response.ok) {
                            // Jika respon tidak OK, lemparkan error
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        // Membuka PDF di tab baru
                        window.open(url, '_blank');
                        alert('Transaksi berhasil dicetak!');
                    })
                    .catch(error => {
                        // Menampilkan pesan error jika terjadi kesalahan
                        alert(`Terjadi kesalahan: ${error.message}`);
                    });
            }
        </script>
    @endpush
@endsection
