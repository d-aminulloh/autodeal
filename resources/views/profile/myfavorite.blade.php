@extends('layout.layout')

@section('content')

  <div class="container py-5 mt-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="bc_breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#" aria-label="Home"><i class="bi bi-house-fill"></i></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Iklan Favorit</li>
      </ol>
    </nav>

    <div class="row pt-sm-2 pt-lg-0">

      @include('profile.profilemenu')
      
      <!-- Page content -->
      <div class="col-lg-9 pb-2 listProduct">

        <!-- Page title -->
        <div class="row cardSub_title">
          <label>Iklan favoritmu</label>
          <label><span class="total_item">0</span> iklan</label>
        </div>
        
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 ikl-fav" id="favorite-item"></div>

        <div class="row gy-3 align-items-center pt-3 pt-sm-4 mt-md-2" id="loading-favorite-item">
          <div class="col col-12 order-md-2 order-3 text-center">
            <div class="spinner-border loading text-primary" style="width: 5rem; height: 5rem;" role="status"><span class="visually-hidden">Loading...</span></div>
          </div>
        </div>

      </div>
    </div>
  </div>

@endsection

@section('js')
    <script src="/assets/js/appjs/profile/myfavorite.js"></script>
@endsection
