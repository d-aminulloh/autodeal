<!-- Mobil detail -->
<div class='itemFit_02'>
  <div class='itemFit_02-01'>
    <label>MOBIL</label>
    <hr>
  </div>
  <div class='row itemFit_02-03'>
    <!-- input 1 -->
    <div class='col-sm-6 col-md-4'>
      <h6>Merek & Model<span>*</span></h6>
      <label>Pilih merek dan model yang sesuai untuk memudahkan pencarian</label>
    </div>
    <div class='row col-sm-6 col-md-8'>
      <div class='col-sm-12 col-md-6'>
        <select class='form-select' id='brand_id' name='brand_id' required>
          <option value='' selected disabled>Merek</option>
          @php
              foreach ($brand_id['data'] as $key => $value) {
                echo "<option value='{$value->id}'>{$value->text}</option>";
              }
          @endphp
        </select>
      </div>
      <div class='col-sm-12 col-md-6'>
        <select class='form-select' id='model_id' name='model_id' required>
          <option value='' selected disabled>Model</option>
          @php
              foreach ($model_id['data'] as $key => $value) {
                echo "<option value='{$value->id}' data-parent='{$value->parent}' style='display: none'>{$value->text}</option>";
              }
          @endphp

        </select>
        <script>
          $(function() {
            $('#brand_id').on('change', function() {
              var parent = $(this).val();
              $('#model_id option').each(function(){
                $(this).css('display', $(this).data('parent') == parent ? '' : 'none');
              });
              $('#model_id').val('').change();
              $('#model_id').prop('disabled', $('#model_id option:not([style*="display: none"])').length == 0);
              $('#model_id').css('display', $('#model_id option:not([style*="display: none"])').length == 0 ? 'none' : '');
            });
          });
        </script>
      </div>
    </div>
    <!-- input 2 -->
    <div class='col-sm-6 col-md-4'>
      <h6>Tahun & Jarak Tempuh</h6>
      <label>Pilih tahun produksi dan jarak yang sudah ditempuh</label>
    </div>
    <div class='row col-sm-6 col-md-8'>
      <div class='col-sm-12 col-md-6'>
        <input class='form-control year-input' type='text' pattern='[0-9]*' inputmode='numeric' name='year' id='year' minlength='4' maxlength='4' placeholder='2019'>
      </div>
      <div class='col-sm-12 col-md-6'>
        <input class="form-control number-input" type="text" id="mileage" name="mileage" placeholder="10,000 KM" maxlength="9">
      </div>
    </div>
    <!-- input 3 -->
    <div class='col-sm-6 col-md-4'>
      <h6>Transmisi<span>*</span></h6>
      <label>Pilih transmisi yang sesuai</label>
    </div>
    <div class='row col-sm-6 col-md-8'>
      <div class='d-content'>
        @php
            foreach ($transmission_id['data'] as $key => $value) {
              $checked = $key == 0 ? 'checked' : '';
              echo "
                <div class=''>
                  <input class='btn-check' type='radio' name='transmission_id' value='{$value->id}' id='transmission_id_{$value->id}' $checked required>
                  <label class='btn btn-outline-secondary px-2' for='transmission_id_{$value->id}'>
                    <span class='mx-1'>{$value->text}</span>
                  </label>
                </div>
              ";
            }
        @endphp
      </div>
    </div>
    <!-- input 4 -->
    <div class='col-sm-6 col-md-4 bbmb-32'>
      <h6>Bahan Bakar<span>*</span></h6>
      <label>Pilih jenis bahan bakar yang digunakan</label>
    </div>
    <div class='row col-sm-6 col-md-8'>
      <div class='d-content'>
        @php
            foreach ($fuel_id['data'] as $key => $value) {
              $checked = $key == 0 ? 'checked' : '';
              echo "
                <div class=''>
                  <input class='btn-check' type='radio' name='fuel_id' value='{$value->id}' id='fuel_id_{$value->id}' $checked required>
                  <label class='btn btn-outline-secondary px-2' for='fuel_id_{$value->id}'>
                    <span class='mx-1'>{$value->text}</span>
                  </label>
                </div>
              ";
            }
        @endphp
      </div>
    </div>
    <!-- input 5 -->
    <div class='col-sm-6 col-md-4'>
      <h6>Kapasitas Mesin & Penumpang</h6>
      <label>Pilih kapasitas mesin dan kapasitas penumpang yang sesuai</label>
    </div>
    <div class='row col-sm-6 col-md-8'>
      <div class='col-sm-12 col-md-6'>
        <input class="form-control number-input" type="text" id="engine_capacity" name="engine_capacity" placeholder="1,000 CC" maxlength="6">
      </div>
      <div class='col-sm-12 col-md-6'>
        <select class='form-select' id='passenger_qty_id' name='passenger_qty_id'>
          <option value='' selected disabled>Jumlah penumpang</option>
          @php
              foreach ($passenger_qty_id['data'] as $key => $value) {
                echo "<option value='{$value->id}'>{$value->text}</option>";
              }
          @endphp
        </select>
      </div>
    </div>
    <!-- input 6 -->
    <div class='col-sm-6 col-md-4'>
      <h6>Tipe Bodi & Warna</h6>
      <label>Pilih tipe bode dan warna yang sesuai</label>
    </div>
    <div class='row col-sm-6 col-md-8'>
      <div class='col-sm-12 col-md-6'>
        <select class='form-select' id='body_type_id' name='body_type_id'>
          <option value='' selected disabled>Tipe Bodi</option>
          @php
              foreach ($body_type_id['data'] as $key => $value) {
                echo "<option value='{$value->id}'>{$value->text}</option>";
              }
          @endphp
        </select>
      </div>
      <div class='col-sm-12 col-md-6'>
        <select class='form-select' id='color_id' name='color_id'>
          <option value='' selected disabled>Warna</option>
          @php
              foreach ($color_id['data'] as $key => $value) {
                echo "<option value='{$value->id}'>{$value->text}</option>";
              }
          @endphp
        </select>
      </div>
    </div>
    <!-- input 7 -->
    <div class='col-sm-6 col-md-4'>
      <h6>Tipe Penjual<span>*</span></h6>
      <label>Pilih tipe penjual yang sesuai dengan profilmu</label>
    </div>
    <div class='row col-sm-6 col-md-8'>
      <div class='d-content'>
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
    <div class='col-sm-6 col-md-4'>
      <h6>Layanan Penjual</h6>
      <label>Pilih layanan yang akan dipromosikan</label>
    </div>
    <div class='row col-sm-6 col-md-8'>
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
<!-- Detail -->