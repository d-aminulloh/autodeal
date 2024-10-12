let pageSearchItem = 1;
// let active_filter = ["brandc", "modc", "year", "transc", "fuelc", "engc", "bodyc", "passec", "colv", "sellv"];
const active_filter = $("#c_filter").val().split(",");
// console.log(active_filter)

$(document).ready(function () {
  $("#btn-search-item-next").on('click',function (e) { 
    // console.log('a')
    pageSearchItem ++
    load_item_search()
  });

  init_filter_value();
  initjs();
  load_filter()

});

function init_filter_value(){
  // filter price
  load_filter_price();

  // filter year
  if(isActiveFilter("year")) init_value_year();
  // if(isActiveFilter("yearb")) init_value_year();
  if(isActiveFilter("yearu")) init_value_year();
  
}

function initjs() {
  // console.log("init");
  pageSearchItem = 1;
  $("#landing-search-item").html('');
  load_item_search();
}

function load_item_search(){
  let latitude = '';
  let longitude = '';
  if(localStorage.getItem('mylocation')){
    const row = JSON.parse(atob(localStorage.getItem('mylocation')));
    latitude = row.latitude
    longitude = row.longitude
  }

  let data={
    page: pageSearchItem,
    limit: 24,
    location:$(".locationBox").val() ?? "",
    category:$("#c_category_id").val(),
    search:$("#autodealSearch").val(),
    sortby:$("#autodealSortBy").val(),
    latitude:latitude,
    longitude:longitude,
    pmin: getValueRp($("#fltr-pmin").val()),
    pmax: getValueRp($("#fltr-pmax").val()),
    ...buildParams('search')
  }
  
  $.ajax({
    url: BASE_URL + 'api/item/get-item',
    type:'GET',
    data: data,
    dataType: "json",
    beforeSend: function(){ 
      $("#btn-search-item-next").html(`Selanjutnya...`);
      $("#btn-search-item-next").attr("disabled", true);
      $("#loading-search-item").show();
    },
    complete: function(){
      $("#btn-search-item-next").html(`Selanjutnya`);
      $("#btn-search-item-next").removeAttr("disabled");
      $("#loading-search-item").hide();
    },
    success:function(res, textStatus, xhr){
      if(xhr.status == 200 && res.status){
        //set total iklan
        let total_ads = parseFloat(res.data.pagination.total_records).toLocaleString('id-ID', { currency: 'IDR' })
        $('.total_item').html(total_ads);
        jQuery.each(res.data.data, function(index, row){

          let quick_specification = "";
          jQuery.each((row['quick_specification']??"").split(';'), function(i, r){
            if(r) quick_specification += `<span>${r}</span>`
          })

          let price_label = ''
          if(row['price']){
            let price = parseFloat(row['price']).toLocaleString('id-ID', { currency: 'IDR' })
            let price_max = '';
            if(row['price_max']){
              price_max = ' - ' + parseFloat(row['price_max']).toLocaleString('id-ID', { currency: 'IDR' })
            }
            price_label = `
              <div class="d-flex mb-1">
                <h3 class="h4 mb-0">
                  <span>Rp </span>
                  ${price}${price_max}
                </h3>
              </div>
            `
          }

          let condition_label = `<span>${row['category_name']}</span>`;
          if(row['ads_type_text']){
            condition_label = `
              <span>${row['ads_type_text']}</span>
              -
              <span>${row['condition_text'] ?? row['duration_text']}</span>
            `
          }

          let view_count = parseFloat(row['view_count']).toLocaleString('id-ID', { currency: 'IDR' })
          let is_fav = (row['is_fav'] ?? '0') == '0' ? '0':'1'
          let is_fav_class = (row['is_fav'] ?? '0') == '0' ? '':'-fill'
          let is_enable = $("#5b83214c8e50617707dad0bfc97f3abb").length == "0" ? "0":"1";

          let new_content = `
            <div class="col">
              <div class="card-hover position-relative rounded-1 mb-3 /*premiumProduct*/">
                <!-- badge + favourite -->
                <span class="position-absolute badgePremium">
                  <img src="/assets/icons/lightning.svg"/>
                  PARTNER
                </span>
                <button class="btn btn-icon btn-sm btn-light bg-light border-0 position-absolute top-0 end-0 mt-3 me-3 z-5 favButton" type="button" aria-label="Add to Favorites" data-id="${row['id2']}" data-fav='${is_fav}' data-en='${is_enable}'>
                  <i class="bi bi-heart${is_fav_class}"></i>
                </button>
                <a href="/item/i-${row['id2']}" class="itemProduct">
                  <!-- image -->
                  <img class="d-block mx-auto img-product" src="${row['image_cover']}" alt="Product">
                  <!-- detail -->
                  <figcaption>
                    <div class="d-flex align-items-center infoViewer">
                      <span class="me-2 quickInfo">
                        ${condition_label}
                      </span>
                      <span class="quickView">
                        <i class="bi bi-eye"></i>
                        ${view_count}
                      </span>
                    </div>
                    <div class="d-flex quickSpec">
                      ${quick_specification}
                    </div>
                    <div class="d-flex titleProduk">
                      <span>${row['title']}</span>
                    </div>
                    ${price_label}
                    <div class="d-flex align-items-center placeDate">
                      <span class="me-2">${row['location']}</span>
                      <span>${myFormatDate(row['created_date'])}</span>
                    </div>
                  </figcaption>
                </a>
              </div>
            </div>
          `;
          var new_item = $(new_content).hide();
          $("#landing-search-item").append(new_item);
          new_item.fadeIn(500);
        });
      }
    }
  });
}


let filterUrl = ""
function doSearchFilter(){
  // localStorage.setItem('search',btoa($("#autodealSearch").val()))
  const search = encodeURIComponent($("#autodealSearch").val().trim());
  const sortby = encodeURIComponent($("#autodealSortBy").val() ?? "");
  
  $('.autodealSearchText').html((search ?? "") == "" ? "Pencarian":search)

  // let current_url = window.location.pathname.split('/')
  const catUrl = window.location.pathname.split('/')[3] ?? ""

  // cek filter
  //price
  let pmin = getValueRp($("#fltr-pmin").val())
  if(pmin)filterUrl += `&pmin=${pmin}`
  let pmax = getValueRp($("#fltr-pmax").val())
  if(pmax)filterUrl += `&pmax=${pmax}`

  
  buildUrlParams("atype") // atype
  buildUrlParams("acond") // acond
  buildUrlParams("adur") // adur

  buildUrlParams("brandc") // brandc
  buildUrlParams("modc") // modc
  buildUrlParams("transc") // transc
  buildUrlParams("fuelc") // fuelc
  buildUrlParams("engc") // engc
  buildUrlParams("bodyc") // bodyc
  buildUrlParams("passec") // passec
  buildUrlParams("colv") // colv
  buildUrlParams("sellv") // sellv

  buildUrlParams("brandm") // brandm
  buildUrlParams("modm") // modm
  buildUrlParams("transm") // transm
  buildUrlParams("engm") // engm
  buildUrlParams("bodym") // bodym

  buildUrlParams("bedr") // bedr
  buildUrlParams("bath") // bath
  buildUrlParams("floor") // floor
  buildUrlParams("cert") // cert
  buildUrlParams("sellp") // sellp

  buildUrlParams("brandg") // brandg
  buildUrlParams("os") // os
  buildUrlParams("ram") // ram
  buildUrlParams("stor") // stor

  buildUrlParams("gen") // gen
  buildUrlParams("genp") // genp
  buildUrlParams("jobt") // jobt

  //year
  if(isActiveFilter("year") /*|| isActiveFilter("yearb") */ || isActiveFilter("yearu")){
    let ymin = getValueRp($("#fltr-year_min").val())
    if(ymin)filterUrl += `&ymin=${ymin}`
    let ymax = getValueRp($("#fltr-year_max").val())
    if(ymax)filterUrl += `&ymax=${ymax}`
  }

  // console.log(filterUrl)

  // cek apakah ada di page category
  let url = `${BASE_URL}item/search/q-${search}?sort=${sortby}`;
  if(catUrl.startsWith('c-')) url = `${BASE_URL}item/search/${catUrl}/q-${search}?sort=${sortby}${filterUrl}`;
  else if(catUrl.startsWith('cs-')) url = `${BASE_URL}item/search/${catUrl}/q-${search}?sort=${sortby}${filterUrl}`;

  window.location.href = url
}

function isActiveFilter(val){
  return active_filter.find(e=> e == val)
}

function load_filter(){

  // filter category
  load_filter_category($("#c_category_id").val());



  
  load_filter_check("atype", "fltr-atype") // filter atype

  // filter acond
  if((urlParams.get('atype') ?? "").includes("1")){
    load_filter_check("acond", "fltr-acond") 
  } else {
    $("#fltr-acond").parent().remove();
  }

  // filter adur
  if((urlParams.get('atype') ?? "").includes("2")){
    load_filter_check("adur", "fltr-adur") 
  } else {
    $("#fltr-adur").parent().remove();
  }

  for (let i = 0; i < (active_filter ?? []).length; i++) {
    val = active_filter[i]


    if(val == 'brandc') load_filter_check("brandc","fltr-brandc", "Merk") // filter brandc  
    else if(val == 'modc') load_filter_check("modc","fltr-modc", "Model") // filter modc  
    else if(val == 'transc') load_filter_check("transc", "fltr-transc", "Transmisi") // filter transc  
    else if(val == 'fuelc') load_filter_check("fuelc", "fltr-fuelc", "Bahan Bakar") // filter fuelc  
    else if(val == 'engc') load_filter_check("engc", "fltr-engc", "Kapasitas Mesin") // filter engc  
    else if(val == 'bodyc') load_filter_check("bodyc", "fltr-bodyc", "Tipe Bodi") // filter bodyc  
    else if(val == 'passec') load_filter_check("passec", "fltr-passec", "Jumlah Tempat Duduk") // filter passec
    else if(val == 'colv') load_filter_check("colv", "fltr-colv", "Warna") // filter colv
    else if(val == 'sellv') load_filter_check("sellv", "fltr-sellv", "Tipe Penjual") // filter sellv
    else if(val == 'year') load_filter_year("Tahun") // filter year
    // else if(val == 'yearb') load_filter_year("Umur") // filter umur min max
    else if(val == 'yearu') load_filter_year("Umur") // filter umur

    else if(val == 'brandm') load_filter_check("brandm","fltr-brandm", "Merk") // filter brandm  
    else if(val == 'modm') load_filter_check("modm","fltr-modm", "Model") // filter modm  
    else if(val == 'transm') load_filter_check("transm", "fltr-transm", "Transmisi") // filter transm  
    else if(val == 'engm') load_filter_check("engm", "fltr-engm", "Kapasitas Mesin") // filter engm  
    else if(val == 'bodym') load_filter_check("bodym", "fltr-bodym", "Tipe Bodi") // filter bodym  

    else if(val == 'bedr') load_filter_check("bedr", "fltr-bedr", "Kamar Tidur") // filter bedr  
    else if(val == 'bath') load_filter_check("bath", "fltr-bath", "Kamar Mandi") // filter bath  
    else if(val == 'floor') load_filter_check("floor", "fltr-floor", "Lantai") // filter floor  
    else if(val == 'cert') load_filter_check("cert", "fltr-cert", "Sertifikat") // filter cert  
    else if(val == 'sellp') load_filter_check("sellp", "fltr-sellp", "Tipe Penjual") // filter sellp  

    else if(val == 'brandg') load_filter_check("brandg", "fltr-brandg", "Merk") // filter os
    else if(val == 'os') load_filter_check("os", "fltr-os", "OS") // filter os
    else if(val == 'ram') load_filter_check("ram", "fltr-ram", "RAM") // filter ram
    else if(val == 'stor') load_filter_check("stor", "fltr-stor", "Penyimpanan") // filter stor

    else if(val == 'gen') load_filter_check("gen", "fltr-gen", "Jenis Kelamin") // filter gen
    else if(val == 'genp') load_filter_check("genp", "fltr-genp", "Jenis Kelamin") // filter genp
    else if(val == 'jobt') load_filter_check("jobt", "fltr-jobt", "Tipe Pekerjaan") // filter jobt
      
  }

  $(".filter-check").on('change', '.form-check-input', function (el) {
    const current = $(el.target).prop("checked")

    // jika ada 2 checkbox maka 1 single select
    if($(el.target).parent().parent().find('.form-check .form-check-input').length == 2){
      $(el.target).parent().parent().find('.form-check .form-check-input').prop("checked", false)
      if(current) $(el.target).prop("checked", true)
    }
    doSearchFilter();
  });
  
}

function load_filter_category(parent = ""){
  let data = { 
    parent: parent, 
    search: $("#autodealSearch").val(),
    location: $(".locationBox").select2('data')[0].id,
    pmin: getValueRp($("#fltr-pmin").val()),
    pmax: getValueRp($("#fltr-pmax").val()),
    ...buildParams('category')
  }

  $.ajax({
    url: BASE_URL + 'api/category/get-category-filter',
    type:'GET',
    data: data,
    dataType: "json",
    async: false,
    success:function(res, textStatus, xhr){
      // console.log(res)
      if(xhr.status == 200 && res.status){
        // console.log(res.data.other)
        // console.log(res.data.data)
        let header_content = `
          <li>
            <a class="fltr-kategori_lv1" onClick="autodealDoCategoryUrl(this,true)" data-id="">Semua Kategori</a>
            <ul class="fltr-kategori_lv2 ulLast" id="fltr-kategori_lv2"></ul>
          </li>
        `;
        if ((res.data.other ?? []).length > 0){
          let active = ""
          if(res.data.other[0]["category_slug"] == parent) {
            active = "active"
            $(".breadcrumb-delay").append(`<li class="breadcrumb-item active" aria-current="page">Kategori ${res.data.other[0]["text"]}</li>`);
          }
          header_content = `
            <li class="${active}">
              <a class="fltr-kategori_lv1" onClick="autodealDoCategoryUrl(this,true)" data-id="${res.data.other[0]["category_slug"]}">${res.data.other[0]["text"]}</a>
              <ul class="fltr-kategori_lv2 ulLast" id="fltr-kategori_lv2"></ul>
            </li>
          `
        }
        $("#fltr-kategori_lv1").append(header_content);
        

        jQuery.each(res.data.data, function(index, row){
          let active = ""
          if(row['category_slug'] == parent) {
            active = "active"
            if ((res.data.other ?? []).length > 0) $(".breadcrumb-delay").append(`<li class="breadcrumb-item" aria-current="page"><a href="/item/search/c-${res.data.other[0]["category_slug"]}/q-">Kategori ${res.data.other[0]["text"]}</a></li>`);
            $(".breadcrumb-delay").append(`<li class="breadcrumb-item active" aria-current="page">${row['text']}</li>`);
          }
          let new_content = `
            <li class="${active}">
              <a class="fltr-kategori_lv2" onClick="autodealDoCategoryUrl(this,true)" data-id="${row['category_slug']}">
                <label class="form-check-label d-flex align-items-center">
                  <span class="text-nav fw-medium">${row['text']}</span>
                  <span class="fs-xs text-body-secondary ms-auto">${row['cnt']}</span>
                </label>
              </a>
            </li>
          `;
          $("#fltr-kategori_lv2").append(new_content);
        });
      }
    }
  });
}

let last_min_price = "";
let last_max_price = "";
function load_filter_price() { 
  if(parseInt((getValueRp(urlParams.get('pmin'))))){
    last_min_price = parseInt((getValueRp(urlParams.get('pmin'))));
    $("#fltr-pmin").val(last_min_price);
  }
  if(parseInt((getValueRp(urlParams.get('pmax'))))){
    last_max_price = parseInt((getValueRp(urlParams.get('pmax'))));
    $("#fltr-pmax").val(last_max_price);
  }
  setTimeout(() => {
    $("#fltr-pmin").trigger('keyup');
    $("#fltr-pmax").trigger('keyup');
  }, 100);

  $("#fltr-pmin, #fltr-pmax").on({
    keyup: function() {
      formatCurrency($(this));
      checkPriceButton();
    },
    blur: function() { 
      formatCurrency($(this));
      checkPriceButton();
    }
  });

  function checkPriceButton(){
    let min = getValueRp($("#fltr-pmin").val())
    let max = getValueRp($("#fltr-pmax").val())
    if(min != last_min_price || max != last_max_price ) $("#fltr-price .btnOnFilter").removeAttr("disabled")
    else $("#fltr-price .btnOnFilter").attr("disabled","disabled")
  }
  
  $("#fltr-price").on('click', '.btnOnFilter', function (e) { 
    doSearchFilter()
  });

}

let last_min_year = "";
let last_max_year = "";

function init_value_year() { 
  if(parseInt((getValueRp(urlParams.get('ymin'))))){
    last_min_year = parseInt((getValueRp(urlParams.get('ymin'))));
  }
  if(parseInt((getValueRp(urlParams.get('ymax'))))){
    last_max_year = parseInt((getValueRp(urlParams.get('ymax'))));
  }
}

function load_filter_year(title) {
    let minyear = new Date().getFullYear()-20;
    let maxyear = new Date().getFullYear();
    let maxdigit = 4;
    if(title == "Umur"){
      minyear = 0
      maxyear = 100
      maxdigit = 3
    }
    const parentele = `
      <div class="range-slider" data-start-min="10" data-start-max="50" data-min="0" data-max="80" data-step="1" data-tooltip-prefix="$">
        <h4 class="fs-base labelYear">${title}</h4>
        <div id="fltr-year">
          <div class="d-block align-items-center">
            <label class="form-label me-2 mb-0 d-inline-block" for="fltr-year-min">Dari</label>
            <input class="form-control range-slider-value-min" style="max-width: 6rem;" type="text" pattern="[0-9]*" inputmode="numeric" name="year-field" id="fltr-year_min" minlength="4" maxlength="${maxdigit}" placeholder="${minyear}" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
          </div>
          <div class="d-block align-items-center mt-4">
            <label class="form-label me-2 mb-0 d-inline-block" for="fltr-year-max">Hingga</label>
            <input class="form-control range-slider-value-max" style="max-width: 6rem;" type="text" pattern="[0-9]*" inputmode="numeric" name="year-field" id="fltr-year_max" minlength="4" maxlength="${maxdigit}" placeholder="${maxyear}" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
          </div>
          <button class="btn btn-primary btnOnFilter">Terapkan</button>
        </div>
      </div>
  `;
  $("#shopCategories").append(parentele);
  
  $("#fltr-year_min").val(last_min_year);
  $("#fltr-year_max").val(last_max_year);
  setTimeout(() => {
    $("#fltr-year_min").trigger('keyup');
    $("#fltr-year_max").trigger('keyup');
  }, 100);

  $("#fltr-year_min, #fltr-year_max").on({
    keyup: function() {
      checkYearButton();
    },
    blur: function() { 
      checkYearButton();
    }
  });

  function checkYearButton(){
    let min = getValueRp($("#fltr-year_min").val())
    let max = getValueRp($("#fltr-year_max").val())
    if(min != last_min_year || max != last_max_year ) $("#fltr-year .btnOnFilter").removeAttr("disabled")
    else $("#fltr-year .btnOnFilter").attr("disabled","disabled")
  }
  
  $("#fltr-year").on('click', '.btnOnFilter', function (e) { 
    doSearchFilter()
  });

}

function load_filter_check(code, elname, title = ""){
  if(isActiveFilter(code) || ["atype", "acond", "adur"].includes(code)){
    if(title){
      const parentele = `
        <div class="accordion-item mb-0">
          <h4 class="accordion-header">
            <button class="accordion-button collapsed fs-xl fw-medium py-2" type="button" data-bs-toggle="collapse" data-bs-target="#fltr-${code}" aria-expanded="false" aria-controls="fltr-${code}">
              <span class="fs-base">${title}</span>
            </button>
          </h4>
          <div class="accordion-collapse collapse show filter-check" id="fltr-${code}" data-bs-parent="#shopCategories">
            <div class="accordion-body py-1 mb-1"></div>
          </div>
        </div>
      `;
      $("#shopCategories").append(parentele);
    }
    let data={
      location:$(".locationBox").val() ?? "",
      category:$("#c_category_id").val(),
      search:$("#autodealSearch").val(),
      pmin: getValueRp($("#fltr-pmin").val()),
      pmax: getValueRp($("#fltr-pmax").val()),
      ...buildParams(code)
    }

    $.ajax({
      url: `${BASE_URL}api/reference/get-filter-${code}`,
      type:'GET',
      data: data,
      dataType: "json",
      success:function(res, textStatus, xhr){
        let selected = (urlParams.get(code) ?? "").split(',')
        if(xhr.status == 200 && res.status){
          jQuery.each(res.data, function(index, row){
            // console.log(row)
            let new_content = `
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="${elname}_${row.id}" data-id="${row.id}">
                <label class="form-check-label d-flex align-items-center" for="${elname}_${row.id}">
                  <span class="text-nav fw-medium ${elname}">${row.text}</span>
                  <span class="fs-xs text-body-secondary ms-auto">${row.cnt}</span>
                </label>
              </div>
            `;
            $(`#${elname} .accordion-body`).append(new_content);
            if(selected.find(e=> e == row.id)) {
              $(`#${elname}_${row.id}`).attr("checked", "checked");
            }
          });
        }
      }
    });
  }
}

// function formatCurrency(input) {
//   let value = input.val().replace(/\D/g, "");
//   // if (blur === "blur") return input.val(`Rp ${value}`);
  
//   let [int, dec] = value.split(".") || ["", ""];
//   int = int.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
//   input.val(`Rp ${int}${dec ? "." + dec : ""}`);
// }

function getValueRp(val){
  return (val ?? "").replace('Rp ','').replaceAll('.','').replaceAll(',','')
}

function buildParams(val){
  let ret = [];
  if((isActiveFilter("year") && val != "year") || (isActiveFilter("yearu") && val != "yearu")){
    ret["ymin"]= getValueRp($("#fltr-year_min").val()) 
    ret["ymax"]= getValueRp($("#fltr-year_max").val())
    if(!ret["ymin"]) ret["ymin"] = last_min_year
    if(!ret["ymax"]) ret["ymax"] = last_max_year
  }

  // if((isActiveFilter("yearb") && val != "yearb")){
  //   ret["ybmin"]= getValueRp($("#fltr-year_min").val()) 
  //   ret["ybmax"]= getValueRp($("#fltr-year_max").val())
  //   if(!ret["ybmin"]) ret["ybmin"] = last_min_year
  //   if(!ret["ybmax"]) ret["ybmax"] = last_max_year
  // }

  if(val != "atype"){
    if(setVal = urlParams.get('atype') ?? "" != "")ret["atype"]= setVal
  }

  if(val != "acond"){
    if(setVal = urlParams.get('acond') ?? "" != "")ret["acond"]= setVal
  }

  if(val != "adur"){
    if(setVal = urlParams.get('adur') ?? "" != "")ret["adur"]= setVal
  }

  if(isActiveFilter("brandc") && val != "brandc" && (urlParams.get('brandc') ?? "") != "") ret["brandc"]= (urlParams.get('brandc'));
  if(isActiveFilter("modc") && val != "modc" && (urlParams.get('modc') ?? "") != "") ret["modc"]= (urlParams.get('modc'));
  if(isActiveFilter("transc") && val != "transc" && (urlParams.get('transc') ?? "") != "") ret["transc"]= (urlParams.get('transc'));
  if(isActiveFilter("fuelc") && val != "fuelc" && (urlParams.get('fuelc') ?? "") != "") ret["fuelc"]= (urlParams.get('fuelc'));
  if(isActiveFilter("engc") && val != "engc" && (urlParams.get('engc') ?? "") != "") ret["engc"]= (urlParams.get('engc'));
  if(isActiveFilter("bodyc") && val != "bodyc" && (urlParams.get('bodyc') ?? "") != "") ret["bodyc"]= (urlParams.get('bodyc'));
  if(isActiveFilter("passec") && val != "passec" && (urlParams.get('passec') ?? "") != "") ret["passec"]= (urlParams.get('passec'));
  if(isActiveFilter("colv") && val != "colv" && (urlParams.get('colv') ?? "") != "") ret["colv"]= (urlParams.get('colv'));
  if(isActiveFilter("sellv") && val != "sellv" && (urlParams.get('sellv') ?? "") != "") ret["sellv"]= (urlParams.get('sellv'));

  if(isActiveFilter("brandm") && val != "brandm" && (urlParams.get('brandm') ?? "") != "") ret["brandm"]= (urlParams.get('brandm'));
  if(isActiveFilter("modm") && val != "modm" && (urlParams.get('modm') ?? "") != "") ret["modm"]= (urlParams.get('modm'));
  if(isActiveFilter("transm") && val != "transm" && (urlParams.get('transm') ?? "") != "") ret["transm"]= (urlParams.get('transm'));
  if(isActiveFilter("engm") && val != "engm" && (urlParams.get('engm') ?? "") != "") ret["engm"]= (urlParams.get('engm'));
  if(isActiveFilter("bodym") && val != "bodym" && (urlParams.get('bodym') ?? "") != "") ret["bodym"]= (urlParams.get('bodym'));

  if(isActiveFilter("bedr") && val != "bedr" && (urlParams.get('bedr') ?? "") != "") ret["bedr"]= (urlParams.get('bedr'));
  if(isActiveFilter("bath") && val != "bath" && (urlParams.get('bath') ?? "") != "") ret["bath"]= (urlParams.get('bath'));
  if(isActiveFilter("floor") && val != "floor" && (urlParams.get('floor') ?? "") != "") ret["floor"]= (urlParams.get('floor'));
  if(isActiveFilter("cert") && val != "cert" && (urlParams.get('cert') ?? "") != "") ret["cert"]= (urlParams.get('cert'));
  if(isActiveFilter("sellp") && val != "sellp" && (urlParams.get('sellp') ?? "") != "") ret["sellp"]= (urlParams.get('sellp'));

  if(isActiveFilter("brandg") && val != "brandg" && (urlParams.get('brandg') ?? "") != "") ret["brandg"]= (urlParams.get('brandg'));
  if(isActiveFilter("os") && val != "os" && (urlParams.get('os') ?? "") != "") ret["os"]= (urlParams.get('os'));
  if(isActiveFilter("ram") && val != "ram" && (urlParams.get('ram') ?? "") != "") ret["ram"]= (urlParams.get('ram'));
  if(isActiveFilter("stor") && val != "stor" && (urlParams.get('stor') ?? "") != "") ret["stor"]= (urlParams.get('stor'));

  if(isActiveFilter("gen") && val != "gen" && (urlParams.get('gen') ?? "") != "") ret["gen"]= (urlParams.get('gen'));
  if(isActiveFilter("genp") && val != "genp" && (urlParams.get('genp') ?? "") != "") ret["genp"]= (urlParams.get('genp'));
  if(isActiveFilter("jobt") && val != "jobt" && (urlParams.get('jobt') ?? "") != "") ret["jobt"]= (urlParams.get('jobt'));
  return ret;
}

function buildUrlParams(val){
  if(isActiveFilter(val) || ["atype", "acond", "adur"].includes(val)){
    let tmp = []
    $(`#fltr-${val} .form-check-input`).each(function (i, el) {
      if(el.checked) tmp.push(encodeURIComponent($(el).attr("data-id")))
    });
    if(tmp.join(",") != "")
      filterUrl += `&${val}=${tmp.join(",")}`
  }
}