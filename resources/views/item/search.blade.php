@extends('layout.layout')

@section('content')
<div class="container py-5 mt-5 mb-lg-4 mb-xl-5">

  <input type="hidden" value="{{$category_slug ??""}}" id="c_category_id" autocomplete="off">
  <input type="hidden" value="{{$filter_active ??""}}" id="c_filter" autocomplete="off">

  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="bc_breadcrumb">
    <ol class="breadcrumb breadcrumb-delay">
      <li class="breadcrumb-item">
        <a href="#" aria-label="Home"><i class="bi bi-house-fill"></i></a>
      </li>
      <?php 
      if(str_contains(Route::getCurrentRoute()->getName(), 'search_allcategory')) {
        echo '<li class="breadcrumb-item active"><a>Semua kategori</a></li>';
      }
      
      ?>
    </ol>
  </nav>

  <!-- Page title -->
  <div class="row cardSub">
    <div class="col-lg-12 pt-lg-3 cardSub_bg">
      <Label>Hasil pencarian : </label>
      <h4>
        <div class="left">
          <span class="autodealSearchText">{{($autodealSearch ?? "")=="" ? "":"$autodealSearch -"}}</span>
          di
          <span class="autodealLocationText"></span>
        </div>
        <div class="right">
          <span class="total_item">0</span>
          <span>iklan</span>
        </div>
      </h4>
    </div>
  </div>
  <div class="row pb-2 pb-sm-4">

    <!-- Sidebar (offcanvas on sreens < 992px) -->
    @include('item.search-filter')



    <!-- Product grid -->
    <div class="col-lg-9 listProduct">

      <!-- Active filters + Sorting -->
      <div class="d-flex align-items-baseline justify-content-between mb-36 mb-20">
        <div class="me-3 activeFilter_desktop">
          <div class="nav d-md-none">
            <a class="nav-link dropdown-toggle fs-sm p-0 mb-2" href="shop-catalog.html#activeFilters" data-bs-toggle="collapse">Active filters</a>
          </div>
          <div class="collapse d-md-block" id="activeFilters">
            {{-- <div class="pt-2 pt-md-0">
              <a class="d-inline-block border rounded-pill fs-xs fw-medium text-body text-decoration-none py-1 px-2 me-2 mb-2" href="shop-catalog.html#">
                <span class="d-inline-flex align-items-center text-nowrap px-1">
                  Honda<i class="bi bi-x-circle-fill"></i>
                </span>
              </a>
              <a class="d-inline-block border rounded-pill fs-xs fw-medium text-body text-decoration-none py-1 px-2 me-2 mb-2" href="shop-catalog.html#">
                <span class="d-inline-flex align-items-center text-nowrap px-1">
                  Vario<i class="bi bi-x-circle-fill"></i>
                </span>
              </a>
              <a class="d-inline-block border rounded-pill fs-xs fw-medium text-body text-decoration-none py-1 px-2 me-2 mb-2" href="shop-catalog.html#">
                <span class="d-inline-flex align-items-center text-nowrap px-1">
                  10.000.000 - 20.000.000<i class="bi bi-x-circle-fill"></i>
                </span>
              </a>
              <a class="d-inline-block border rounded-pill fs-xs fw-medium text-body text-decoration-none py-1 px-2 me-2 mb-2" href="shop-catalog.html#">
                <span class="d-inline-flex align-items-center text-nowrap px-1">
                  Honda<i class="bi bi-x-circle-fill"></i>
                </span>
              </a>
              <a class="d-inline-block border rounded-pill fs-xs fw-medium text-body text-decoration-none py-1 px-2 me-2 mb-2" href="shop-catalog.html#">
                <span class="d-inline-flex align-items-center text-nowrap px-1">
                  Vario<i class="bi bi-x-circle-fill"></i>
                </span>
              </a>
              <a class="d-inline-block border rounded-pill fs-xs fw-medium text-body text-decoration-none py-1 px-2 me-2 mb-2" href="shop-catalog.html#">
                <span class="d-inline-flex align-items-center text-nowrap px-1">
                  10.000.000 - 20.000.000<i class="bi bi-x-circle-fill"></i>
                </span>
              </a>
              <button class="btn btn-sm btn-secondary rounded-pill fw-medium py-1 px-2" type="button">
                <span class="px-1">Remove all filters</span>
              </button>
            </div> --}}
          </div>
        </div>
        <div class="d-flex align-items-center flex-shrink-0 mb-2 sortMobile">
          <span class="text-body-secondary text-nowrap fs-sm">Urutkan:</span>
          <select class="form-select selectFilter py-0" id="autodealSortBy">
            <option value="newest">Terbaru</option>
            <option value="nearest">Terdekat</option>
            <option value="cheapest">Termurah</option>
            <option value="expensive">Termahal</option>
          </select>
        </div>
        <!-- Sidebar toggle button -->
        <button class="d-lg-none btn btn-sm fs-sm rounded-0 btnFilter" type="button" data-bs-toggle="offcanvas" data-bs-target="#shopSidebar">
          <i class="bi bi-sliders"></i>
        </button>
      </div>
      <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 g-4" id="landing-search-item"></div>

      <div class="row gy-3 align-items-center pt-3 pt-sm-4 mt-md-2" id="loading-search-item">
        <div class="col col-12 order-md-2 order-3 text-center">
          <div class="spinner-border loading text-primary" style="width: 5rem; height: 5rem;" role="status"><span class="visually-hidden">Loading...</span></div>
        </div>
      </div>

      <!-- Pagination -->
      <div class="row gy-3 align-items-center pt-3 pt-sm-4 mt-md-2">
        <div class="col col-12 order-md-2 order-3 text-center">
          <button class="btn btn-primary w-md-auto w-100" type="button" id="btn-search-item-next">Selanjutnya</button>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Sidebar toggle button -->
{{-- <button class="d-lg-none btn btn-sm fs-sm btn-primary w-100 rounded-0 fixed-bottom" type="button" data-bs-toggle="offcanvas" data-bs-target="#shopSidebar">
  <i class="ai-filter me-2"></i>
  Filters
</button> --}}

@endsection

@section('js')
    <script src="/assets/js/appjs/item/search.js"></script>
@endsection