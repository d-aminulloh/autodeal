<footer class="footer pt-4 pb-2 pb-md-5 pt-sm-5">
  <div class="container-fluid pb-1 pb-md-0 px-md-5">
    <div class="bg-footer rounded-5 position-relative overflow-hidden w-100 py-4 px-3 px-sm-4 px-xl-5 mx-auto" style="max-width: 1660px;" data-bs-theme="dark">
      <div class="position-absolute top-50 start-50 translate-middle" style="width: 1664px;">
        <img src="/assets/img/landing/web-studio/footer-wave.png" alt="Wave">
      </div>
      <div class="container position-relative z-2 pt-md-3 pt-lg-4 pt-xl-5 pb-2">
        <div class="row pb-2 footerMobile">
          <div class="col-lg-4 col-xxl-3 pb-2 pb-lg-0 mb-4 mb-lg-0">
            <div class="navbar-brand text-light py-0 me-0 pb-1 mb-3">
              <span class="text-primary flex-shrink-0">
                  <span class="text-primary flex-shrink-0 me-2">
                    <img src="/assets/img/dealnesia-logo.svg"/>
                  </span>
              </span>
              <!-- <span class="text-white opacity-90 fQuick">Autodeal.id</span> -->
            </div>
            <p class="text-body fs-sm mb-4">Temukan Kemudahan Jual Beli yang Aman, Cepat, dan Terpercaya di Dealnesia, Pasti Deal!</p>
            <!-- <div class="input-group input-group-sm rounded-pill">
              <input class="form-control" type="text" placeholder="Email address">
              <button class="btn btn-primary rounded-pill" type="button">Subscribe</button>
            </div> -->
          </div>
          <div class="col-sm-4 col-lg-2 offset-lg-1 offset-xl-2 offset-xxl-3 mb-4 mb-sm-0">
            <h6 class="fw-bold">Kategori Populer</h6>
            <ul class="nav flex-column fs-sm">
              <li class="nav-item">
                <a class="nav-link fw-normal px-0 py-1" href="#">Properti</a>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-normal px-0 py-1" href="#">Mobil</a>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-normal px-0 py-1" href="#">Motor</a>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-normal px-0 py-1" href="#">Gadget</a>
              </li>
            </ul>
          </div>
          <div class="col-sm-4 col-lg-2 mb-4 mb-sm-0">
            <h6 class="fw-bold">Support</h6>
            <ul class="nav flex-column fs-sm">
              <li class="nav-item">
                <a class="nav-link fw-normal px-0 py-1" href="#">Pusat Bantuan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-normal px-0 py-1" href="#">Persyaratan Layanan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link fw-normal px-0 py-1" href="#">Kebijakan Privasi</a>
              </li>
            </ul>
          </div>
          <div class="col-sm-4 col-lg-3 col-xl-2">
            <h6 class="fw-bold">Contact us</h6>
            <ul class="nav flex-column fs-sm">
              <li class="nav-item">
                <a class="nav-link fw-normal px-0 py-1" href="mailto:email@example.com">info@dealnesia.com</a>
              </li>
            </ul>
          </div>
        </div>
        <div class="d-sm-flex align-items-center justify-content-between pt-4 pt-md-2 mt-2 mt-md-0 mt-lg-2 mt-xl-4">
          <div class="d-flex justify-content-center order-sm-2 me-md-n2">
            <a class="btn btn-icon btn-sm btn-secondary btn-ig rounded-circle mx-2" href="https://www.instagram.com/autodeal_indo/" aria-label="Instagram">
              <i class="bi bi-instagram"></i>
            </a>
            <a class="btn btn-icon btn-sm btn-secondary btn-tt rounded-circle mx-2" href="https://www.tiktok.com/@autodeal__id?" aria-label="TikTok">
              <i class="bi bi-tiktok"></i>
            </a>
            <a class="btn btn-icon btn-sm btn-secondary btn-yt rounded-circle mx-2" href="https://www.youtube.com/channel/UCpOhjs2rFzPIQICysbDKgTQ" aria-label="YouTube">
              <i class="bi bi-youtube"></i>
            </a>
          </div>
          <p class="nav fs-sm order-sm-1 text-center text-sm-start pt-4 pt-sm-0 mb-0 me-4">
            <span class="text-body-secondary">&copy; 2023</span>
            <a class="nav-link fw-normal p-0 ms-1" href="#" target="_blank" rel="noopener">Dealnesia.com</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>


<!-- Back to top button -->
<a class="btn-scroll-top" href="#top" data-scroll aria-label="Scroll back to top">
  <svg viewBox="0 0 40 40" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
    <circle cx="20" cy="20" r="19" fill="none" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></circle>
  </svg>
  <i class="bi bi-arrow-up"></i>
</a>

<!-- BASE_URL -->
<script>
  var BASE_URL = "<?php echo env('APP_URL')?>";
</script>

<!-- JQuery -->
<script src="/assets/js/jquery.min.js"></script>
<script src="/assets/js/jquery.validate.min.js"></script>

@yield('jsinit')

<!-- Vendor scripts: JS libraries and plugins -->
<script src="/assets/vendor/nouislider/dist/nouislider.min.js"></script>
<script src="/assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="/assets/vendor/toastr/build/toastr.min.js"></script>

<!-- Bootstrap + Theme scripts -->
<script src="/assets/js/theme.min.js"></script>

<!-- Customizer -->
<script src="/assets/vendor/select2/select2.min.js"></script>
<script src="/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
<script src="/assets/js/autodeal2.js"></script>


@yield('js')