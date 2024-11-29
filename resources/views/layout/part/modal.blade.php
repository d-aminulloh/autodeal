<!-- Modal with tabs and forms -->
<div class="modal" id="modalLogin" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="loginTitle">
        <h4 class="pt-1 mb-0">Halo</h4>
        <span>Selamat datang!</span>
      </div>
      <div class="modal-header">
        <ul class="nav nav-tabs flex-nowrap text-nowrap mb-n2" role="tablist">
          <li class="nav-item">
            <a href="#formAutodealLogin" class="nav-link flex-column flex-sm-row px-3 px-sm-4 active" data-bs-toggle="tab" role="tab" aria-selected="true">
              <i class="ai-login me-sm-2 ms-sm-n1"></i>
              <span class="d-none d-sm-inline">Login</span>
              <span class="fs-sm fw-medium d-sm-none pt-1">Login</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="#formAutodealRegister" class="nav-link flex-column flex-sm-row px-3 px-sm-4" data-bs-toggle="tab" role="tab" aria-selected="false">
              <i class="ai-user me-sm-2 ms-sm-n1"></i>
              <span class="d-none d-sm-inline">Daftar</span>
              <span class="fs-sm fw-medium d-sm-none pt-1">Daftar</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="modal-body tab-content">
        <form class="tab-pane fade show active" id="formAutodealLogin" autocomplete="off">
          <div class="mb-3 mb-sm-3">
            <input type="email" class="form-control" id="login_email" placeholder="email@example.com" autocomplete="username" required value="">
          </div>
          <div class="mb-3 mb-sm-4">
            <div class="password-toggle">
              <input type="password" class="form-control" id="login_password" placeholder="password" autocomplete="current-password" required value="">
              <label class="password-toggle-btn">
                <input class="password-toggle-check" type="checkbox">
                <span class="password-toggle-indicator"></span>
              </label>
            </div>
          </div>
          <div class="mb-4 d-flex flex-wrap justify-content-between">
            <div class="form-check mb-2">
              <input type="checkbox" class="form-check-input" id="login_remember">
              <label for="login_remember" class="form-check-label">Ingat saya</label>
            </div>
            <a href="#" class="fs-sm forgotPass">Lupa password?</a>
          </div>
          <button type="submit" class="btn btn-primary w-100 btnLogin">Login</button>
          <div class="loginThirdParty">
            <span>atau login dengan</span>
            <a href="#" class="loginGoogle">
              <img src="/assets/icons/google.svg"/>
            </a>
            <span class="validasiLogin">Kami tidak akan membagikan data pribadi Anda dengan siapapun</span>
          </div>
        </form>
        <form class="tab-pane fade" id="formAutodealRegister" autocomplete="off">
          <div class="mb-3 mb-sm-3">
            <input type="text" class="form-control" id="register_name" placeholder="Nama lengkap" autocomplete="off" required>
          </div>
          <div class="mb-3 mb-sm-3">
            <input type="email" class="form-control" id="register_email" placeholder="email@example.com" autocomplete="off" required>
          </div>
          <div class="mb-3 mb-sm-3">
            <div class="password-toggle">
              <input type="password" class="form-control" id="register_password" placeholder="password" autocomplete="off" required>
              <label class="password-toggle-btn">
                <input type="checkbox" class="password-toggle-check">
                <span class="password-toggle-indicator"></span>
              </label>
            </div>
          </div>
          <div class="mb-4 mb-sm-4">
            <div class="password-toggle">
              <input type="password" class="form-control" id="register_password_confirm" placeholder="confirm password" autocomplete="off" required>
              <label class="password-toggle-btn">
                <input type="checkbox" class="password-toggle-check">
                <span class="password-toggle-indicator"></span>
              </label>
            </div>
          </div>
          <button type="submit" class="btn btn-primary w-100 btnSubmit btnRegister">Daftar</button>
          <div class="loginThirdParty">
            <span>atau daftar dengan</span>
            <a href="#" class="loginGoogle">
              <img src="/assets/icons/google.svg"/>
            </a>
            <span class="validasiLogin">
              Dengan mendaftar, Anda setuju dengan 
              <a href="#">Syarat & ketentuan</a> serta <a href="#">Kebijakan privasi</a>
              dari Dealnesia
            </span>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modal Lupa Password -->
<div class="modal" id="modalForgot" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="loginTitle">
        <h4 class="pt-1 mb-0">Lupa Password?</h4>
        <!-- <span>Atur ulang kata sandi</span> -->
      </div>
      
      <form class="tab-pane fade show active" id="signin" autocomplete="off">
        <span class="tforgot-1">Masukkan email yang terhubung dengan akun Anda dan kami akan mengirim kode verifikasi untuk tahap selanjutnya</span>
        <div class="mb-4">
          <input type="email" class="form-control" id="email1" placeholder="email@example.com" autocomplete="username">
        </div>
        <!-- <button type="submit" class="btn btn-primary w-100 btnSubmit">Kirim</button> -->
        <a class="btn btn-primary w-100 btnSubmit" href="#" data-bs-toggle="modal" data-bs-target="#modalOTP">
          Kirim
        </a>
      </form>
        
    </div>
  </div>
</div>