<!-- Gadget detail -->
<div class="itemFit_02">
  <div class="itemFit_02-01">
    <label>GADGET</label>
    <hr>
  </div>
  <div class="row itemFit_02-03">
    <!-- input 1 -->
    <div class="col-sm-6 col-md-4">
      <h6>Merek & Sistem Operasi<span>*</span></h6>
      <label>Pilih merek dan Sistem Operasi yang sesuai untuk memudahkan pencarian</label>
    </div>
    <div class="row col-sm-6 col-md-8">
      <div class="col-sm-12 col-md-6">
        <select class="form-select" id="brand_id" name="brand_id">
          <option value="" selected disabled>Merek</option>
          @php
              foreach ($brand_id['data'] as $key => $value) {
                echo "<option value='{$value->id}'>{$value->text}</option>";
              }
          @endphp
        </select>
      </div>
      <div class="col-sm-12 col-md-6">
        <select class="form-select" id="os_id" name="os_id">
          <option value="" selected disabled>Sistem Operasi</option>
          @php
              foreach ($os_id['data'] as $key => $value) {
                echo "<option value='{$value->id}'>{$value->text}</option>";
              }
          @endphp
        </select>
      </div>
    </div>
    <!-- input 2 -->
    <div class="col-sm-6 col-md-4">
      <h6>RAM & Penyimpanan</h6>
      <label>Pilih RAM dan kapasitas penyimpanan yang sesuai dengan produkmu</label>
    </div>
    <div class="row col-sm-6 col-md-8">
      <div class="col-sm-12 col-md-6">
        <input class="form-control number-input" type="text" id="ram" name="ram" placeholder="2 GB" maxlength="3">
      </div>
      <div class="col-sm-12 col-md-6">
        <input class="form-control number-input" type="text" id="storage" name="storage" placeholder="500 GB" maxlength="9">
      </div>
    </div>
    <!-- input 3 -->
    <div class="col-sm-6 col-md-4">
      <h6>Tahun</h6>
      <label>Pilih tahun produksi produkmu</label>
    </div>
    <div class="row col-sm-6 col-md-8">
      <div class="col-sm-12 col-md-6">
        <input class='form-control year-input' type='text' pattern='[0-9]*' inputmode='numeric' name='year' id='year' minlength='4' maxlength='4' placeholder='2019'>
      </div>
    </div>

  </div>
</div>