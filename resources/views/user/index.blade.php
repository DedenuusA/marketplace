 @extends('template.master')
 @section('title', 'Users')
 @section('content')
     <main id="main" class="main">

         <div class="pagetitle">
             <h1>Data Tables</h1>
             <nav>
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                     <li class="breadcrumb-item">Tables</li>
                     <li class="breadcrumb-item active">Users</li>
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
                             <h5 class="card-title">Datatables Users</h5>
                             <hr>
                             @if (auth()->user()->role !== 'admin')
                                 <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                     data-bs-target="#basicModal" onclick="createUsers()">
                                     Tambah
                                 </button>
                                 <hr>
                             @endif

                             <table id="users_table" class="table data-table">
                                 <thead>
                                     <tr>
                                         <th>No</th>
                                         <th>
                                             <b>N</b>ama
                                         </th>
                                         <th>Email</th>
                                         <th>Role</th>
                                         <th>Aksi</th>
                                     </tr>
                                 </thead>
                                 <tbody id="users_table_body">

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
                     <h5 class="modal-title">Users Form</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <div id="error-div"></div>
                     <form>
                         @csrf
                         <input type="hidden" name="update_id" id="update_id">
                         <div class="form-group">
                             <label for="name" class="col-sm-2 col-form-label">Nama</label>
                             <input type="text" class="form-control" id="name">
                         </div>
                         <div class="form-group">
                             <label for="email" class="col-sm-2 col-form-label">Email</label>
                             <input type="email" class="form-control" id="email"></input>
                         </div>
                         @if (auth()->user()->role !== 'admin')
                             <div class="form-group">
                                 <label for="password" class="col-sm-2 col-form-label">Password</label>
                                 <input type="password" class="form-control" id="password"></input>
                             </div>
                         @endif
                         <div class="form-group">
                             <label for="no_telepon" class="col-sm-2 col-form-label">No HP</label>
                             <input type="number" class="form-control" id="no_telepon"></input>
                         </div>
                         @if (auth()->user()->role !== 'admin')
                             <div class="form-group">
                                 <label class="col-sm-2 col-form-label">Role</label>
                                 <div class="col-sm-15">
                                     <select class="form-control" id="role">
                                         <option value="">Pilih</option>
                                         <option value="super_admin">Super Admin</option>
                                         <option value="admin">Admin</option>
                                         {{-- <option value="customer">customer</option> --}}
                                     </select>
                                 </div>
                             </div>
                         @endif
                         <div class="form-group">
                             <label class="col-sm-2 col-form-label">Kelamin</label>
                             <div class="col-sm-15">
                                 <select class="form-control" id="jenis_kelamin">
                                     <option value="">Pilih</option>
                                     <option value="laki-laki">Laki - Laki</option>
                                     <option value="perempuan">Perempuan</option>
                                 </select>
                             </div>
                         </div>
                         <button type="submit" class="btn btn-outline-primary mt-3" id="save-users-btn">Simpan</button>
                     </form>
                 </div>
             </div>
         </div>
     </div>

     <div class="modal " tabindex="-1" role="dialog" id="view-modal">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title">Informasi Users</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body">
                     <b>Nama:</b>
                     <p id="name-info"></p>
                     <b>Email:</b>
                     <p id="email-info"></p>
                     <b>No HP</b>
                     <P id="no_telepon-info"></P>
                     <b>Role:</b>
                     <p id="role-info"></p>
                     <b>Kelamin</b>
                     <p id="jenis_kelamin-info"></p>
                     <b>Alamat</b>
                     <p id="alamat-info"></p>
                     <b>Profil</b>
                     <p id="gambar-info"></p>
                 </div>
             </div>
         </div>
     </div>

     @push('scripts')
         <script type="text/javascript">
             $(function() {
                 var baseUrl = $('meta[name=app-url]').attr("content");
                 let url = baseUrl + '/users';

                 $('#users_table').DataTable({
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
                             data: 'name'
                         },
                         {
                             data: 'email'
                         },
                         {
                             data: 'role'
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
                 $('#users_table').DataTable().ajax.reload();
             }

             $("#save-users-btn").click(function(event) {
                 event.preventDefault();
                 if ($("#update_id").val() == null || $("#update_id").val() == "") {
                     storeUsers();
                 } else {
                     updateUsers();
                 }
             })

             function createUsers() {
                 $("#alert-div").html("");
                 $("#error-div").html("");
                 $("#update_id").val("");
                 $("#name").val("");
                 $("#email").val("");
                 $("#password").val("");
                 $("#no_telepon").val("");
                 $("#role").val("");
                 $("#jenis_kelamin").val();
                 $("#form-modal").modal('show');
             }

             function storeUsers() {
                 $("#save-users-btn").prop('disabled', true);
                 let url = $('meta[name=app-url]').attr("content") + "/users";
                 let data = {
                     name: $("#name").val(),
                     email: $("#email").val(),
                     password: $("#password").val(),
                     no_telepon: $("#no_telepon").val(),
                     role: $("#role").val(),
                     jenis_kelamin: $("#jenis_kelamin").val(),
                 };
                 $.ajax({
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     url: url,
                     type: "POST",
                     data: data,
                     success: function(response) {
                         $("#save-users-btn").prop('disabled', false);
                         let successHtml =
                             '<div class="alert alert-success" role="alert"><b>Users Sukses di Tambahkan</b></div>';
                         $("#alert-div").html(successHtml);
                         $("#name").val("");
                         $("#email").val("");
                         $("#password").val("");
                         $("#no_telepon").val("");
                         $("#role").val("");
                         $("#jenis_kelamin").val("");
                         reloadTable();
                         $("#form-modal").modal('hide');
                     },
                     error: function(response) {
                         $("#save-users-btn").prop('disabled', false);
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

             function showUsers(id) {
                 $("#name-info").html("");
                 $("#email-info").html("");
                 $("#no_telepon-info").html("");
                 $("#role-info").html("");
                 $("#jenis_kelamin-info").html("");
                 $("#alamat-info").html("");
                 $("#gambar-info").html("");
                 let url = $('meta[name=app-url]').attr("content") + "/users/" + id + "";
                 $.ajax({
                     url: url,
                     type: "GET",
                     success: function(response) {
                         let user = response.user;
                         $("#name-info").html(user.name);
                         $("#email-info").html(user.email);
                         $("#no_telepon-info").html(user.no_telepon);
                         $("#role-info").html(user.role);
                         $("#jenis_kelamin-info").html(user.jenis_kelamin);
                         $("#alamat-info").html(user.alamat);
                         $("#gambar-info").html('<img src="' + user.gambar +
                             '" height="50" alt="user Image" />');
                         $("#view-modal").modal('show');

                     },
                     error: function(response) {
                         console.log(response.responseJSON)
                     }
                 });
             }

             function editUsers(id) {
                 let url = $('meta[name=app-url]').attr("content") + "/users/" + id;
                 $.ajax({
                     url: url,
                     type: "GET",
                     success: function(response) {
                         let user = response.user;
                         $("#alert-div").html("");
                         $("#error-div").html("");
                         $("#update_id").val(user.id);
                         //  $("#toko_id").val(user.toko_id);
                         $("#name").val(user.name);
                         $("#email").val(user.email);
                         $("#password").val(user.password);
                         $("#no_telepon").val(user.no_telepon);
                         $("#role").val(user.role);
                         $("#jenis_kelamin").val(user.jenis_kelamin);
                         $("#form-modal").modal('show');
                     },
                     error: function(response) {
                         console.log(response.responseJSON)
                     }
                 });
             }

             function updateUsers() {
                 $("#save-users-btn").prop('disabled', true);
                 let url = $('meta[name=app-url]').attr("content") + "/users/" + $("#update_id").val();
                 let data = {
                     id: $("#update_id").val(),
                     //  toko_id: $("#toko_id").val(),
                     name: $("#name").val(),
                     email: $("#email").val(),
                     password: $("#password").val(),
                     no_telepon: $("#no_telepon").val(),
                     role: $("#role").val(),
                     jenis_kelamin: $("#jenis_kelamin").val(),
                 };
                 $.ajax({
                     headers: {
                         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     },
                     url: url,
                     type: "PUT",
                     data: data,
                     success: function(response) {
                         $("#save-users-btn").prop('disabled', false);
                         let successHtml =
                             '<div class="alert alert-success" role="alert"><b>Users Berhasil di Perbarui</b></div>';
                         $("#alert-div").html(successHtml);
                         //  $("#toko_id").val("");
                         $("#name").val("");
                         $("#email").val("");
                         $("#password").val("");
                         $("#no_telepon").val("");
                         $("#role").val("");
                         $("#jenis_kelamin").val("");
                         reloadTable();
                         $("#form-modal").modal('hide');
                     },
                     error: function(response) {
                         $("#save-users-btn").prop('disabled', false);
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

             function destroyUsers(id) {
                 let result = Swal.fire({
                     title: "Apa kamu yakin?",
                     text: "Kamu tidak bisa mengembalikan ini!",
                     icon: "warning",
                     showCancelButton: true,
                     confirmButtonColor: "#3085d6",
                     cancelButtonColor: "#d33",
                     confirmButtonText: "Ya, Hapus!"
                 }).then((result) => {
                     if (result.isConfirmed) {
                         let url = $('meta[name=app-url]').attr("content") + "/users/" + id;
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
                                         text: "Data Kamu telah dihapus.",
                                         icon: "success"
                                     });

                                     let successHtml =
                                         '<div class="alert alert-success" role="alert"><b>Users Berhasil Di Hapus</b></div>';
                                     $("#alert-div").html(successHtml);
                                     reloadTable();
                                 } else {
                                     Swal.fire({
                                         title: "Error!",
                                         text: "Terjadi Kesalahan Saat Menghapus Users.",
                                         icon: "error"
                                     });
                                 }
                             },
                             error: function(response) {
                                 Swal.fire({
                                     title: "Error!",
                                     text: "Terjadi Kesalahan Saat Menghapus Users.",
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
