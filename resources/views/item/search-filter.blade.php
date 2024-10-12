<aside class="col-lg-3">
  <div class="offcanvas-lg offcanvas-start" id="shopSidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Filter</h5>
      <button class="btn-close" type="button" data-bs-dismiss="offcanvas" data-bs-target="#shopSidebar" aria-label="Close"></button>
    </div>

    <!-- Body -->
    <div class="offcanvas-body pt-2 pt-lg-0 pe-lg-4">

      <!-- Categories (accordion with checkboxes) -->
      <h3 class="h5">Filter</h3>
      <div class="accordion accordion-alt pb-2 mb-4" id="shopCategories">
        <!-- Filter Kategori -->
        <div class="accordion-item mb-0">
          <h4 class="accordion-header">
            <button class="accordion-button fs-xl fw-medium py-2" type="button" data-bs-toggle="collapse" data-bs-target="#fltr-kategori" aria-expanded="true" aria-controls="fltr-kategori">
              <span class="fs-base">Kategori</span>
            </button>
          </h4>
          <div class="accordion-collapse collapse show" id="fltr-kategori" data-bs-parent="#shopCategories">
            <div class="accordion-body py-1 mb-1">
              <ul class="fltr-kategori_lv1" id="fltr-kategori_lv1"></ul>
            </div>
          </div>
        </div>

        <!-- Filter Lokasi -->
        {{-- <div class="accordion-item mb-0 alok">
          <h4 class="accordion-header">
            <button class="accordion-button fs-xl fw-medium py-2" type="button" data-bs-toggle="collapse" data-bs-target="#fltr-lokasi" aria-expanded="true" aria-controls="fltr-lokasi">
              <span class="fs-base">Lokasi</span>
            </button>
          </h4>
          <div class="accordion-collapse collapse show" id="fltr-lokasi" data-bs-parent="#shopCategories">
            <div class="accordion-body py-1 mb-1">
              <ul class="fltr-lokasi_lv1">
                <li>
                  <a href="#" class="fltr-lokasi_country">Indonesia</a>
                  <ul class="fltr-lokasi_lv2">
                    <li>
                      <a href="#" class="fltr-lokasi_province">
                        <label class="form-check-label d-flex align-items-center">
                          <span class="text-nav fw-medium">Jawa Barat</span>
                          <span class="fs-xs text-body-secondary ms-auto">12813</span>
                        </label>
                      </a>
                      <ul class="fltr-lokasi_lv3">
                        <li>
                          <a href="#" class="fltr-lokasi_city">
                            <label class="form-check-label d-flex align-items-center">
                              <span class="text-nav fw-medium">Kab. Bandung</span>
                              <span class="fs-xs text-body-secondary ms-auto">5813</span>
                            </label>
                          </a>
                          <ul class="fltr-lokasi_lv4 ulLast">
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Arjasari</span>
                                  <span class="fs-xs text-body-secondary ms-auto">813</span>
                                </label>
                              </a>
                            </li>
                            <li class="active">
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Baleendah</span>
                                  <span class="fs-xs text-body-secondary ms-auto">1254</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Banjaran</span>
                                  <span class="fs-xs text-body-secondary ms-auto">113</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Bojongsoang</span>
                                  <span class="fs-xs text-body-secondary ms-auto">313</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Cangkuang</span>
                                  <span class="fs-xs text-body-secondary ms-auto">612</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Cicalengka</span>
                                  <span class="fs-xs text-body-secondary ms-auto">813</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Cileunyi</span>
                                  <span class="fs-xs text-body-secondary ms-auto">813</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Cimeunyan</span>
                                  <span class="fs-xs text-body-secondary ms-auto">813</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Ciparay</span>
                                  <span class="fs-xs text-body-secondary ms-auto">813</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Ciwidey</span>
                                  <span class="fs-xs text-body-secondary ms-auto">813</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Dago</span>
                                  <span class="fs-xs text-body-secondary ms-auto">813</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Dayeuhkolot</span>
                                  <span class="fs-xs text-body-secondary ms-auto">813</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Katapang</span>
                                  <span class="fs-xs text-body-secondary ms-auto">813</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Majalaya</span>
                                  <span class="fs-xs text-body-secondary ms-auto">813</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Margaasih</span>
                                  <span class="fs-xs text-body-secondary ms-auto">813</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Margahayu</span>
                                  <span class="fs-xs text-body-secondary ms-auto">813</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Pameungpeuk</span>
                                  <span class="fs-xs text-body-secondary ms-auto">813</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Pangalengan</span>
                                  <span class="fs-xs text-body-secondary ms-auto">1122</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Rancaekek</span>
                                  <span class="fs-xs text-body-secondary ms-auto">411</span>
                                </label>
                              </a>
                            </li>
                            <li>
                              <a href="#" class="fltr-lokasi_district">
                                <label class="form-check-label d-flex align-items-center">
                                  <span class="text-nav fw-medium">Soreang</span>
                                  <span class="fs-xs text-body-secondary ms-auto">813</span>
                                </label>
                              </a>
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
        </div> --}}

        <!-- Filter Tipe Iklan -->
        <div class="accordion-item mb-0">
          <h4 class="accordion-header">
            <button class="accordion-button collapsed fs-xl fw-medium py-2" type="button" data-bs-toggle="collapse" data-bs-target="#fltr-atype" aria-expanded="false" aria-controls="fltr-atype">
              <span class="fs-base">Tipe Iklan</span>
            </button>
          </h4>
          <div class="accordion-collapse collapse show filter-check" id="fltr-atype" data-bs-parent="#shopCategories">
            <div class="accordion-body py-1 mb-1"></div>
          </div>
        </div>
        
        <!-- Filter Kondisi Produk -->
        <div class="accordion-item mb-0">
          <h4 class="accordion-header">
            <button class="accordion-button collapsed fs-xl fw-medium py-2" type="button" data-bs-toggle="collapse" data-bs-target="#fltr-acond" aria-expanded="false" aria-controls="fltr-acond">
              <span class="fs-base">Kondisi</span>
            </button>
          </h4>
          <div class="accordion-collapse collapse show filter-check" id="fltr-acond" data-bs-parent="#shopCategories">
            <div class="accordion-body py-1 mb-1"></div>
          </div>
        </div>

        <!-- Filter Durasi Sewa -->
        <div class="accordion-item mb-0">
          <h4 class="accordion-header">
            <button class="accordion-button collapsed fs-xl fw-medium py-2" type="button" data-bs-toggle="collapse" data-bs-target="#fltr-adur" aria-expanded="false" aria-controls="fltr-adur">
              <span class="fs-base">Durasi Sewa</span>
            </button>
          </h4>
          <div class="accordion-collapse collapse show filter-check" id="fltr-adur" data-bs-parent="#shopCategories">
            <div class="accordion-body py-1 mb-1"></div>
          </div>
        </div>

        <!-- Filter Price -->
        <div class="range-slider" data-start-min="10" data-start-max="50" data-min="0" data-max="80" data-step="1" data-tooltip-prefix="$">
          <h4 class="fs-base labelPrice">Harga</h3>
          <div id="fltr-price">
            {{-- <div class="range-slider-ui noUi-target noUi-ltr noUi-horizontal noUi-txt-dir-ltr" style="display:none;"></div> --}}
            <div class="d-block align-items-center">
              <label class="form-label me-2 mb-0 d-inline-block" for="fltr-pmin">Dari</label>
              <input class="form-control range-slider-value-min" style="max-width: 6rem;" type="text" name="currency-field" id="fltr-pmin" data-type="currency" placeholder="Rp 1,000">
            </div>
            <div class="d-block align-items-center mt-4">
              <label class="form-label me-2 mb-0 d-inline-block" for="fltr-pmax">Hingga</label>
              <input class="form-control range-slider-value-max" style="max-width: 6rem;" type="text" name="currency-field" id="fltr-pmax" data-type="currency" placeholder="Rp 1,000,000">
            </div>
            <button class="btn btn-primary btnOnFilter">Terapkan</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</aside>