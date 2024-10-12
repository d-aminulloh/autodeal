<!-- LOWONGAN KERJA detail -->
<div class="itemFit_02">
  <div class="itemFit_02-01">
    <label>LOWONGAN KERJA</label>
    <hr>
  </div>
  <div class="row itemFit_02-03">
    <!-- input 1 -->
    <div class="col-sm-6 col-md-4">
      <h6>Tipe Pekerjaan<span>*</span></h6>
      <label>Pilih tipe pekerjaan yang sesuai untuk memudahkan pencarian</label>
    </div>
    <div class="row col-sm-6 col-md-8">
      <div class="col-sm-12 col-md-6">
        <select class="form-select" id="job_type_id" name="job_type_id" required>
          <option value="" selected disabled>Tipe pekerjaan</option>
          @php
              foreach ($job_type_id['data'] as $key => $value) {
                echo "<option value='{$value->id}'>{$value->text}</option>";
              }
          @endphp
        </select>
      </div>
    </div>
    <!-- input 2 -->
    <div class="col-sm-6 col-md-4">
      <h6>Rentang Umur</h6>
      <label>Masukkan rentang umur untuk memudahkan pencarian</label>
    </div>
    <div class="row col-sm-6 col-md-8">
      <div class="col-sm-12 col-md-6">
        <input class='form-control year-input' type='text' pattern='[0-9]*' inputmode='numeric' name='year' id='year' maxlength='3' placeholder='20'>
      </div>
      <div class="col-sm-12 col-md-6">
        <input class='form-control year-input' type='text' pattern='[0-9]*' inputmode='numeric' name='year_max' id='year_max' maxlength='3' placeholder='28'>
      </div>
    </div>
    <!-- input 2 -->
    <div class="col-sm-6 col-md-4">
      <h6>Rentang Gaji<span>*</span></h6>
      <label>Masukkan rentang gaji yang ditawarkan</label>
    </div>
    <div class="row col-sm-6 col-md-8">
      <div class="col-sm-12 col-md-6">
        <input class="form-control currency-input" type="text" id="gaji" name="gaji" data-type="currency" placeholder="Rp 2.000.000" maxlength="21" required>
      </div>
      <div class="col-sm-12 col-md-6">
        <input class="form-control currency-input" type="text" id="gaji_max" name="gaji_max" data-type="currency" placeholder="Rp 4,000.000" maxlength="21" required>
      </div>
    </div>
    <!-- input 3 -->
    <div class="col-sm-6 col-md-4">
      <h6>Jenis Kelamin</h6>
      <label>Pilih jenis kelamin untuk memudahkan pencarian</label>
    </div>
    <div class="row col-sm-6 col-md-8">
      <div class="col-sm-12 col-md-6">
        <div class="d-content">
          @php
            foreach ($gender_id['data'] as $key => $value) {
              $checked = $key == 0 ? 'checked' : '';
              echo "
                <div class='d-inblock'>
                  <input class='btn-check' type='radio' name='gender_id' value='{$value->id}' id='gender_id_{$value->id}' $checked required>
                  <label class='btn btn-outline-secondary px-2' for='gender_id_{$value->id}'>
                    <span class='mx-1'>{$value->text}</span>
                  </label>
                </div>
              ";
            }
          @endphp
        </div>
      </div>
    </div>


  </div>
</div>