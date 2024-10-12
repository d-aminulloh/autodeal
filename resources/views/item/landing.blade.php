@extends('layout.layout')

@section('content')
  <div class="container py-6 mt-50 mb-lg-4 mb-xl-1">
          
    <!-- Banner -->
    @include('layout.part.topbanner')

    <!-- Iklan terbaru disekitarmu (carousel) -->
    <section class="pb-4">
      <div class="d-flex align-items-center mb-2 mb-md-3">
        <img src="/assets/icons/new.png" class="iconNew"/>
        <h4 class="pt-1 mb-0">Iklan terbaru disekitarmu</h4>
      </div>
      <div class="swiper swiperTerbaru" data-swiper-options='{
        "slidesPerView": 2,
        "spaceBetween": 15,
        "autoplay": {
          "delay": 2500,
          "disableOnInteraction": false
        },
        "pagination": {
          "el": ".swiper-pagination",
          "clickable": true,
          "dynamicBullets": true
        },
        "breakpoints": {
            "640": {
                "slidesPerView": 2,
                "spaceBetween": 15
            },
            "768": {
                "slidesPerView": 3,
                "spaceBetween": 20
            },
            "1024": {
                "slidesPerView": 3,
                "spaceBetween": 30
            },
            "1025": {
                "slidesPerView": 4,
                "spaceBetween": 30
            }
        }
      }'>
        <div class="swiper-wrapper" id="landing-new-item"></div>
      </div>

      <div class="row gy-3 align-items-center pt-3 pt-sm-4 mt-md-2" id="loading-new-item">
        <div class="col col-12 order-md-2 order-3 text-center">
          <div class="spinner-border loading text-primary" style="width: 5rem; height: 5rem;" role="status"><span class="visually-hidden">Loading...</span></div>
        </div>
      </div>

    </section>

    <!-- Page title -->
    <div class="row pt-xl-3 mt-sm-0 titleLainnya">
      <div class="col-lg-9 pt-lg-3">
        <img src="/assets/icons/star.png" class="iconNew"/>
        <h4 class="pb-2 pb-sm-3">Iklan lainnya</h4>
      </div>
    </div>

    <div class="row pb-2 pb-sm-4">

      <!-- Product grid -->
      <div class="col-lg-12 listProduct">
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-4" id="landing-other-item"></div>

        <div class="row gy-3 align-items-center pt-3 pt-sm-4 mt-md-2" id="loading-other-item">
          <div class="col col-12 order-md-2 order-3 text-center">
            <div class="spinner-border loading text-primary" style="width: 5rem; height: 5rem;" role="status"><span class="visually-hidden">Loading...</span></div>
          </div>
        </div>

        <!-- Pagination -->
        <div class="row gy-3 align-items-center pt-3 pt-sm-4 mt-md-2">
          <div class="col col-12 order-md-2 order-3 text-center">
            <button class="btn btn-primary w-md-auto w-100" type="button" id="btn-other-item-next">Selanjutnya</button>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('js')
    <script src="/assets/js/appjs/item/landing.js"></script>
@endsection