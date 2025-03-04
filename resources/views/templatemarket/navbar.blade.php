 <div id="spinner"
     class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
     <div class="spinner-grow text-primary" role="status"></div>
 </div>

 <div class="container-fluid fixed-top">
     <div class="container topbar bg-primary d-none d-lg-block">
         <div class="d-flex justify-content-between">
             <div class="top-info ps-2">
                 <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#"
                         class="text-white">Jalan Ohara</a></small>
                 <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#"
                         class="text-white">marketplace@gmail.com</a></small>
             </div>
         </div>
     </div>
     <div class="container px-0">
         <nav class="navbar navbar-light bg-white navbar-expand-xl">
             <a href="index.html" class="navbar-brand">
                 <h1 class="text-primary display-6">MarketPlace</h1>
             </a>
             <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                 data-bs-target="#navbarCollapse">
                 <span class="fa fa-bars text-primary"></span>
             </button>
             <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                 <div class="navbar-nav mx-auto">
                     <a href="{{ route('market_place.index') }}" class="nav-item nav-link active">Home</a>
                     <a href="{{ route('shop.index') }}" class="nav-item nav-link">Shop</a>
                     <div class="nav-item dropdown">
                         <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                         <div class="dropdown-menu m-0 bg-secondary rounded-0">
                             <a href="{{ route('detail.cart') }}" class="dropdown-item">Cart</a>
                             <a href="{{ route('testimonial.index') }}" class="dropdown-item">Testimonial</a>
                         </div>
                     </div>
                     <a href="{{ route('contack.view') }}" class="nav-item nav-link">Contact</a>
                     {{-- <a href="{{ route('customer.login') }}" class="nav-item nav-link display-6"
                         style="color:forestgreen">LOGIN</a> --}}
                 </div>

                 <div class="d-flex m-3 me-0">
                     <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4"
                         data-bs-toggle="modal" data-bs-target="#searchModal"><i
                             class="fas fa-search text-primary"></i></button>
                     <a href="{{ route('detail.cart') }}" class="position-relative me-4 my-auto">
                         <i class="fa fa-shopping-bag fa-2x"></i>
                         <span
                             class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                             style="top: -5px; left: 15px; height: 20px; min-width: 20px;" id="cart-count">
                             0
                         </span>
                     </a>
                     @if (auth()->guard('customer')->check())
                         <div class="nav-item dropdown">
                             <a href="#" class="nav-link" data-bs-toggle="dropdown"><i
                                     class="fas fa-user fa-2x"></i></a>
                             <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                 <a href="{{ route('profile.index') }}" class="dropdown-item">Profil</a>
                                 <a href="{{ route('riwayat.pembelian', ['status' => 'belum_bayar']) }}"
                                     class="dropdown-item">Riwayat Pesanan</a>
                                 <a href="{{ route('customer.logout') }}" class="dropdown-item">Logout</a>
                             </div>
                         </div>
                     @else
                         <div class="nav-item"><a href="{{ route('customer.login') }}" class="nav-item nav-link"
                                 style="color:forestgreen">LOGIN</a></div>
                     @endif
                 </div>
         </nav>
     </div>
 </div>

 <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-fullscreen">
         <div class="modal-content rounded-0">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <form action="{{ route('products.search') }}" method="GET">
                 <div class="modal-body d-flex align-items-center">
                     <div class="input-group w-75 mx-auto d-flex">
                         @csrf
                         <input type="search" name="q" class="form-control p-3" placeholder="keywords"
                             aria-describedby="search-icon-1">
                         <button type="submit" id="search-icon-1" class="input-group-text p-3">
                             <i class="fa fa-search"></i>
                         </button>
                     </div>
                 </div>
             </form>
         </div>
     </div>
 </div>

 @push('scripts')
     <script>
         document.addEventListener('DOMContentLoaded', function() {
             fetch('{{ route('get.cart.count') }}', {
                     method: 'GET',
                     headers: {
                         'Content-Type': 'application/json',
                         'X-CSRF-TOKEN': '{{ csrf_token() }}'
                     }
                 })
                 .then(response => response.json())
                 .then(data => {
                     if (data.success) {
                         document.getElementById('cart-count').innerText = data.cart_count;
                     } else {
                         console.error('Error fetching cart count:', data.error);
                     }
                 })
                 .catch(error => {
                     console.error('Error:', error);
                 });
         });
     </script>
 @endpush
