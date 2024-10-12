<div class="menuSlider">

  <section class="position-relative">
    <!-- Swiper slider -->
    <div class="container position-relative z-2">
      <div class="swiper" data-swiper-options='{
        "slidesPerView": "auto",
        "spaceBetween": 8,
        "loop": false,
        "navigation": {
          "prevEl": ".prev-gallery",
          "nextEl": ".next-gallery"
        }
      }'>
        <div class="swiper-wrapper align-items-end swiperMenu" id="autodealCategoryNav">

          <!-- Item -->
          <div class="swiper-slide w-auto">
            <a class="d-block card-hover zoom-effect" href="#">
              Loading...
            </a>
          </div>

        </div>
      </div>
      <!-- Swiper controls (Prev/next buttons) visible on screens > 576px -->
      <div class="d-none d-sm-flex navMenu bg-light">
        <button class="prev-gallery btn btn-icon btn-outline-primary rounded-circle" type="button" aria-label="Prev">
          <i class="bi bi-arrow-left"></i>
        </button>
        <button class="next-gallery btn btn-icon btn-outline-primary rounded-circle" type="button" aria-label="Next">
          <i class="bi bi-arrow-right"></i>
        </button>
      </div>
    </div>
  </section>
</div>  