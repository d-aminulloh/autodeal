@extends('layout.layout01')

@section('content')

  <div class="container py-5 create_main">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="bc_breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#" aria-label="Home"><i class="bi bi-house-fill"></i></a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Pasang Iklan</li>
      </ol>
    </nav>

    <h4>Pasang Iklan</h4>

    

    <form id="form_create">
      @csrf
      <div class="row pb-2 pb-sm-4 createIkl">
        <!-- Informasi -->
        <div class="itemFit_02">
          <div class="itemFit_02-01">
            <label>INFORMASI</label>
            <hr>
          </div>
          <div class="row itemFit_02-03">
            <!-- input 1 -->
            <div class="col-sm-6 col-md-4">
              <h6>Judul Iklan<span>*</span></h6>
              <label>Judul iklan max. 150 karakter dengan memasukkan merek, jenis iklan,dll</label>
            </div>
            <div class="col-sm-6 col-md-8">
              <input class="form-control" id="title" name="title" type="text" placeholder="Contoh: Mobil (Merek + Model) + Toko dll" maxlength="150" required>
            </div>
            <!-- input 2 -->
            <div class="col-sm-6 col-md-4">
              <h6>Kategori & Subkategori<span>*</span></h6>
              <label>Pilih kategori dan subkategori yang sesuai untuk memudahkan pencarian</label>
            </div>
            <div class="row col-sm-6 col-md-8">
              <div class="col-sm-12 col-md-6">
                <select class="form-select" id="category" name="category" required>
                  <option value="" selected disabled>Kategori</option>
                </select>
              </div>
              <div class="col-sm-12 col-md-6">
                <select class="form-select" id="category_id" name="category_id" required>
                  <option value="" selected disabled>Sub-kategori</option>
                  <option value="" disabled>-- pilih kategori dahulu --</option>
                </select>
              </div>
            </div>
            <!-- input 3 -->
            <div class="col-sm-6 col-md-4 f_ads_type_id">
              <h6>Tipe Iklan & Kondisi<span>*</span></h6>
              <label>Pilih tipe iklan Jual dengan kondisi Baru / Bekas <br>
                Pilih tipe iklan Sewa dengan durasi Harian, Mingguan, Bulanan, atau Tahunan</label>
            </div>
            <div class="row col-sm-6 col-md-8 f_ads_type_id">
              <div class="col-sm-12 col-md-6">
                <select class="form-select" id="ads_type_id" name="ads_type_id" required>
                  <option value="" selected disabled>Tipe Iklan</option>
                </select>
              </div>
              <div class="col-sm-12 col-md-6" id="f_condition_id" style="display: none">
                <select class="form-select" id="condition_id" name="condition_id">
                  <option value="" selected disabled>Durasi</option>
                  <option value="" disabled>-- pilih tipe iklan dahulu --</option>
                </select>
              </div>
              <div class="col-sm-12 col-md-6" id="f_duration_id" style="display: none">
                <select class="form-select" id="duration_id" name="duration_id">
                  <option value="" selected disabled>Durasi</option>
                  <option value="" disabled>-- pilih tipe iklan dahulu --</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div id="category_content" style="padding: 0px;"></div>
        <!-- Detail -->
        <div class="itemFit_02">
          <div class="itemFit_02-01">
            <label>DETAIL</label>
            <hr>
          </div>
          <div class="row itemFit_02-03">
            <!-- input 1 -->
            <div class="col-sm-6 col-md-4">
              <h6>Foto<span>*</span></h6>
              <label>Max. 15 foto. Format gambar .jpg .jpeg .png. Upload foto untuk menarik pelanggan</label>
            </div>
            <div class="col-sm-6 col-md-8">
              <!-- File input -->
              <div class="image-upload">
                <div class="image-preview" id="imagePreviewContainer">
                  <label for="imageUpload" class="image-upload-label" id="uploadLabel">
                    <div class="image-preview-item">
                      <label class="title-cover" id="uploadLabeltitleCover">COVER</label>
                      <span>
                        <img src="/assets/icons/add-img.svg" class="ico-add"/>
                      </span>
                      <input type="file" id="imageUpload" name="imageUpload[]" class="image-upload-input" multiple required accept="image/jpeg,image/png,image/jpg,image/webp" max="2097152">
                    </div>
                  </label>
                </div>
              </div>



              {{-- <div class="image-upload" id="imageUploadContainer">
                <div class="image-preview" id="imagePreviewContainer">
                  <div class="image-preview-item">
                        <img src="/uploads/item_tmp/6cbafa0f42e84b16a5fe5464d2d4f251.jpg" alt="Image Preview">
                        <button class="remove-btn" aria-label="Remove Image">×</button>
                      </div><div class="image-preview-item">
                        <img src="/uploads/item_tmp/d1302857595c4022a0240b8cb65ce5f7.jpg" alt="Image Preview">
                        <button class="remove-btn" aria-label="Remove Image">×</button>
                      </div><label for="imageUpload" class="image-upload-label" id="uploadLabel" style="display: inline-block;">
                    <div class="image-preview-item">
                      <span>
                        <img src="/assets/icons/add-img.svg" class="ico-add">
                      </span>
                      <input type="file" id="imageUpload" name="imageUpload[]" class="image-upload-input" multiple="" required="" accept="image/jpeg,image/png,image/jpg" max="2097152">
                    </div>
                  </label>
                </div>
              </div>

              <ul class="list-group" id="tes1">
                <li class="list-group-item">Item 1</li>
                <li class="list-group-item">Item 2</li>
                <li class="list-group-item">Item 3</li>
                <li class="list-group-item">Item 4</li>
                <li class="list-group-item">Item 5</li>
              </ul>

              <div id="tes2">
                <div class="list-group-item">Item 1</div>
                <div class="list-group-item">Item 2</div>
                <div class="list-group-item">Item 3</div>
                <div class="list-group-item">Item 4</div>
                <div class="list-group-item">Item 5</div>
              </div> --}}
        
              {{-- <div class="image-upload2">
                <div class="image-preview2" id="imagePreviewContainer">
                  <div class="image-preview-item2">
                        <img src="/uploads/item_tmp/6cbafa0f42e84b16a5fe5464d2d4f251.jpg" alt="Image Preview">
                        <button class="remove-btn" aria-label="Remove Image">×</button>
                      </div><div class="image-preview-item2">
                        <img src="/uploads/item_tmp/d1302857595c4022a0240b8cb65ce5f7.jpg" alt="Image Preview">
                        <button class="remove-btn" aria-label="Remove Image">×</button>
                      </div><label for="imageUpload" class="image-upload-label" id="uploadLabel" style="display: inline-block;">
                    <div class="image-preview-item2">
                      <span>
                        <img src="/assets/icons/add-img.svg" class="ico-add">
                      </span>
                      <input type="file" id="imageUpload" name="imageUpload[]" class="image-upload-input" multiple="" required="" accept="image/jpeg,image/png,image/jpg" max="2097152">
                    </div>
                  </label>
                </div>
              </div> --}}



            </div>
            <!-- input 2 -->
            <div class="col-sm-6 col-md-4 f_price">
              <h6>Harga<span>*</span></h6>
              <label>Tentukan harga</label>
            </div>
            <div class="row col-sm-6 col-md-8 f_price">
              <input class="form-control currency-input" type="text" id="price" name="price" data-type="currency" placeholder="Rp 100.000" maxlength="21" required>
            </div>
            <!-- input 3 -->
            <div class="col-sm-6 col-md-4">
              <h6>Deskripsi<span>*</span></h6>
              <label>Pastikan deskripsi memuat penjelasan detail, agar pembeli mudah mengerti</label>
            </div>
            <div class="row col-sm-6 col-md-8">
              <!-- Icon addon + textarea -->
              <div class="input-group">
                <span class="input-group-text align-self-start mt-1">
                  <i class="bi bi-feather"></i>
                </span>
                <textarea class="form-control" id="description" name="description" placeholder="Jelaskan produkmu disini..." rows="6" maxlength="5000" required></textarea>
              </div>
            </div>
          </div>
        </div>
        <!-- Lokasi -->
        <div class="itemFit_02">
          <div class="itemFit_02-01">
            <label>LOKASI</label>
            <hr>
          </div>
          <div class="row itemFit_02-03">
            <!-- input 1 -->
            <div class="col-sm-6 col-md-4">
              <h6>Provinsi & Kab / Kota<span>*</span></h6>
              <label>Pilih provinsi yang sesuai untuk memudahkan pencarian</label>
            </div>
            <div class="row col-sm-6 col-md-8">
              <div class="col-sm-12 col-md-6">
                <select class="form-select" id="province_id" name="province_id" required>
                  <option value="" selected disabled>Provinsi</option>
                </select>
              </div>
              <div class="col-sm-12 col-md-6">
                <select class="form-select" id="city_id" name="city_id" required>
                  <option value="" selected disabled>Kabupaten / Kota</option>
                  <option value="" disabled>-- pilih provinsi dahulu --</option>
                </select>
              </div>
            </div>
            <!-- input 2 -->
            <div class="col-sm-6 col-md-4">
              <h6>Kecamatan<span>*</span></h6>
              <label>Pilih kecamatan yang sesuai untuk memudahkan pencarian</label>
            </div>
            <div class="row col-sm-6 col-md-8">
              <div class="col-sm-12 col-md-6">
                <select class="form-select" id="address_id" name="address_id" required>
                  <option value="" selected disabled>Kecamatan</option>
                  <option value="" disabled>-- pilih Kabupaten / Kota dahulu --</option>
                </select>
              </div>
            </div>
            <!-- input 3 -->
            <div class="col-sm-6 col-md-4">
              <h6>Detail Alamat<span>*</span></h6>
              <label>Tuliskan detail alamatmu untuk memudahkan pencarian</label>
            </div>
            <div class="row col-sm-6 col-md-8">
              <!-- Icon addon + textarea -->
              <div class="input-group">
                <span class="input-group-text align-self-start mt-1">
                  <i class="bi bi-geo-alt"></i>
                </span>
                <textarea class="form-control" id="address_detail" name="address_detail" placeholder="Contoh : Jl. Sudirman 123, Patokan depan gedung 123..." rows="6" maxlength="250" required></textarea>
              </div>
            </div>
          </div>
        </div>
        <!-- button batal & simpan -->
        <div class="itemFit_02 txt-r">
          <button type="button" class="btn btn-secondary">Batal</button>
          <button type="button" id="btn_submit" class="btn btn-primary">Pasang</button>
        </div>


      </div>
    </form>
  </div>

@endsection

@section('js')
    <script src="/assets/js/appjs/item/create.js"></script>
@endsection

@section('css')
  <link rel="stylesheet" media="screen" href="/assets/vendor/lightgallery/css/lightgallery-bundle.min.css">
@endsection