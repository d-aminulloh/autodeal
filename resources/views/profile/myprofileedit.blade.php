@extends('layout.layout')

@section('content')

<div class="container py-5 mt-5">
  <!-- Breadcrumb -->
  <nav aria-label="breadcrumb" class="bc_breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#" aria-label="Home"><i class="bi bi-house-fill"></i></a>
      </li>
      <li class="breadcrumb-item" aria-current="page"><a href="{{route('myprofile')}}">Profil</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit Profil</li>
    </ol>
  </nav>

  <div class="row pt-sm-2 pt-lg-0">

    @include('profile.profilemenu')
    
    <!-- Page content -->
    <div class="col-lg-9 pb-2">
      <!-- Basic info -->
      <section class="card border-0 py-1 p-md-2 p-xl-3 p-xxl-4 mb-4 akunInfo bor-16">
        <div class="card-body">
          <div class="d-flex align-items-center mt-sm-n1 pb-4 mb-0 mb-lg-1 mb-xl-3">
            <h2 class="h4 mb-0">Edit info</h2>
          </div>
          <div class="d-flex align-items-center">
            <?php
            $profile_image = env('PATH_USER')."default.jpg";
            if($data->profile_image) {
              $profile_image =  env('PATH_USER').$data->profile_image;
            }
          ?>
            <div class="dropdown">
              <a class="d-flex flex-column justify-content-end position-relative overflow-hidden rounded-circle bg-size-cover bg-position-center flex-shrink-0" href="account-settings.html#" data-bs-toggle="dropdown" aria-expanded="false" style="width: 80px; height: 80px; background-image: url({{$profile_image}});" aria-label="Upload picture">
                <span class="d-block text-light text-center lh-1 pb-1" style="background-color: rgba(0,0,0,.5)">
                  <i class="bi bi-camera"></i>
                </span>
              </a>
              <div class="dropdown-menu my-1">
                <a class="dropdown-item fw-normal" href="account-settings.html#">
                  <i class="ai-camera fs-base opacity-70 me-2"></i>
                  Upload Foto
                </a>
                <a class="dropdown-item text-danger fw-normal" href="account-settings.html#">
                  <i class="ai-trash fs-base me-2"></i>
                  Hapus Foto
                </a>
              </div>
            </div>
            <div class="ps-3">
              <h3 class="h6 mb-1">Gambar profil</h3>
              <p class="fs-sm text-body-secondary mb-0">PNG / JPG max. 5MB</p>
            </div>
          </div>
          <div class="row g-3 g-sm-4 mt-0 mt-lg-2">
            <div class="col-sm-6">
              <label class="form-label" for="fn">Nama Lengkap<span>*</span></label>
              <input class="form-control" type="text" value="{{$data->name}}" id="fn">
            </div>
            {{-- <div class="col-sm-6">
              <label class="form-label" for="ln">Nama Belakang</label>
              <input class="form-control" type="text" value="Bocouse" id="ln">
            </div> --}}
            <div class="col-sm-6">
              <label class="form-label" for="email">Email<span>*</span></label>
              <input class="form-control" id="email" type="email" name="email" placeholder="Masukkan email" value="{{$data->email}}">
              <div class="form-text verifEmail">
                <span>Email belum terverifikasi. </span>
                <a href="">verifikasi sekarang!</a>
              </div>
            </div>
            <div class="col-sm-6">
              <label class="form-label" for="phone">Telepon<span>*</span></label>
              <input class="form-control" type="text" name="phone-field" data-type="phone" placeholder="+62" value="{{$data->phone}}">
              <div class="mb-3">
                <div class="form-check checkwa">
                  <input class="form-check-input" type="checkbox" id="CheckWA" {{$data->wa_available == '1' ? "checked":""}}>
                  <label class="form-check-label" for="CheckWA">WhatsApp available</label>
                </div>
              </div>
            </div>
            <div class="col-12 mt-0">
              <label class="form-label" for="bio">Bio</label>
              <textarea class="form-control" rows="5" placeholder="Tambahkan bio...">{{$data->bio}}</textarea>
            </div>

            <h4 class="fs-xs fw-medium text-body-secondary text-uppercase mb-0">Sosial Media</h4>

            <div class="col-sm-6 inputSocmed_icon">
              <label class="form-label" for="fb">Facebook</label>
              <img src="../assets/icons/fb-ico.svg"/>
              <hr class="vertical-line">
              <input class="form-control" type="text" id="fb" placeholder="@namauser" value="{{$data->sosmed_facebook}}">
            </div>
            <div class="col-sm-6 inputSocmed_icon">
              <label class="form-label" for="ig">Instagram</label>
              <img src="../assets/icons/ig-ico.svg"/>
              <hr class="vertical-line">
              <input class="form-control" type="text" id="ig" placeholder="@namauser" value="{{$data->sosmed_instagram}}">
            </div>
            <div class="col-sm-6 inputSocmed_icon">
              <label class="form-label" for="yt">Youtube</label>
              <img src="../assets/icons/yt-ico.svg"/>
              <hr class="vertical-line">
              <input class="form-control" type="text" id="yt" placeholder="@namauser" value="{{$data->sosmed_youtube}}">
            </div>
            <div class="col-sm-6 inputSocmed_icon">
              <label class="form-label" for="tt">Tiktok</label>
              <img src="../assets/icons/tt-ico.svg"/>
              <hr class="vertical-line">
              <input class="form-control" type="text" id="tt" placeholder="@namauser" value="{{$data->sosmed_tiktok}}">
            </div>

            <h4 class="fs-xs fw-medium text-body-secondary text-uppercase mb-0">Alamat</h4>

            <div class="col-sm-6">
              <label class="form-label" for="province_id">Propinsi<span>*</span></label>
              <select class="form-select" id="province_id">
                <option value="">Pilih Provinsi</option>
                <?php echo $data->province_id ? "<option selected value='$data->province_id'>$data->province_name</option>":"" ?>
              </select>
            </div>
            <div class="col-sm-6">
              <label class="form-label" for="city_id">Kabupaten / Kota<span>*</span></label>
              <select class="form-select" id="city_id">
                <?php echo $data->city_id ? "<option selected value='$data->city_id'>$data->city_name</option>":"" ?>
              </select>
            </div>
            <div class="col-sm-6">
              <label class="form-label" for="district_id">Kecamatan<span>*</span></label>
              <select class="form-select" id="district_id">
                <?php echo $data->district_id ? "<option selected value='$data->district_id'>$data->district_name</option>":"" ?>
              </select>
            </div>
            {{-- <div class="col-sm-6">
              <label class="form-label" for="currency">Kode Pos<span>*</span></label>
              <select class="form-select" id="currency">
                <option value="" selected disabled>Pilih kode pos</option>
                <option value="usd">$ USD</option>
                <option value="eur">€ EUR</option>
                <option value="ukp">£ UKP</option>
                <option value="jpy">¥ JPY</option>
              </select>
            </div> --}}
            <div class="col-12">
              <label class="form-label" for="bio">Detail Alamat</label>
              <textarea class="form-control" rows="5" placeholder="Tulis alamatmu disini...">{{$data->address_detail}}</textarea>
            </div>
            
            <div class="col-12 d-flex justify-content-end pt-3">
              <button class="btn btn-secondary mx-h-44" type="button">Cancel</button>
              <button class="btn btn-primary ms-2 mx-h-44" type="button">Save changes</button>
            </div>
          </div>
        </div>
      </section>

    </div>
  </div>
</div>

@endsection

@section('js')
    <script src="/assets/js/appjs/profile/myprofileedit.js"></script>
@endsection