<!-- Sidebar (offcanvas on sreens < 992px) -->
<aside class="col-lg-3 mt-n3">
  <div class=" top-80">
    <div class="d-none d-lg-block" style="padding-top: 40px;"></div>
    <div class="offcanvas-lg offcanvas-start" id="sidebarAccount">
      <button class="btn-close position-absolute top-0 end-0 mt-3 me-3 d-lg-none" type="button" data-bs-dismiss="offcanvas" data-bs-target="#sidebarAccount" aria-label="Close"></button>
      <div class="offcanvas-body">
        <nav class="nav flex-column mb-3">
          <h4 class="fs-xs fw-medium text-body-secondary text-uppercase pb-1 mb-2">Akun</h4>
          <a class="nav-link fw-semibold py-2 px-0{{Route::getCurrentRoute()->getName() == 'myprofile' ? 'active':''}}" {{Route::getCurrentRoute()->getName() == "myprofile" ? '':'href='.route('myprofile').''}}>
            <i class="bi bi-person-circle fs-6 opacity-60 me-2"></i>
            Profil
            <i class="bi bi-chevron-right pos-absolute right-10"></i>
          </a>
          <a class="nav-link fw-semibold py-2 px-0" href="pengaturan.html">
            <i class="bi bi-gear fs-6 opacity-60 me-2"></i>
            Pengaturan
            <i class="bi bi-chevron-right pos-absolute right-10"></i>
          </a>
          <a class="nav-link fw-semibold py-2 px-0" href="../tnc_page/pusat_bantuan.html">
            <i class="bi bi-question-circle fs-6 opacity-60 me-2"></i>
            Bantuan
          </a>
        </nav>
        <nav class="nav flex-column mb-1">
          <h4 class="fs-xs fw-medium text-body-secondary text-uppercase pb-1 mb-2">Iklan</h4>
          <a class="nav-link fw-semibold py-2 px-0 {{Route::getCurrentRoute()->getName() == 'myitem' ? 'active':''}}" {{Route::getCurrentRoute()->getName() == "myitem" ? '':'href='.route('myitem').''}}>
            <i class="bi bi-ui-checks-grid fs-6 opacity-60 me-2"></i>
            Iklan saya
            <i class="bi bi-chevron-right pos-absolute right-10"></i>
          </a>
          <a class="nav-link fw-semibold py-2 px-0 {{Route::getCurrentRoute()->getName() == 'myfavorite' ? 'active':''}}" {{Route::getCurrentRoute()->getName() == "myfavorite" ? '':'href='.route('myfavorite').''}}>
            <i class="bi bi-heart fs-6 opacity-60 me-2"></i>
            Iklan Favorit
            <i class="bi bi-chevron-right pos-absolute right-10"></i>
          </a>
        </nav>
      </div>
    </div>
  </div>
</aside>

<!-- link button (iklan saya & iklan favorit) mobile only -->
<div class="iklsy_iklfv">
  <a class="{{Route::getCurrentRoute()->getName() == 'myitem' ? 'btn btn-secondary active':''}}" {{Route::getCurrentRoute()->getName() == "myitem" ? '':'href='.route('myitem').''}}>Iklan Saya</a>
  <a class="{{Route::getCurrentRoute()->getName() == 'myfavorite' ? 'btn btn-secondary active':''}}" {{Route::getCurrentRoute()->getName() == "myfavorite" ? '':'href='.route('myfavorite').''}}>Iklan Favorit</a>
</div>
<!-- <div class="hr_custom-fav"></div> -->