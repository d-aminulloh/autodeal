@extends('layout.layout')

@section('content')
  <input type="hidden" value="{{$data->seller_id ??""}}" id="seller_id" autocomplete="off">
  <input type="hidden" value="{{$data->id2 ??""}}" id="item_id" autocomplete="off">

  <!-- Page container -->
  <div class="container py-5 mt-5 mb-lg-4 mb-xl-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="bc_breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#" aria-label="Home"><i class="bi bi-house-fill"></i></a>
        </li>
        <li class="breadcrumb-item"><a href="/item/search/c-{{$data->category_parent_slug}}/q-">Kategori {{$data->category_parent_name}}</a></li>
        <li class="breadcrumb-item"><a href="/item/search/c-{{$data->category_slug}}/q-">{{$data->category_name}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$data->title}}</li>
      </ol>
    </nav>

    <?php if(!$data){ ?>
      <section class="itemDetail_desc">
        <div class="container">
          <div class="row">
            <div class="leftDetail" style="width: 100%;">
              <div class="itemFit_01" style="padding: 50px 50px">
                <h4>Oops... Iklan tidak ditemukan.</h4>
              </div>
            </div>
          </div>
        </div>
      </section>
    <?php } else { ?>

      <!-- Image Carousel -->
      <div class="position-relative itemDetail_img">

        <!-- External slider prev/next buttons -->
        <button type="button" id="prev" class="btn btn-prev btn-icon btn-sm btn-outline-primary rounded-circle position-absolute top-50 start-0 translate-middle-y" aria-label="Prev">
          <i class="bi bi-arrow-left"></i>
        </button>
        <button type="button" id="next" class="btn btn-next btn-icon btn-sm btn-outline-primary rounded-circle position-absolute top-50 end-0 translate-middle-y" aria-label="Next">
          <i class="bi bi-arrow-right"></i>
        </button>

        <!-- Data total image -->
        <div class="lbl_detimg">
          <i class="bi bi-image-fill"></i>
          <span>{{$image_total}}</span> Foto
        </div>

        <!-- Slider -->
        <div class="swiper" id="lightgallery" data-swiper-options='{
          "slidesPerView": 1,
          "spaceBetween": 12,
          "loop": false,
          "navigation": {
            "prevEl": "#prev",
            "nextEl": "#next"
          },
          "breakpoints": {
            "600": {
              "slidesPerView": 2
            },
            "1000": {
              "slidesPerView": 3
            }
          }
        }'>
          <div class="swiper-wrapper gallery" data-thumbnails="true">

            <?php
              $width = "32.7%";
              if($image_total == 1){
                $width = "100%";
              } else if($image_total == 2){
                $width = "49.5%";
              }
              echo "<style>.swiper-slide-custom{width: $width !important}</style>";
            ?>

            <!-- Item 1 -->
            <div class="swiper-slide swiper-slide-custom">
              <div class="ratio">
                <a href="{{$image_path}}{{$data->image_cover}}" class="gallery-item d-block card-hover">
                  <div class="detail_box opacity-0">
                    <i class="bi bi-zoom-in"></i>
                    <div class="position-absolute bottom-0 start-0 w-100 text-center text-white fs-sm fw-medium z-2 pb-3"></div>
                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-40"></div>
                  </div>
                  <img src="{{$image_path}}{{$data->image_cover}}" class="d-block" alt="Image 1">
                </a>
              </div>
            </div>

            <?php
            
              if($image){
                $i = 1;

                foreach ($image as $key => $value) {
                  $i++;
                  echo "
                    <div class='swiper-slide swiper-slide-custom'>
                      <div class='ratio'>
                        <a href='$image_path$value->image' class='gallery-item d-block card-hover'>
                          <div class='detail_box opacity-0'>
                            <i class='bi bi-zoom-in'></i>
                            <div class='position-absolute bottom-0 start-0 w-100 text-center text-white fs-sm fw-medium z-2 pb-3'></div>
                            <div class='position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-40'></div>
                          </div>
                          <img src='$image_path$value->image' class='d-block' alt='Image $i'>
                        </a>
                      </div>
                    </div>
                  ";
                }
              }
            ?>


          </div>
        </div>
      </div>

      <section class="itemDetail_desc">
        <div class="container">
          <div class="row">

            <!-- Left Column -->
            <div class="leftDetail">
              <!-- fitur 1 -->
              <div class="itemFit_01">
                <div class="itemFit_01-01">
                  <div class="itemFit_01-01_01">
                    {{-- <span class="sty-jual">Jual</span>
                    <span class="sty-sewa">Sewa</span>
                    <span class="sty-baru">Baru</span>
                    <span class="sty-bekas">Bekas</span> --}}
                    <span class="{{$data->ads_type_label}}">{{$data->ads_type_text}}</span>
                    <span class="{{$data->condition_label ?? $data->duration_label}}">{{$data->condition_text ?? $data->duration_text}}</span>

                  </div>
                  <div class="itemFit_01-01_02">
                    <span>Diposting tanggal:</span>
                    <span>{{$data->created_date}}</span>
                  </div>
                </div>
                <div class="itemFit_01-02">
                  <h5>{{$data->title}}</h5>
                  @php
                      if(!empty($data->price)) echo "<h2>Rp <span>".number_format($data->price, 0, ',', '.')."";
                      if(!empty($data->price_max)) echo " - Rp ".number_format($data->price_max, 0, ',', '.')."";
                      if(!empty($data->price)) echo "</span></h2>";
                  @endphp
                </div>
                <div class="itemFit_01-04">
                  <div class="itemFit_01-04_01">
                    <button class="btn btn-secondary favButton" type="button" aria-label="Add to Favorites" data-id="{{$data->id2}}" data-fav='{{$data->is_fav == '0' ? '0':'1'}}' data-en='{{Auth::check() ? '1':'0'}}'>
                      <i class="bi bi-heart{{$data->is_fav == '0' ? '':'-fill'}}"></i> Favorit
                    </button>
                    <a class="btn btn-secondary share-btn"><i class="bi bi-share"></i>Bagikan</a>
                  </div>
                  <div class="itemFit_01-04_02">
                    <a href="#" class="reportUser"><i class="bi bi-flag"></i>Laporkan iklan</a>
                  </div>
                </div>
              </div>
              <!-- fitur 2 -->
              <div class="itemFit_02">
                <div class="itemFit_02-01">
                  <label>DETAIL</label>
                  <hr>
                </div>
                <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 itemFit_02-02">
                  @php
                      if(isset($data->service_id) && !empty($data->service_id)){
                        $services = explode(",", $data->service_id);
                        $exists = false;
                        // $arr = array($service_id['data']['id'] => $service_id['data']['text']);
                        
                        $arr_services = array();
                        foreach ($service_id['data'] as $obj) {
                            $arr_services[$obj->id] = $obj->text;
                        }

                        // print_r($arr_services);
                        foreach ($services as $key => $value) {
                          $exists = true;
                          if(isset($arr_services[$value])){
                            echo "
                              <div class='col'>
                                <div class='form-check'>
                                  <input class='form-check-input' type='checkbox' id='layPenjual_{$value}' checked disabled>
                                  <label class='form-check-label d-flex align-items-center' for='layPenjual_{$value}'>".$arr_services[$value]."</label>
                                </div>
                              </div>
                            ";
                          }
                        }
                      }
                  @endphp
                </div>
                @php
                  if($exists ?? false) echo "<hr class='hr-16'>";
                @endphp
                
                <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 itemFit_02-03">
                  <!-- item 1 -->
                  <?php
                    //general
                    if($data->category_name) echo "<div class='col'><span>Tipe :</span><span>$data->category_name</span></div>";

                    //properti
                    if($data->bedroom_qty) echo "<div class='col'><span>Kamar Tidur :</span><span>$data->bedroom_qty</span></div>";
                    if($data->bathroom_qty) echo "<div class='col'><span>Kamar Mandi :</span><span>$data->bathroom_qty</span></div>";
                    if($data->building_area) echo "<div class='col'><span>Luas Bangunan :</span><span>".intval($data->building_area)." m2</span></div>";
                    if($data->surface_area) echo "<div class='col'><span>Luas Tanah :</span><span>".intval($data->surface_area)." m2</span></div>";
                    if($data->floor) echo "<div class='col'><span>Lantai :</span><span>$data->floor</span></div>";
                    if($data->certification_id_text) echo "<div class='col'><span>Sertifikat :</span><span>$data->certification_id_text</span></div>";
                    if($data->seller_type_id_property_text) echo "<div class='col'><span>Tipe Penjual :</span><span>$data->seller_type_id_property_text</span></div>";

                    // mobil motor
                    if($data->brand_id_text) echo "<div class='col'><span>Merk :</span><span>$data->brand_id_text</span></div>";
                    if($data->model_id_text) echo "<div class='col'><span>Model :</span><span>$data->model_id_text</span></div>";
                    if($data->transmission_id_car) echo "<div class='col'><span>Transmisi :</span><span>$data->transmission_id_car</span></div>";
                    if($data->fuel_id_car) echo "<div class='col'><span>Bahan Bakar :</span><span>$data->fuel_id_car</span></div>";
                    if($data->body_type_id_car) echo "<div class='col'><span>Tipe Bodi :</span><span>$data->body_type_id_car</span></div>";
                    if($data->transmission_id_motorcycle) echo "<div class='col'><span>Transmisi :</span><span>$data->transmission_id_motorcycle</span></div>";
                    if($data->fuel_id_motorcycle) echo "<div class='col'><span>Bahan Bakar :</span><span>$data->fuel_id_motorcycle</span></div>";
                    if($data->body_type_id_motorcycle) echo "<div class='col'><span>Tipe Bodi :</span><span>$data->body_type_id_motorcycle</span></div>";
                    if($data->passenger_qty_id_label) echo "<div class='col'><span>Jumlah Penumpang :</span><span>$data->passenger_qty_id_label</span></div>";

                    // $yearlabel ="Tahun";
                    // if($data->category_parent_id == '7') $yearlabel ="Umur"; 
                    if($data->year) echo "<div class='col'><span>Tahun :</span><span>$data->year</span></div>";
                    if($data->year_max) echo "<div class='col'><span>Tahun Maksimal:</span><span>$data->year_max</span></div>";
                    if($data->mileage) echo "<div class='col'><span>Jarak Tempuh :</span><span>".number_format($data->mileage, 0, ",", ".")." KM</span></div>";
                    if($data->engine_capacity) echo "<div class='col'><span>Kapasitas Mesin :</span><span>".number_format($data->engine_capacity, 0, ",", ".")." CC</span></div>";
                    if($data->color_id_vehicle_text) echo "<div class='col'><span>Warna :</span><span>$data->color_id_vehicle_text</span></div>";

                    if($data->os_id_text) echo "<div class='col'><span>OS :</span><span>$data->os_id_text</span></div>";
                    if($data->ram) echo "<div class='col'><span>RAM :</span><span>".number_format($data->ram, 0, ",", ".")." GB</span></div>";
                    if($data->storage) echo "<div class='col'><span>Penyimpanan :</span><span>".number_format($data->storage, 0, ",", ".")." GB</span></div>";

                    if($data->job_type_id_text) echo "<div class='col'><span>Tipe Pekerjaan :</span><span>". $data->job_type_id_text ."</span></div>";
                    if($data->gender_id_text) echo "<div class='col'><span>Jenis Kelamin :</span><span>". $data->gender_id_text."</span></div>";


                  ?>
                  
                </div>
              </div>
              
              <!-- fitur 3 -->
              <div class="itemFit_03">
                <div class="itemFit_03-01">
                  <label>DESKRIPSI</label>
                  <hr>
                </div>
                <div class="itemFit_03-02">
                  <p>{!! nl2br(e($data->description)) !!}</p>
                </div>
              </div>

            </div>

            <!-- Right Column -->
            <div class="rightDetail">
              <div class="profileDetail">
                <div class="p1img">
                  <?php
                    if($data->seller_profile_image) {
                      echo "<img src='".env('PATH_USER')."$data->seller_profile_image'/>";
                    } else {
                      echo "<i class='bi bi-person'></i>";
                    }
                  ?>
                </div>
                <div class="p2det">
                  <div>{{$data->seller_name}}</div>
                  <span>Bergabung pada {{Helpers::myFormatDate($data->seller_created_at)}}</span>
                  <a href="#">Lihat Profil</a>
                </div>
                <div class="p3ver">
                  <div class="ico3ver"><i class="bi bi-person-fill-check"></i></div>
                  <div class="tex3ver">
                    <a href="#" class="btn btn-primary">
                      <i class="bi bi-send-fill"></i> Kirim Pesan
                    </a>
                  </div>
                </div>
                <!-- Collapse -->
                <div class="p4md">

                  <div class="accordion accordion-alt pb-2 mb-4" id="det4">
                    <!-- detail -->
                    <div class="accordion-item mb-0">
                      <div class="accordion-collapse collapse show" id="det4more" data-bs-parent="#shopCategories">
                        <div class="accordion-body py-1 mb-1">
                          
                          <div class="detbio">
                            <label>BIO</label>
                            <p>{{$data->seller_bio}}</p>
                          </div>

                          <div class="detcontact">
                            <label>KONTAK</label>
                            <div class="detphone">
                              <?php
                              if(!Auth::check()){
                              $data->seller_phone = "*** *** ***";
                                echo "
                                  <a href='#' onClick='openLoginModal()'>
                                    <div class='ico4detr'><i class='bi bi-telephone-fill'></i></div>
                                    <p>$data->seller_phone</p>
                                  </a>
                                ";                              
                              } else {
                                if($data->wa_available == '1'){
                                  echo "
                                    <a target='_blank' href='https://wa.me/$data->seller_phone'>
                                      <div class='ico4detr'><img src='/assets/icons/wa-ico.svg'/></div>
                                      <p>$data->seller_phone</p>
                                    </a>
                                  ";
                                } else {
                                  echo "
                                    <a href='tel:$data->seller_phone'>
                                      <div class='ico4detr'><i class='bi bi-telephone-fill'></i></div>
                                      <p>$data->seller_phone</p>
                                    </a>
                                  ";
                                }
                              }
                              ?>
                            </div>
                            <ul>
                              <?php
                                if($sosmed = $data->seller_sosmed_facebook){
                                  if(str_starts_with($sosmed,'@')) $sosmed = substr($sosmed, 1);
                                  echo "<li><a target='_blank' href='https://www.facebook.com/$sosmed'><img src='/assets/icons/fb-ico.svg'></a></li>";
                                }
                                if($sosmed = $data->seller_sosmed_instagram){
                                  if(str_starts_with($sosmed,'@')) $sosmed = substr($sosmed, 1);
                                  echo "<li><a target='_blank' href='https://www.instagram.com/$sosmed'><img src='/assets/icons/ig-ico.svg'></a></li>";
                                }
                                if($sosmed = $data->seller_sosmed_youtube){
                                  if(str_starts_with($sosmed,'@')) $sosmed = substr($sosmed, 1);
                                  echo "<li><a target='_blank' href='https://www.youtube.com/user/$sosmed'><img src='/assets/icons/yt-ico.svg'></a></li>";
                                }
                                if($sosmed = $data->seller_sosmed_tiktok){
                                  if(!str_starts_with($sosmed,'@')) $sosmed = '@'.$sosmed;
                                  echo "<li><a target='_blank' href='https://www.tiktok.com/$sosmed'><img src='/assets/icons/tt-ico.svg'></a></li>";
                                }
                              ?>
                            </ul>
                          </div>

                          <div class="detaddress">
                            <label>ALAMAT</label>
                            <p>{{$data->location}} {{$data->address_detail}}</p>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      
      <!-- Page title -->
      <div class="row pt-xl-3 mt-sm-0 titleLainnya iklanseller">
        <div class="col-lg-9 pt-lg-3">
          <img src="/assets/icons/star.png" class="iconNew"/>
          <h4 class="pb-2 pb-sm-3">Iklan `{{explode(" ", $data->seller_name)[0]}}` lainnya</h4>
        </div>
      </div>

      <div class="row pb-2 pb-sm-4 iklanseller">
        <!-- Product grid -->
        <div class="col-lg-12 listProduct">
          <div class="row row-cols-2 row-cols-sm-2 row-cols-md-4 g-4" id="other-item"></div>
        </div>
      </div>
    <?php } ?>
  </div>

@endsection

@section('js')
    <script src="/assets/js/appjs/item/detail.js"></script>
@endsection

@section('jsinit')
    <script src="/assets/vendor/lightgallery/lightgallery.min.js"></script>
    <script src="/assets/vendor/lightgallery/plugins/fullscreen/lg-fullscreen.min.js"></script>
    <script src="/assets/vendor/lightgallery/plugins/thumbnail/lg-thumbnail.min.js"></script>
    <script src="/assets/vendor/lightgallery/plugins/zoom/lg-zoom.min.js"></script>
@endsection


@section('css')
  <link rel="stylesheet" media="screen" href="/assets/vendor/lightgallery/css/lightgallery-bundle.min.css">
@endsection