@extends('template.master')
@section('title', 'Product')
@section('content')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Data Tables</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Product</li>
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
                            <h5 class="card-title">Datatables Product</h5>
                            <hr>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#basicModal" onclick="createProducts()">
                                Tambah
                            </button>
                            <hr>
                            <table id="products_table" class="table data-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>
                                            <b>N</b>ama product
                                        </th>
                                        {{-- <th>Harga</th> --}}
                                        <th>Harga Jual</th>
                                        <th>Stok</th>
                                        <th>Gambar</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="products_table_body">

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
                    <h5 class="modal-title">Product Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="error-div"></div>
                    <form>
                        @csrf
                        <input type="hidden" name="update_id" id="update_id">
                        <select id="user_id" class="form-control">
                            <option value="">Nama</option>
                            @foreach ($product as $user)
                                <option value="{{ $user->id }}" {{ $user->id == $selectedUserId ? 'selected' : '' }}>
                                    {{ $user->name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <select id="toko_id" class="form-control">
                            <option value="">Toko</option>
                            @foreach ($toko as $tokos)
                                <option value="{{ $tokos->id }}">{{ $tokos->nama_toko }}</option>
                            @endforeach
                        </select>
                        <br>
                        <select id="kategori_id" class="form-control">
                            <option value="">Kategori</option>
                            @foreach ($kategori as $kategoris)
                                <option value="{{ $kategoris->id }}">{{ $kategoris->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <div class="form-group">
                            <label for="nama_product" class="col-sm-2 col-form-label">Product</label>
                            <input id="nama_product" type="text" class="form-control" placeholder="masukan nama product">
                        </div>
                        <div class="form-group">
                            <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                            <textarea id="deskripsi" type="text" class="form-control" cols="43" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="harga" class="col-sm-2 col-form-label">Harga</label>
                            <input id="harga" type="number" class="form-control" step="0.01" min="0">
                        </div>
                        <div class="form-group">
                            <label for="diskon" class="col-sm-2 col-form-label">Diskon %</label>
                            <input type="number" id="diskon" class="form-control"
                                placeholder="Contoh 50 (opsional) Jika tidak ada isi 0">
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-form-label">Kondisi</label>
                            <div class="col-sm-15">
                                <select id="kondisi" class="form-control">
                                    <option value="">Pilih</option>
                                    <option value="baru">Baru</option>
                                    <option value="bekas">Bekas</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="col-sm-2 col-form-label">Gambar</label>
                            <div class="col-sm-15">
                                <input id="image" class="form-control" type="file">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="deskripsi" class="col-sm-2 col-form-label">Stok</label>
                            <input id="stok" type="number" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-outline-primary mt-3"
                            id="save-products-btn">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal " tabindex="-1" role="dialog" id="view-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Informasi Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <b>Nama product:</b>
                    <p id="nama_product-info"></p>
                    <b>Deskripsi:</b>
                    <p id="deskripsi-info"></p>
                    <b>Kondisi:</b>
                    <p id="kondisi-info"></p>
                    <b>Harga:</b>
                    <p id="harga-info"></p>
                    <b>Harga Jual:</b>
                    <p id="harga-jual-info"></p>
                    <b>Diskon % :</b>
                    <p id="diskon-info"></p>
                    <b>Stok:</b>
                    <p id="stok-info"></p>
                    <b>Gambar:</b>
                    <p id="image-info"></p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            $(function() {
                var baseUrl = $('meta[name=app-url]').attr("content");
                let url = baseUrl + '/products';

                $('#products_table').DataTable({
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
                            data: 'nama_product'
                        },
                        // {
                        //     data: 'harga',
                        //     render: function(data, type, row) {
                        //         if (type === 'display') {
                        //             return 'Rp ' + Number(data).toLocaleString('id-ID');
                        //         }
                        //         return data;
                        //     }
                        // },
                        {
                            data: 'hasil'
                        },
                        {
                            data: 'stok'
                        },
                        {
                            data: 'image',
                            render: function(data, type, full, meta) {
                                return '<img src="/storage/images/' + data + '" height="50" />';
                            }
                        },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false
                        }
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
                $('#products_table').DataTable().ajax.reload(null, false);
            }

            $("#save-products-btn").click(function(event) {
                event.preventDefault();
                if ($("#update_id").val() == null || $("#update_id").val() == "") {
                    storeProducts();
                } else {
                    updateProducts();
                }
            })

            function createProducts() {
                $("#alert-div").html("");
                $("#error-div").html("");
                $("#update_id").val("");
                $("#user_id").val({{ $selectedUserId }}).trigger('change');
                $("#toko_id").val("");
                $("#kategori_id").val("");
                $("#nama_product").val("");
                $("#deskripsi").val("");
                $("#harga").val("");
                $("#diskon").val("");
                $("#kondisi").val("");
                $("#image").val("");
                $("#stok").val("");
                $("#form-modal").modal('show');
            }

            function storeProducts() {
                $("#save-products-btn").prop('disabled', true);
                let baseUrl = $('meta[name=app-url]').attr("content");
                let url = baseUrl + "/products";

                let formData = new FormData();
                formData.append('user_id', $("#user_id").val());
                formData.append('toko_id', $("#toko_id").val());
                formData.append('kategori_id', $("#kategori_id").val());
                formData.append('nama_product', $("#nama_product").val());
                formData.append('deskripsi', $("#deskripsi").val());
                formData.append('harga', $("#harga").val());
                formData.append('diskon', $("#diskon").val());
                formData.append('kondisi', $("#kondisi").val());


                if ($('#image')[0].files.length > 0) {
                    formData.append('image', $('#image')[0].files[0]);
                }
                formData.append('stok', $("#stok").val());
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: url,
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#save-products-btn").prop('disabled', false);
                        let successHtml =
                            '<div class="alert alert-success" role="alert"><b>Product Berhasil Di Tambahkan</b></div>';
                        $("#alert-div").html(successHtml);
                        $("#user_id").val("");
                        $("#toko_id").val("");
                        $("#kategori_id").val("");
                        $("#nama_product").val("");
                        $("#deskripsi").val("");
                        $("#harga").val("");
                        $("#diskon").val("");
                        $("#kondisi").val("");
                        $("#image").val("");
                        $("#stok").val("");
                        $("#form-modal").modal('hide');
                        reloadTable();
                    },
                    error: function(response) {
                        $("#save-products-btn").prop('disabled', false);
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

            function showProducts(id) {
                $("#nama_product-info").html("");
                $("#deskripsi-info").html("");
                $("#kondisi-info").html("");
                $("#harga-info").html("");
                $("#harga-jual-info").html("");
                $("#diskon-info").html("");
                $("#stok-info").html("");
                $("#image-info").html("");
                let url = $('meta[name=app-url]').attr("content") + "/products/" + id + "";
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        let product = response.product;
                        let harga = product.harga ? parseFloat(product.harga) : 0;
                        let diskon = product.diskon ? parseFloat(product.diskon) : 0;

                        let hargaSetelahDiskon = harga;
                        if (diskon > 0) {
                            hargaSetelahDiskon = harga - (harga * diskon / 100);
                        }
                        $("#nama_product-info").html(product.nama_product);
                        $("#deskripsi-info").html(product.deskripsi);
                        $("#kondisi-info").html(product.kondisi);
                        $("#harga-info").html("Rp " + new Intl.NumberFormat().format(product.harga));
                        $("#harga-jual-info").html("Rp " + new Intl.NumberFormat().format(hargaSetelahDiskon));
                        $("#diskon-info").html(product.diskon + "%");
                        $("#stok-info").html(product.stok > 0 ? product.stok + " tersedia" : "SOLD OUT");
                        $("#image-info").html('<img src="/storage/images/' + product.image +
                            '" height="50" alt="Product Image" />');
                        $("#view-modal").modal('show');

                    },
                    error: function(response) {
                        console.log(response.responseJSON)
                    }
                });
            }

            function editProducts(id) {

                let url = $('meta[name=app-url]').attr("content") + "/products/" + id;
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        let product = response.product;
                        // Menghapus pesan error atau alert sebelumnya
                        $("#alert-div").html("");
                        $("#error-div").html("");
                        // Mengisi data produk ke dalam elemen formulir
                        $("#update_id").val(product.id);
                        $("#user_id").val(product.user_id);
                        $("#kategori_id").val(product.kategori_id);
                        $("#toko_id").val(product.toko_id);
                        $("#nama_product").val(product.nama_product);
                        $("#deskripsi").val(product.deskripsi);
                        $("#harga").val(product.harga);
                        $("#diskon").val(product.diskon);
                        $("#kondisi").val(product.kondisi);
                        $("#image").attr('src', '/storage/images/' + product.image);
                        $("#stok").val(product.stok);
                        // Menampilkan modal formulir
                        $("#form-modal").modal('show');
                    },
                    error: function(response) {
                        console.log(response.responseJSON)
                    }
                });
            }

            function updateProducts() {
                $("#save-products-btn").prop('disabled', true);

                let url = $('meta[name=app-url]').attr("content") + "/products/" + $("#update_id").val();

                let data = {
                    user_id: $("#user_id").val(),
                    toko_id: $("#toko_id").val(),
                    kategori_id: $("#kategori_id").val(),
                    nama_product: $("#nama_product").val(),
                    deskripsi: $("#deskripsi").val(),
                    harga: $("#harga").val(),
                    diskon: $("#diskon").val(),
                    kondisi: $("#kondisi").val(),
                    stok: $("#stok").val(),
                };

                if ($('#image')[0].files[0]) {
                    let imageFile = $('#image')[0].files[0];
                    let reader = new FileReader();

                    reader.onloadend = function() {
                        data.image = reader.result;
                        sendData();
                    };

                    reader.readAsDataURL(imageFile);
                } else {
                    sendData();
                }

                function sendData() {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Content-Type': 'application/json'
                        },
                        url: url,
                        type: "PUT",
                        data: JSON.stringify(data),
                        success: function(response) {
                            $("#save-products-btn").prop('disabled', false);
                            let successHtml =
                                '<div class="alert alert-success" role="alert"><b>Produk Berhasil Diperbarui</b></div>';
                            $("#alert-div").html(successHtml);
                            // Reset form fields
                            $("#user_id").val("");
                            $("#kategori_id").val("");
                            $("#toko_id").val("");
                            $("#nama_product").val("");
                            $("#deskripsi").val("");
                            $("#harga").val("");
                            $("#diskon").val("");
                            $("#kondisi").val("");
                            $("#image").val("");
                            $("#stok").val("");
                            reloadTable();
                            $("#form-modal").modal('hide');
                        },
                        error: function(response) {
                            $("#save-products-btn").prop('disabled', false);
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
            }

            function destroyProducts(id) {
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
                        let url = $('meta[name=app-url]').attr("content") + "/products/" + id;
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
                                        '<div class="alert alert-success" role="alert"><b>Product Berhasil Di Hapus</b></div>';
                                    $("#alert-div").html(successHtml);
                                    reloadTable();
                                } else {
                                    Swal.fire({
                                        title: "Error!",
                                        text: "Terjadi Kesalahan Saat Mengapus Product.",
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(response) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Terjadi Kesalahan Saat Mengapus Product.",
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
