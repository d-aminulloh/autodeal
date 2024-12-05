<header class="navbar navbar-expand-lg fixed-top bg-light">
  <div class="container">

    <!-- Navbar brand (Logo) -->
    <a class="navbar-brand" href="<?php echo env("APP_URL"); ?>">
      <span class="text-primary flex-shrink-0 me-2">
        <img src="/assets/img/dealnesia-logo.svg"/>
      </span>
      <!-- <span class="d-sm-inline">Autodeal.id</span> -->
    </a>

    <!-- Mobile menu toggler (Hamburger) -->
    <div class="menu-btn">
      <span></span>
      <span></span>
      <span></span>
    </div>
  
    <div class="nav-menu menuMobile">
      <!-- Navbar brand (Logo) -->
      <a class="navbar-brand" href="index.html">
        <span class="text-primary flex-shrink-0 me-2">
          <img src="/assets/img/dealnesia-logo.svg"/>
        </span>
        <!-- <span class="d-sm-inline">Autodeal.id</span> -->
      </a>

      <div class="mobileLogin_modal">
        <!-- Profile Login -->
        <div class="profileMobile">
          @if(!Auth::check())
            <img src="/assets/icons/person.svg" class="photoProfile_default"/>
            <div class="nameProfile name_default">
              <span>Halo,</span>
              <span>Kamu belum 
                <a class="nav-link fs-7 mx-sm-1 d-sm-flex ptlog-12i td-uni navonmenu" href="#" data-bs-toggle="modal" data-bs-target="#modalLogin" aria-label="Account">
                  Login / Daftar
                </a> 
                😢
              </span>
            </div>
          @else
            <?php
              if($profile_image = Auth::user()->profile_image) {
                echo "<img src='".env('PATH_USER').$profile_image."' class='photoProfile_real'/>";
              } else {
                echo "<i class='bi bi-person'></i>";
              }
            ?>

            <!-- ganti foto user setelah login -->
            <div class="nameProfile name_real">
              <span>Halo,</span>
              <span>{{Auth::user()->name}}</span> 
            </div>
          @endif
        </div>

        @if(Auth::check())
          <!-- Setting -->
          <div class="row settingProfile">
            <div class="col">
              <a href="{{ route('myprofile') }}">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
              </a>
            </div>
            <div class="col">
              <a href="{{ route('profile.setting') }}">
                <i class="bi bi-gear"></i>
                <span>Pengaturan</span>
              </a>
            </div>
            <div class="col">
              <a href="{{ route('help') }}" target="_blank">
                <i class="bi bi-question-circle"></i>
                <span>Bantuan</span>
              </a>
            </div>
            <div class="col">
              <a href="#" onclick="autodealDoLogout()">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar</span>
              </a>
            </div>
          </div>
        @endif
      </div>

      <!-- Theme switcher - Mobile -->
      <div class="form-check form-switch mode-switch modeSwitch-mobile order-lg-3" data-bs-toggle="mode">
        <span>Mode tema</span>
        <div class="toggleSwitch">
          <input class="form-check-input" type="checkbox" id="theme-mode">
          <label class="form-check-label" for="theme-mode">
            <i class="bi bi-brightness-low"></i>
          </label>
          <label class="form-check-label" for="theme-mode">
            <i class="bi bi-moon-stars" style="font-size: 11px;"></i>
          </label>
        </div>
      </div>

      <ul class="kategoriMobile" id="autodealCategoryMNav">
      </ul>
    </div>

    <!-- Navbar collapse (Main navigation) -->
    <nav class="collapse navbar-collapse" id="navbarNav">
      <section class="searchBox bg-light">
        <div class="container">
          <div class="loc_frame">
            <!-- <img src="/assets/icons/location.svg" class="img-location"/> -->
            <i class="bi bi-map" id="top-location-icon"></i>
            <select class="locationBox" name="state">

            </select>
          </div>
          <div class="search_frame">
            <input type="text" id="autodealSearch" placeholder="Cari disini ..." autocomplete="on" value="{{$autodealSearch ?? ""}}">
            <button class="btn btn-primary" onclick="autodealDoSearch()"><i class="bi bi-search"></i></button>
          </div>
          <div class="result_box">
          </div>
        </div>
      </section>
    </nav>

    <!-- Search + Account + Cart -->
    <div class="nav align-items-center order-lg-2 ms-n1 me-sm-0 akunMobile">
      @if(!Auth::check())
      <!-- profile before login -->
        <a class="nav-link fs-7 mx-sm-1 d-sm-flex ptlog-12i td-uni" href="#" data-bs-toggle="modal" data-bs-target="#modalLogin" aria-label="Account">
          <i class="bi bi-person"></i>
          Login / Daftar
        </a>
        <!-- Theme switcher - Desktop -->
        <div class="form-check form-switch mode-switch modeSwitch-desktop nologin order-lg-3" data-bs-toggle="mode">
          <!-- <div class="toggleSwitch"> -->
            <input class="form-check-input" type="checkbox" id="theme-mode">
            <label>Mode tema</label>
          <!-- </div> -->
        </div>
      @else

        <!-- profile after login -->
        <div class="profileDesktop">
          
          <div class="btn-group dropdown">
            <button type="button" class="btn btn-outline-secondary btnProfile" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php
                if($profile_image = Auth::user()->profile_image) {
                  echo "<img src='".env('PATH_USER').$profile_image."' class='photoProfile_real'/>";
                } else {
                  echo "<i class='bi bi-person'></i>";
                }
              ?>
              <div class="d-none d-sm-block ps-2 mt-6">
                <div class="fs-xs lh-1 txt-l helogreen">Hello,</div>
                <div class="fs-sm dropdown-toggle fw-500" id="5b83214c8e50617707dad0bfc97f3abb">{{Auth::user()->name}}</div>
              </div>
            </button>
            <div class="dropdown-menu my-1">
              <!-- Theme switcher - Desktop -->
              <div class="form-check form-switch mode-switch order-lg-3" data-bs-toggle="mode">
                <!-- <div class="toggleSwitch"> -->
                <i class="bi bi-sun-fill"></i>
                <label>Tema</label>
                <input class="form-check-input" type="checkbox" id="theme-mode">
                <!-- </div> -->
              </div>
              <div class="dropdown-divider"></div>
              <!-- <h6 class="dropdown-header fs-xs fw-medium text-body-secondary text-uppercase pb-1">Akun</h6> -->
              <a href="{{ route('myprofile') }}" class="dropdown-item">
                <i class="bi bi-person"></i>
                Profil
              </a>
              <a href="#" class="dropdown-item">
                <i class="bi bi-view-list"></i>
                Iklan Saya
              </a>
              <a href="#" class="dropdown-item">
                <i class="bi bi-credit-card"></i>
                Paket Saya
              </a>
              <div class="dropdown-divider"></div>
              <!-- <h6 class="dropdown-header fs-xs fw-medium text-body-secondary text-uppercase pb-1">Dashboard</h6> -->
              <a href="{{ route('profile.setting') }}" class="dropdown-item">
                <i class="bi bi-gear"></i>
                Pengaturan
              </a>
              <a href="{{ route('help') }}" class="dropdown-item">
                <i class="bi bi-question-circle"></i>
                Bantuan
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item" onclick="autodealDoLogout()">
                <i class="bi bi-box-arrow-right"></i>
                Keluar
              </a>

            </div>
          </div>
          <div class="separator-menu">|</div>
          <!-- chat, notif, favourite, signout -->
          

        </div>
        <div class="chatNotif">
          <a href="{{ route('profile.message') }}">
            <i class="bi bi-chat-fill"></i>
          </a>
          <a href="{{ route('myfavorite') }}">
            <i class="bi bi-heart-fill"></i>
          </a>
          <button class="btn btn-outline-secondary active" type="button" data-bs-toggle="offcanvas" data-bs-target="#canvasnotif" id="toglenotif">
            <i class="bi bi-bell-fill"></i>
          </button>
        </div>
      @endif

    </div>
  </div>
</header>