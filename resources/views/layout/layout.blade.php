<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
  <head>
    @include('layout.part.header')
  </head>


  <!-- Body -->
  <body>

    <!-- Page loading spinner -->
    <div class="page-loading active">
      <div class="page-loading-inner">
        <div class="page-spinner"></div>
        <span>Loading...</span>
      </div>
    </div> 

    <!-- Page wrapper -->
    <main class="page-wrapper">

      <!-- Navbar. Remove 'fixed-top' class to make the navigation bar scrollable with the page -->
      @include('layout.part.topbar')

      
      <!-- slider menu -->
      @include('layout.part.topslider')
      
      <!-- Page container -->
      @yield('content')

    </main>

    <!-- Notifikasi -->
    <!-- Offcanvas -->
    <aside class="col-lg-3">
      <div class="offcanvas offcanvas-end" id="canvasnotif" tabindex="9">
        <div class="offcanvas-header border-bottom">
          <h5 class="offcanvas-title">Notifikasi</h5>
          <button class="btn-close" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <div class="notif-section" id="notif-section">
                      
            {{-- <div class="notif-date">Hari ini</div>
            
            <div class="notif-card new">
              <img src="assets/img/img_item/mobil/04-mobil/img_mob_01-00001.jpg"/>
              <ul>
                <li>Rheza menyukai iklanmu</li>
                <li>Range Rover Evoque Limited Edition waarna Putih</li>
                <li>13:21 - 05 Apr 2024</li>
              </ul>
            </div>
            
            <div class="notif-card new">
              <img src="assets/img/img_item/mobil/04-mobil/img_mob_01-00002.jpg"/>
              <ul>
                <li>Iklan favoritmu telah terjual</li>
                <li>Range Rover Evoque Limited Edition waarna Putih</li>
                <li>13:21 - 05 Apr 2024</li>
              </ul>
            </div>
            
            <div class="notif-card">
              <img src="assets/img/img_item/mobil/04-mobil/img_mob_01-00003.jpg"/>
              <ul>
                <li>Iklan favoritmu telah diedit</li>
                <li>Range Rover Evoque Limited Edition waarna Putih</li>
                <li>13:21 - 05 Apr 2024</li>
              </ul>
            </div>

            
            <div class="notif-date">Kemarin</div>
            
            <div class="notif-card new">
              <img src="assets/img/img_item/mobil/04-mobil/img_mob_01-00004.jpg"/>
              <ul>
                <li>Iklanmu akan kedaluwarsa besok</li>
                <li>Range Rover Evoque Limited Edition waarna Putih</li>
                <li>13:21 - 05 Apr 2024</li>
              </ul>
            </div>
            
            <div class="notif-card notif_success">
              <img src="assets/img/img_item/motor/04-motor/img_mot_01-00002.jpg"/>
              <ul>
                <li>Hore iklanmu berhasil tayang!</li>
                <li>Range Rover Evoque Limited Edition waarna Putih</li>
                <li>13:21 - 05 Apr 2024</li>
              </ul>
            </div>
            
            <div class="notif-card notif_failed">
              <img src="assets/img/img_item/elektronik/img_ele_01-00001.jpg"/>
              <ul>
                <li>Maaf iklanmu gagal tayang :(</li>
                <li>Range Rover Evoque Limited Edition waarna Putih</li>
                <li>13:21 - 05 Apr 2024</li>
              </ul>
            </div>

            <div class="notif-card notif_expired">
              <img src="assets/img/img_item/gadget/03-handphone/img_gad_01-00001.jpg"/>
              <ul>
                <li>Iklanmu sudah kedaluwarsa</li>
                <li>Range Rover Evoque Limited Edition waarna Putih</li>
                <li>13:21 - 05 Apr 2024</li>
              </ul>
            </div>

            <div class="notif-card new">
              <img src="assets/img/img_item/peliharaan/03-kucing/img_pel_01-00001.jpg"/>
              <ul>
                <li>Rheza menyukai iklanmu</li>
                <li>Range Rover Evoque Limited Edition waarna Putih</li>
                <li>13:21 - 05 Apr 2024</li>
              </ul>
            </div>
            
            <div class="notif-card new">
              <img src="assets/img/img_item/motor/04-motor/img_mot_01-00001.jpg"/>
              <ul>
                <li>Iklan favoritmu telah terjual</li>
                <li>Range Rover Evoque Limited Edition waarna Putih</li>
                <li>13:21 - 05 Apr 2024</li>
              </ul>
            </div> --}}

          </div>
        </div>
      </div>
    </aside>

    <a href="{{route('item.create')}}" class="floating-button" id="btn-createfloat">
      + iklan
    </a>

    <!-- modal -->
    @include('layout.part.modal')

    
    <!-- Footer-->
    @include('layout.part.footer')
    
  </body>
</html>
