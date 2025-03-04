@extends('templatemarket.master')
@section('title', 'Market_place')
@section('content')

    <style>
        .star-rating i {
            font-size: 24px;
            color: #ccc;
            cursor: pointer;
        }

        .star-rating i.selected,
        .star-rating i:hover,
        .star-rating i:hover~i {
            color: #ffcc00;
        }

        .selected {
            color: gold;
        }
    </style>
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Riwayat Pesanan</h1>
    </div>

    <div class="container-fluid py-5">
        <ol class="breadcrumb justify-content-center mb-0">
            <nav class="nav">
                <a class="nav-link {{ $status == 'belum_bayar' ? 'active' : '' }}"
                    href="{{ route('riwayat.pembelian', ['status' => 'belum_bayar']) }}">Belum Bayar</a>
                <a class="nav-link {{ $status == 'dikemas' ? 'active' : '' }}"
                    href="{{ route('riwayat.pembelian', ['status' => 'dikemas']) }}">Dikemas</a>
                <a class="nav-link {{ $status == 'dikirim' ? 'active' : '' }}"
                    href="{{ route('riwayat.pembelian', ['status' => 'dikirim']) }}">Dikirim</a>
                <a class="nav-link {{ $status == 'pengembalian' ? 'active' : '' }}"
                    href="{{ route('riwayat.pembelian', ['status' => 'pengembalian']) }}">Pengembalian</a>
                <a class="nav-link {{ $status == 'selesai' ? 'active' : '' }}"
                    href="{{ route('riwayat.pembelian', ['status' => 'selesai']) }}">Selesai</a>
                <a class="nav-link {{ $status == 'dibatalkan' ? 'active' : '' }}"
                    href="{{ route('riwayat.pembelian', ['status' => 'dibatalkan']) }}">Dibatalkan</a>
            </nav>
        </ol>
        <hr>

        <div class="container-fluid py-5">
            <div class="container py-5">
                <div class="table-responsive">
                    @if (count($orders) > 0)
                        <table class="table data-table" id="riwayat_table">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="riwayat_body_table">
                                @foreach ($orders as $order)
                                    @foreach ($order->orderItems as $orderItem)
                                        <tr>
                                            <td>
                                                <img src="{{ asset('storage/images/' . $orderItem->product->image) }}"
                                                    alt="{{ $orderItem->product->image }}" class="img-fluid me-5"
                                                    style="width: 80px; height: 80px">
                                            </td>
                                            <td class="mb-0 mt-4">{{ $orderItem->product->nama_product }}</td>

                                            <?php
                                            $harga = $orderItem->product->harga;
                                            $diskon = $orderItem->product->diskon;
                                            $result = ($harga * $diskon) / 100;
                                            $hasil = $harga - $result;
                                            ?>

                                            @if ($orderItem->product->diskon > 0)
                                                <td class="mb-0 mt-4">@currency($hasil)</td>
                                            @else
                                                <td class="mb-0 mt-4">@currency($orderItem->product->harga)</td>
                                            @endif

                                            <td class="mb-0 mt-4">{{ $orderItem->quantity }}</td>

                                            <td class="mb-0 mt-4">
                                                @if ($orderItem->product->diskon > 0)
                                                    @php
                                                        $harga = $orderItem->product->harga;
                                                        $diskon = $orderItem->product->diskon;
                                                        $hasil = $harga - ($harga * $diskon) / 100;
                                                    @endphp
                                                    {{ number_format($hasil * $orderItem->quantity) }}
                                                @else
                                                    {{ number_format($orderItem->product->harga * $orderItem->quantity) }}
                                                @endif
                                            </td>

                                            <td class="nav-item display-8" style="color:blue">
                                                {{ $orderItem->order->status }}
                                            </td>
                                            <td>
                                                <div class="product" data-order-item-id="{{ $orderItem->id }}">
                                                    <div class="rating-stars" id="rating-{{ $orderItem->id }}">
                                                    </div>
                                                </div>

                                            </td>
                                            <td>
                                                <a href="{{ route('product.detail', ['slug' => $orderItem->product->slug]) }}"
                                                    class="btn btn-outline-success">Beli Lagi</a>

                                                <button type="button" class="btn btn-outline-primary detail-modal"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModalCenter"
                                                    data-order_item_id="{{ $orderItem->id }}">
                                                    Detail
                                                </button>

                                                @if ($orderItem->order->status == 'selesai')
                                                    @if ($orderItem->review)
                                                        <button type="button" class="btn btn-outline-primary update-review"
                                                            data-bs-toggle="modal" data-bs-target="#updateModal"
                                                            data-order_item_id="{{ $orderItem->id }}">
                                                            Update Penilaian
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-outline-secondary add-review"
                                                            data-bs-toggle="modal" data-bs-target="#reviewModal"
                                                            data-order_item_id="{{ $orderItem->id }}"
                                                            data-product_id="{{ $orderItem->product->id }}"
                                                            data-order_id="{{ $orderItem->order->id }}"
                                                            data-user_id="{{ $orderItem->order->user->id }}"
                                                            data-customer_id ="{{ $orderItem->order->customer_id }}">
                                                            <i class="fa fa-plus"></i> Penilaian
                                                        </button>
                                                    @endif
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>
                            <center>Pesanan Kamu Kosong.</center>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewModalLabel">Penilaian Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addReviewForm">
                        <input type="hidden" name="order_item_id" value="">
                        <input type="hidden" name="product_id" value="">
                        <input type="hidden" name="order_id" value="">
                        <input type="hidden" name="user_id" value="">
                        <input type="hidden" name="customer_id" value="">

                        <div class="form-group">
                            <label for="rating">Rating</label>
                            <div class="star-rating" id="star-rating">
                                <i class="fa fa-star" data-value="1"></i>
                                <i class="fa fa-star" data-value="2"></i>
                                <i class="fa fa-star" data-value="3"></i>
                                <i class="fa fa-star" data-value="4"></i>
                                <i class="fa fa-star" data-value="5"></i>
                            </div>
                            <input type="hidden" name="rating" id="rating-value" value="0">
                        </div>
                        <div class="form-group">
                            <label for="review">Review</label>
                            <textarea name="review" class="form-control" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveReview">Simpan Penilaian</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Penilaian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateReviewForm">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="updateReview">Update Penilaian</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Order Details</h5>
                    <button type="button" class="button-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="modalContent">

                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.star-rating i').on('click', function() {
                    var rating = $(this).data('value');
                    $('#rating-value').val(rating);

                    $(this).siblings('i').removeClass('selected');
                    $(this).addClass('selected');
                    $(this).prevAll().addClass('selected');
                });

                $('#reviewModal').on('hidden.bs.modal', function() {
                    var form = $(this).find('form')[0];
                    if (form) {
                        form.reset();
                    }
                    $('#star-rating i').removeClass('selected');
                    $('#rating-value').val(0);
                });

                $('#reviewModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var orderItemId = button.data('order_item_id');
                    var productId = button.data('product_id');
                    var orderId = button.data('order_id');
                    var userId = button.data('user_id');
                    var customerId = button.data('customer_id');

                    var modal = $(this);
                    modal.find('input[name="order_item_id"]').val(orderItemId);
                    modal.find('input[name="product_id"]').val(productId);
                    modal.find('input[name="order_id"]').val(orderId);
                    modal.find('input[name="user_id"]').val(userId);
                    modal.find('input[name="customer_id"]').val(customerId);

                    $('#rating-value').val(0);
                    $('#star-rating i').removeClass('selected');

                });

                $('#saveReview').on('click', function() {
                    var form = $('#addReviewForm');
                    var formData = form.serialize();

                    $.ajax({
                        url: '/save-review',
                        method: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert('Review berhasil disimpan');
                            var orderItemId = $('input[name="order_item_id"]').val();
                            var rating = response.rating;
                            updateRatingStars(orderItemId, rating);

                            var button = $('.add-review[data-order_item_id="' + orderItemId + '"]');
                            button.removeClass('add-review btn-outline-secondary');
                            button.addClass('update-review btn-outline-primary');
                            button.html('Update Penilaian');

                            $('#reviewModal').modal('hide');
                        },
                        error: function(xhr) {
                            alert('Terjadi kesalahan saat menyimpan review.');
                        }
                    });
                });
            });

            $(document).ready(function() {
                $('.product').each(function() {
                    var orderItemId = $(this).data('order-item-id');

                    $.ajax({
                        url: '/get-rating/' + orderItemId,
                        method: 'GET',
                        success: function(response) {
                            updateRatingStars(orderItemId, response.rating);
                        },
                        error: function(xhr) {
                            console.log('Terjadi kesalahan saat mengambil rating.');
                        }
                    });
                });
            });

            function updateRatingStars(orderItemId, rating) {
                var starsHtml = '';
                for (var i = 1; i <= 5; i++) {
                    starsHtml += i <= rating ? `<i class="fa fa-star selected"></i>` : `<i class="fa fa-star-o"></i>`;
                }
                $('#rating-' + orderItemId).html(starsHtml);
            }

            $('#updateModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var orderItemId = button.data('order_item_id');

                $.ajax({
                    url: '/get-review/' + orderItemId,
                    method: 'GET',
                    success: function(response) {
                
                        if (response) {
                            let starsHtml = '';
                            for (let i = 1; i <= 5; i++) {
                                let selectedClass = i <= response.rating ? 'selected' : '';
                                starsHtml +=
                                    `<i class="fa fa-star ${selectedClass}" data-value="${i}"></i>`;
                            }

                            $('#updateReviewForm').html(`
                    <input type="hidden" name="order_item_id" value="${response.order_item_id}">
                    <input type="hidden" name="rating" id="rating" value="${response.rating}">
                    <div class="form-group">
                        <label for="rating">Rating</label>
                        <div class="star-rating">
                            ${starsHtml}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="review">Review</label>
                        <textarea name="review" class="form-control" required>${response.review}</textarea>
                    </div>
                `);

                            $('.star-rating i').on('click', function() {
                                var rating = $(this).data('value');
                                $('#rating').val(rating);
                                $(this).siblings('i').removeClass('selected');
                                $(this).addClass('selected');
                                $(this).prevAll().addClass('selected');
                            });
                        } else {
                            alert('Review tidak ditemukan.');
                        }
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat memuat review.');
                    }
                });
            });

            $('#updateReview').on('click', function(e) {
                e.preventDefault();
               
                $('#star-rating i').removeClass('selected');
                $('#rating-value').val(0);

                var formData = $('#updateReviewForm').serialize();

                $.ajax({
                    url: '/update-review',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Review berhasil diupdate');

                        var orderItemId = $('input[name="order_item_id"]').val();
                        var rating = response.rating;
                        updateRatingStars(orderItemId, rating);

                        $('#updateModal').modal('hide');
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat mengupdate review.');
                    }
                });
            });


            $(document).ready(function() {
                $('.detail-modal').on('click', function(event) {
                    event.preventDefault();

                    var orderItemId = $(this).data(
                        'order_item_id');

                    $.ajax({
                        url: '/order/details/' + orderItemId,
                        method: 'GET',
                        contentType: 'application/json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#modalContent').html(response);
                            $('#exampleModalCenter').modal('show');
                        },
                        error: function(xhr) {
                            var errorMessage =
                                'Unable to load details. Please try again later.';
                            if (xhr.status === 404) {
                                errorMessage = 'Order not found.';
                            }
                            $('#modalContent').html('<p>' + errorMessage + '</p>');
                            $('#exampleModalCenter').modal('show');
                        }
                    });
                });

                $('#exampleModalCenter').on('hidden.bs.modal', function() {
                    $('#modalContent').empty();
                });
            });
        </script>
    @endpush

@endsection
