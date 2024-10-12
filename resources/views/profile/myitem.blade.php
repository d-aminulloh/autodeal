@extends('layout.layout')

@section('content')

  <div class="container py-5 mt-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="bc_breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#" aria-label="Home"><i class="bi bi-house-fill"></i></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Iklan Saya</li>
      </ol>
    </nav>

    <div class="row pt-sm-2 pt-lg-0">

      @include('profile.profilemenu')

      <!-- Page content -->
      <div class="col-lg-9 pb-2 listProduct">
        <!-- Page title -->
        <div class="row cardSub_title">
          <label>Iklan saya</label>
          <label>5 iklan</label>
        </div>
        <!-- Active filters + Sorting -->
        <div class="d-flex align-items-baseline justify-content-between">
          <div class="me-3 activeFilter_desktop">
            
          </div>
          <div class="d-flex align-items-center flex-shrink-0 mb-2 mt-2 sortMobile iklsy">
            <span class="text-body-secondary text-nowrap fs-sm">Urutkan:</span>
            <select class="form-select selectFilter py-0">
              <option value="semua-iklan">Semua iklan</option>
              <option value="iklan-dimoderasi">Iklan dimoderasi</option>
              <option value="iklan-aktif">Iklan aktif</option>
              <option value="iklan-terjual">Iklan terjual</option>
              <option value="iklan-tidak-aktif">Iklan tidak aktif</option>
              <option value="iklan-ditolak">Iklan ditolak</option>
            </select>
          </div>
        </div>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 ikl-sy">
          <!-- Item 1 -->
          <div class="col badge-aktif">
            <div class="card position-relative rounded-1 mb-3">
              
              <a href="#" class="itemProduct">
                <!-- header card -->
                <div class="d-flex align-items-center date-iklsy">
                  <span class="me-2">30 Des 2023 - 30 Jan 2024</span>
                  <button class="btn btn-sm" type="button">
                    <i class="bi bi-three-dots-vertical"></i>
                  </button>
                </div>
                <!-- image -->
                <img class="d-block mx-auto img-product" src="../../assets/img/shop/products/01.png" alt="Product">
                <!-- detail -->
                <figcaption>
                  <div class="d-flex titleProduk">
                    <span>Tesla Roadster Merah 1500 CC Seperti Baru</span>
                  </div>
                  <div class="d-flex mb-1">
                    <h3 class="h4 mb-0">
                      <span>Rp </span>
                      3.518.990.000
                    </h3>
                  </div>
                  <div class="badge-status">
                    <span class="badge">AKTIF</span>
                    <span class="badge-info">28 hari tersisa..!</span>
                  </div>
                  <div class="row row-cols-3 interaksi">
                    <div class="col">
                      <span>1.207</span>
                      <span>Dilihat</span>
                    </div>
                    <div class="col">
                      <span>414</span>
                      <span>Disukai</span>
                    </div>
                    <div class="col">
                      <span>57</span>
                      <span>Dihubungi</span>
                    </div>
                  </div>
                </figcaption>
                <div class="btn-action row row-cols-2">
                  <button class="btn btn-secondary" type="button">
                    <span>Sundul</span>
                  </button>
                  <button class="btn btn-secondary" type="button">
                    <span>Set Terjual</span>
                  </button>
                </div>
              </a>
            </div>
          </div>

          <!-- Item 2 -->
          <div class="col badge-moderasi">
            <div class="card position-relative rounded-1 mb-3">
              
              <a href="#" class="itemProduct">
                <!-- header card -->
                <div class="d-flex align-items-center date-iklsy">
                  <span class="me-2">30 Des 2023 - 30 Jan 2024</span>
                </div>
                <!-- image -->
                <img class="d-block mx-auto img-product" src="../../assets/img/shop/products/01.png" alt="Product">
                <!-- detail -->
                <figcaption>
                  <div class="d-flex titleProduk">
                    <span>Tesla Roadster Merah 1500 CC Seperti Baru</span>
                  </div>
                  <div class="d-flex mb-1">
                    <h3 class="h4 mb-0">
                      <span>Rp </span>
                      3.518.990.000
                    </h3>
                  </div>
                  <div class="badge-status">
                    <span class="badge">MODERASI</span>
                    <span class="badge-info">Sedang proses..!</span>
                  </div>
                  <div class="row row-cols-3 interaksi">
                    <div class="col">
                      <span>1.207</span>
                      <span>Dilihat</span>
                    </div>
                    <div class="col">
                      <span>414</span>
                      <span>Disukai</span>
                    </div>
                    <div class="col">
                      <span>57</span>
                      <span>Dihubungi</span>
                    </div>
                  </div>
                </figcaption>
                <div class="btn-action row row-cols-2">
                  <button class="btn btn-secondary" type="button" disabled>
                    <span>...</span>
                  </button>
                </div>
              </a>
            </div>
          </div>

          <!-- Item 3 -->
          <div class="col badge-terjual">
            <div class="card position-relative rounded-1 mb-3">
              
              <a href="#" class="itemProduct">
                <!-- header card -->
                <div class="d-flex align-items-center date-iklsy">
                  <span class="me-2">30 Des 2023 - 30 Jan 2024</span>
                </div>
                <!-- image -->
                <img class="d-block mx-auto img-product" src="../../assets/img/shop/products/01.png" alt="Product">
                <!-- detail -->
                <figcaption>
                  <div class="d-flex titleProduk">
                    <span>Tesla Roadster Merah 1500 CC Seperti Baru</span>
                  </div>
                  <div class="d-flex mb-1">
                    <h3 class="h4 mb-0">
                      <span>Rp </span>
                      3.518.990.000
                    </h3>
                  </div>
                  <div class="badge-status">
                    <span class="badge">TERJUAL</span>
                    <span class="badge-info">Yeaay..! Terjual</span>
                  </div>
                  <div class="row row-cols-3 interaksi">
                    <div class="col">
                      <span>1.207</span>
                      <span>Dilihat</span>
                    </div>
                    <div class="col">
                      <span>414</span>
                      <span>Disukai</span>
                    </div>
                    <div class="col">
                      <span>57</span>
                      <span>Dihubungi</span>
                    </div>
                  </div>
                </figcaption>
                <div class="btn-action row row-cols-2">
                  <button class="btn btn-secondary" type="button">
                    <span>Hapus</span>
                  </button>
                </div>
              </a>
            </div>
          </div>

          <!-- Item 4 -->
          <div class="col badge-nonaktif">
            <div class="card position-relative rounded-1 mb-3">
              
              <a href="#" class="itemProduct">
                <!-- header card -->
                <div class="d-flex align-items-center date-iklsy">
                  <span class="me-2">30 Des 2023 - 30 Jan 2024</span>
                  <button class="btn btn-sm" type="button">
                    <i class="bi bi-three-dots-vertical"></i>
                  </button>
                </div>
                <!-- image -->
                <img class="d-block mx-auto img-product" src="../../assets/img/shop/products/01.png" alt="Product">
                <!-- detail -->
                <figcaption>
                  <div class="d-flex titleProduk">
                    <span>Tesla Roadster Merah 1500 CC Seperti Baru</span>
                  </div>
                  <div class="d-flex mb-1">
                    <h3 class="h4 mb-0">
                      <span>Rp </span>
                      3.518.990.000
                    </h3>
                  </div>
                  <div class="badge-status">
                    <span class="badge">TIDAK AKTIF</span>
                    <span class="badge-info">:(</span>
                  </div>
                  <div class="row row-cols-3 interaksi">
                    <div class="col">
                      <span>1.207</span>
                      <span>Dilihat</span>
                    </div>
                    <div class="col">
                      <span>414</span>
                      <span>Disukai</span>
                    </div>
                    <div class="col">
                      <span>57</span>
                      <span>Dihubungi</span>
                    </div>
                  </div>
                </figcaption>
                <div class="btn-action row row-cols-2">
                  <button class="btn btn-secondary" type="button">
                    <span>Pasang</span>
                  </button>
                </div>
              </a>
            </div>
          </div>

          <!-- Item 5 -->
          <div class="col badge-ditolak">
            <div class="card position-relative rounded-1 mb-3">
              
              <a href="#" class="itemProduct">
                <!-- header card -->
                <div class="d-flex align-items-center date-iklsy">
                  <span class="me-2">30 Des 2023 - 30 Jan 2024</span>
                  <button class="btn btn-sm" type="button">
                    <i class="bi bi-three-dots-vertical"></i>
                  </button>
                </div>
                <!-- image -->
                <img class="d-block mx-auto img-product" src="../../assets/img/shop/products/01.png" alt="Product">
                <!-- detail -->
                <figcaption>
                  <div class="d-flex titleProduk">
                    <span>Tesla Roadster Merah 1500 CC Seperti Baru</span>
                  </div>
                  <div class="d-flex mb-1">
                    <h3 class="h4 mb-0">
                      <span>Rp </span>
                      3.518.990.000
                    </h3>
                  </div>
                  <div class="badge-status">
                    <span class="badge">DITOLAK</span>
                    <span class="badge-info">Mencurigakan..!</span>
                  </div>
                  <div class="row row-cols-3 interaksi">
                    <div class="col">
                      <span>1.207</span>
                      <span>Dilihat</span>
                    </div>
                    <div class="col">
                      <span>414</span>
                      <span>Disukai</span>
                    </div>
                    <div class="col">
                      <span>57</span>
                      <span>Dihubungi</span>
                    </div>
                  </div>
                </figcaption>
                <div class="btn-action row row-cols-2">
                  <button class="btn btn-secondary" type="button">
                    <span>Hapus</span>
                  </button>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@section('js')
    <script src="/assets/js/appjs/landing.js"></script>
@endsection