@extends('template.master')
@section('title', 'Keranjang')
@section('content')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>DataTable</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                    <li class="breadcrumb-item">Tables</li>
                    <li class="breadcrumb-item active">Keranjang</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Datatables</h5>
                            <table class="table data-table" id="carts_table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>
                                            <b>P</b>roduct
                                        </th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>diskon%</th>
                                        <th>Harga Jual</th>
                                        <th>Customer</th>
                                        <th>quantity</th>
                                        <th>Tgl</th>
                                    </tr>
                                </thead>
                                <tbody id="carts_table_body">

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
                let url = baseUrl + '/keranjang';

                $('#carts_table').DataTable({
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
                            data: 'image',
                            render: function(data, type, full, meta) {
                                return '<img src="/storage/images/' + data + '" height="50" />';
                            }
                        },
                        {
                            data: 'product_name'
                        },
                        {
                            data: 'harga',
                            render: function(data, type, row) {
                                if (type === 'display') {
                                    return 'Rp ' + Number(data).toLocaleString('id-ID');
                                }
                                return data;
                            }
                        },
                        {
                            data: 'diskon'
                        },
                        {
                            data: 'hasil',
                        },
                        {
                            data: 'customer_name'
                        },
                        {
                            data: 'quantity'
                        },
                        {
                            data: 'created_at'
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
                $('#carts_table').DataTable().ajax.reload();
            }
        </script>
    @endpush
@endsection
