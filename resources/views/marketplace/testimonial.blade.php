 @extends('templatemarket.master')
 @section('title', 'Market_place')
 @section('content')

     <div class="container-fluid page-header py-5">
         <h1 class="text-center text-white display-6">Testimonial</h1>
         <ol class="breadcrumb justify-content-center mb-0">
             <li class="breadcrumb-item"><a href="#">Home</a></li>
             <li class="breadcrumb-item"><a href="#">Pages</a></li>
             <li class="breadcrumb-item active text-white">Testimonial</li>
         </ol>
     </div>

     <div class="container-fluid testimonial py-5">
         <div class="container py-5">
             <div class="testimonial-header text-center">
                 <h4 class="text-primary">Testimoni Kami</h4>
                 <h1 class="display-5 mb-5 text-dark">Kata Klien Kami!</h1>
             </div>
             <div class="owl-carousel testimonial-carousel">
                 @foreach ($komentar as $komentars)
                     <div class="testimonial-item img-border-radius bg-light rounded p-4">
                         <div class="position-relative">
                             <i class="fa fa-quote-right fa-2x text-secondary position-absolute"
                                 style="bottom: 30px; right: 0;"></i>
                             <div class="mb-4 pb-4 border-bottom border-secondary">
                                 <p class="mb-0">{{ $komentars->review }}
                                 </p>
                             </div>
                             <div class="d-flex align-items-center flex-nowrap">
                                @if ($komentars->customer->gambar != '')
                                 <div class="bg-secondary rounded">
                                     <img src="{{ asset($komentars->customer->gambar) }}" class="img-fluid rounded"
                                         style="width: 100px; height: 100px;" alt="">
                                 </div>
                                 @else 
                                 <div class="bg-secondary rounded">
                                     <img src="{{ asset('marketplace/img/avatar.jpg') }}" class="img-fluid rounded"
                                         style="width: 100px; height: 100px;" alt="">
                                 </div>
                                 @endif
                                 <div class="ms-4 d-block">
                                     <h4 class="text-dark">{{ $komentars->order->customer_name }}</h4>
                                     <p class="m-0 pb-3">Profession</p>
                                     <div class="d-flex pe-5">
                                         @php
                                             $rating = $komentars->rating;
                                         @endphp
                                         @for ($i = 1; $i <= 5; $i++)
                                             <i class="fa fa-star {{ $i <= $rating ? 'text-primary' : '' }}"></i>
                                         @endfor
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 @endforeach
             </div>
         </div>
     </div>
 @endsection
