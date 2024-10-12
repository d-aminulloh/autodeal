@extends('layout.layout')

@section('content')
<?php
  // $data = Auth::user();
?>
<div class="container py-5 mt-5">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="bc_breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#" aria-label="Home"><i class="bi bi-house-fill"></i></a>
      </li>
      <li class="breadcrumb-item active" aria-current="page">Profil</li>
    </ol>
  </nav>

  <div class="row pt-sm-2 pt-lg-0">

    @include('profile.profilemenu')
    
    <!-- Page content -->
    <div class="col-lg-9 pb-2">
      <!-- <h1 class="h2 mb-4">Ringkasan</h1> -->

      <!-- Basic info -->
      <section class="card border-0 py-1 p-md-2 p-xl-3 p-xxl-4 akunInfo bor-16">
        <div class="card-body">
          <div class="d-flex align-items-center mt-sm-n1 pb-4 mb-0 mb-lg-1 mb-xl-3">
            <i class="bi bi-person text-primary lead pe-1 me-2"></i>
            <h2 class="h4 mb-0">Info Profil</h2>
            <a class="btn btn-sm btn-secondary ms-auto" href="{{route('myprofileedit')}}">
              <i class="bi bi-pencil ms-n1 me-2"></i>
              Edit info
            </a>
          </div>
          <div class="d-md-flex align-items-center">
            <div class="d-sm-flex align-items-center">
              <?php
                if($profile_image = $data->profile_image) {
                  echo "<div class='rounded-circle bg-size-cover bg-position-center flex-shrink-0' style='width: 80px; height: 80px; background-image: url(".env('PATH_USER').$profile_image.");'></div>";
                } else {
                  // echo "<i class='bi bi-person'></i>";
                  echo "<div class='rounded-circle bg-size-cover bg-position-center flex-shrink-0' style='width: 80px; height: 80px; background-image: url(".env('PATH_USER')."default.jpg);'></div>";
                }
              ?>
              
              <div class="pt-3 pt-sm-0 ps-sm-3">
                <h3 class="h5 mb-2">{{$data->name}}
                  <i class="bi bi-check-circle-fill fs-base text-success ms-2"></i>
                </h3>
                <div class="text-body-secondary fw-medium d-flex flex-wrap flex-sm-nowrap align-iteems-center">
                  <div class="d-flex align-items-center me-3 fs-7">
                    Bergabung pada {{Helpers::myFormatDate($data->created_at)}}
                  </div>
                </div>
              </div>
            </div>
            {{-- <div class="w-100 pt-3 pt-md-0 ms-md-auto" style="max-width: 212px;">
              <div class="d-flex justify-content-between fs-sm pb-1 mb-2">
                Kelengkapan Profil
                <strong class="ms-2">62%</strong>
              </div>
              <div class="progress" style="height: 5px;">
                <div class="progress-bar" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div> --}}
          </div>
          <div class="row py-4 mb-2 mb-sm-3">
            <div class="col-md-12 mb-4 mb-md-0">
              <table class="table mb-0">
                <tbody>
                  <tr>
                    <td class="border-0 text-body-secondary py-1 px-0">Email</td>
                    <td class="border-0 text-dark fw-medium py-1 ps-3">{{$data->email}}</td>
                  </tr>
                  <tr>
                    <td class="border-0 text-body-secondary py-1 px-0">Telepon</td>
                    <td class="border-0 text-dark fw-medium py-1 ps-3">{{$data->phone}}</td>
                  </tr>
                  <tr>
                    <td class="border-0 text-body-secondary py-1 px-0">Bio</td>
                    <td class="border-0 text-dark fw-medium py-1 ps-3">{{$data->bio}}</td>
                  </tr>
                  <tr>
                    <td class="border-0 text-body-secondary py-1 px-0">Alamat</td>
                    <td class="border-0 text-dark fw-medium py-1 ps-3">{{$data->address_detail}} {{$data->location}}</td>
                  </tr>
                </tbody>
              </table>
              <span class="text-body-secondary title_akunsocmed">Social Media</span>
              <ul class="akunset_socmed">
                <?php
                  if($sosmed = $data->sosmed_facebook){
                    if(str_starts_with($sosmed,'@')) $sosmed = substr($sosmed, 1);
                    echo "<li><a target='_blank' href='https://www.facebook.com/$sosmed'><img src='/assets/icons/fb-ico.svg'></a></li>";
                  }
                  if($sosmed = $data->sosmed_instagram){
                    if(str_starts_with($sosmed,'@')) $sosmed = substr($sosmed, 1);
                    echo "<li><a target='_blank' href='https://www.instagram.com/$sosmed'><img src='/assets/icons/ig-ico.svg'></a></li>";
                  }
                  if($sosmed = $data->sosmed_youtube){
                    if(str_starts_with($sosmed,'@')) $sosmed = substr($sosmed, 1);
                    echo "<li><a target='_blank' href='https://www.youtube.com/user/$sosmed'><img src='/assets/icons/yt-ico.svg'></a></li>";
                  }
                  if($sosmed = $data->sosmed_tiktok){
                    if(!str_starts_with($sosmed,'@')) $sosmed = '@'.$sosmed;
                    echo "<li><a target='_blank' href='https://www.tiktok.com/$sosmed'><img src='/assets/icons/tt-ico.svg'></a></li>";
                  }
                ?>
              </ul>
            </div>
          </div>
          {{-- <div class="alert alert-info d-flex mb-0" role="alert">
            <i class="ai-circle-info fs-xl"></i>
            <div class="ps-2">Lengkapi profilmu 100% untuk mendapatkan lebih banyak pengunjung..<a class="alert-link ms-1" href="{{route('myprofileedit')}}">Lengkapi</a></div>
          </div> --}}
        </div>
      </section>

    </div>
  </div>
</div>

@endsection
