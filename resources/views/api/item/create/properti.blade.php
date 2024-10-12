<!-- Properti detail -->
<div class="itemFit_02">
  <div class="itemFit_02-01">
    <label>PROPERTI</label>
    <hr>
  </div>
  <div class="row itemFit_02-03">
    <!-- input 1 -->
    <div class="col-sm-6 col-md-4">
      <h6>Luas Bangunan & Luas Tanah<span>*</span></h6>
      <label>Masukkan luas bangunan dan luas tanah yang sesuai</label>
    </div>
    <div class="row col-sm-6 col-md-8">
      <div class="col-sm-12 col-md-6">
        <input class="form-control number-input" type="text" id="building_area" name="building_area" placeholder="Luas Bangunan" maxlength="9" required>
      </div>
      <div class="col-sm-12 col-md-6">
        <input class="form-control number-input" type="text" id="surface_area" name="surface_area" placeholder="Luas Tanah" maxlength="9" required>
      </div>
    </div>
    <!-- input 2 -->
    <div class="col-sm-6 col-md-4">
      <h6>Kamar Tidur & Kamar Mandi<span>*</span></h6>
      <label>Pilih kamar tidur dan kamar mandi yang sesuai untuk memudahkan pencarian</label>
    </div>
    <div class="row col-sm-6 col-md-8">
      <div class="col-sm-12 col-md-6">
        <input class="form-control number-input" type="text" id="bedroom_qty" name="bedroom_qty" placeholder="Jumlah Kamar Tidur" maxlength="2" required>
      </div>
      <div class="col-sm-12 col-md-6">
        <input class="form-control number-input" type="text" id="bathroom_qty" name="bathroom_qty" placeholder="Jumlah Kamar Mandi" maxlength="2" required>
      </div>
    </div>
    <!-- input 2 -->
    <div class="col-sm-6 col-md-4">
      <h6>Lantai</h6>
      <label>Pilih lantai yang sesuai untuk memudahkan pencarian</label>
    </div>
    <div class="row col-sm-6 col-md-8">
      <div class="col-sm-12 col-md-6">
        <input class="form-control number-input" type="text" id="floor" name="floor" placeholder="Jumlah Lantai" maxlength="2">
      </div>
    </div>
    <!-- input 3 -->
    <div class="col-sm-6 col-md-4">
      <h6>Sertifikat<span>*</span></h6>
      <label>Pilih sertifikat yang sesuai</label>
    </div>
    <div class="row col-sm-6 col-md-8">
      <div class="d-content">
        @php
            foreach ($certification_id['data'] as $key => $value) {
              $checked = $key == 0 ? 'checked' : '';
              echo "
                <div class=''>
                  <input class='btn-check' type='radio' name='certification_id' value='{$value->id}' id='certification_id_{$value->id}' $checked required>
                  <label class='btn btn-outline-secondary px-2' for='certification_id_{$value->id}'>
                    <span class='mx-1'>{$value->text}</span>
                  </label>
                </div>
              ";
            }
        @endphp
      </div>
    </div>
    <!-- input 7 -->
    <div class="col-sm-6 col-md-4">
      <h6>Tipe Penjual<span>*</span></h6>
      <label>Pilih tipe penjual yang sesuai dengan profilmu</label>
    </div>
    <div class="row col-sm-6 col-md-8">
      <div class="d-content">
        @php
            foreach ($seller_type_id['data'] as $key => $value) {
              $checked = $key == 0 ? 'checked' : '';
              echo "
                <div class=''>
                  <input class='btn-check' type='radio' name='seller_type_id' value='{$value->id}' id='seller_type_id_{$value->id}' $checked required>
                  <label class='btn btn-outline-secondary px-2' for='seller_type_id_{$value->id}'>
                    <span class='mx-1'>{$value->text}</span>
                  </label>
                </div>
              ";
            }
        @endphp
      </div>
    </div>
    <!-- input 8 -->
    <div class="col-sm-6 col-md-4">
      <h6>Fasilitas</h6>
      <label>Masukkan fasilitas yang tersedia</label>
    </div>
    <div class="row col-sm-6 col-md-8">
      @php
        foreach ($service_id['data'] as $key => $value) {
          echo "
            <div class='form-check form-check-inline'>
              <input class='form-check-input' type='checkbox' id='service_id_{$value->id}' name='service_id[]' value='{$value->id}'>
              <label class='form-check-label' for='service_id_{$value->id}'>{$value->text}</label>
            </div>
          ";
        }
      @endphp
    </div>
  </div>
</div>