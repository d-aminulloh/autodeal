const urlParams = new URLSearchParams(window.location.search);

// Page loading scripts
(function () {
  window.onload = function () {
    const preloader = document.querySelector('.page-loading')
    preloader.classList.remove('active')
    setTimeout(function () {
      preloader.remove()
    }, 1500)
  }
})()

// location
$(document).ready(function() {
  // init state
  if(urlParams.get('r') === 'login') $('#modalLogin').modal('show');
  loadLocation();
  load_notification();


  $('#autodealSearch').keypress(function (e) {
    if(e.which == 13) {
      autodealDoSearch()
      return false
    }
  });   
   
  // if(urlParams.get('search')){
  //   $("#autodealSearch").val(decodeURIComponent(urlParams.get('search')));
  // }
  if(urlParams.get('sort')){
    $("#autodealSortBy").val(decodeURIComponent(urlParams.get('sort')));
  }
  
  $('.locationBox').select2({
      ajax: {
          url: BASE_URL + "api/location/get-location",
          dataType: "json",
          delay: 500,
          data: function (params) {
              return {
                  query: params.term,
              };
          },
          processResults: function (data) {
              data.data.unshift({id:'~', text:'Lokasi saat ini', longitude:'~', longitude:'~'})
              return {
                  results: data.data
              };
          },
          // cache: true
      },
      placeholder: "Start typing",
      // minimumInputLength: 3,
  });

  //lokasi saat ini
  $('.locationBox').on('select2:select', function (e) {
    var data = e.params.data;
    // lokasi saat ini
    if(data.id == '~'){
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
          function(position){
            $.ajax({
              url: BASE_URL + 'api/location/get-location-by-coordinate',
              type:'GET',
              data: {latitude: position.coords.latitude, longitude: position.coords.longitude},
              beforeSend: function(){ 
                $("#top-location-icon").removeClass();
                $("#top-location-icon").addClass(`spinner-border spinner-border-sm text-primary`);
              },
              complete: function(){
                $("#top-location-icon").removeClass();
                $("#top-location-icon").addClass(`bi bi-map`);
              },
              dataType: "json",
              success:function(res, textStatus, xhr){
                if(xhr.status == 200 && res.status){
                  // data.push({id:'~', text:'Lokasi saat ini', longitude:'~', longitude:'~'});
                  jQuery.each(res.data, function(index, row){
                    var newOption = new Option(row.text, row.id, true, true);
                    // setTimeout(() => {
                        $('.locationBox').append(newOption).trigger('change');
                        // initjs()
                    // }, 300);
                    localStorage.setItem('location',btoa(JSON.stringify(row)))
                    localStorage.setItem('mylocation',btoa(JSON.stringify(row)))
                    $('.autodealLocationText').html(row.text)
                    doSearchFilter()
                  });
                }
              }
            });
          },
          function () { 
            alert('Location permission denied.')
            // $('.locationBox').val('').trigger('change');
            // $('.autodealLocationText').html('')
            loadLocation();
            initjs()
          }
        )
      } else {
        // I believe it may also mean geolocation isn't supported
        alert('Location permission denied.') 
        // $('.locationBox').val('').trigger('change');
        // $('.autodealLocationText').html('')
        loadLocation();
        initjs()
      }
    } else {
      localStorage.setItem('location', btoa(JSON.stringify($(".locationBox").select2('data')[0])))
      $('.autodealLocationText').html($(".locationBox").select2('data')[0].text)
      doSearchFilter()
      // initjs()
    }
  });

  $("#autodealSortBy").on('change', function (e) { 
    // autodealDoSearch();
    initjs();
  });

  autodealGetCategory();

  $(document).on("click", ".favButton", function (e) { 
    const el = this;
    const state = $(el).attr("data-fav");
    const item_id = $(el).attr("data-id");
    const loginCheck = $(el).attr("data-en");
    if(loginCheck == 1){
      if(state == '0'){
        // let new_tocken = refreshTocken();
        // if(new_tocken !== "") {
          $.ajax({
            url: BASE_URL + 'api/item/add-my-favorite',
            type:'POST',
            // headers: {'X-CSRF-TOKEN': new_tocken, '_method': 'patch'},
            data: {
              ads_id: item_id,
              _token: $('meta[name="csrf_token"]').attr('content'),
            },
            dataType: "json",
            beforeSend: function(){ 
              $(".favButton").attr("disabled", "disabled");
            },
            complete: function(){
              $(".favButton").removeAttr("disabled");
            },
            success:function(res, textStatus, xhr){
              if(xhr.status == 200 && res.status){
                $(el).find('i').removeClass('bi-heart');
                $(el).find('i').addClass('bi-heart-fill');
                $(el).attr("data-fav","1")
                toastSuccess("Iklan disimpan.")
              } else {
                toastError(res.message)
              }
            },
            error: function (xhr, ajaxOptions, thrownError) {
              $(".btnLogin").html(`Login`);
              $(".favButton").removeAttr("disabled");
              toastError('Gagal menambahkan ke favorit.')
            }
          });
        // }
      } else {
        // let new_tocken = refreshTocken();
        // if(new_tocken !== "") {
          $.ajax({
            url: BASE_URL + 'api/item/remove-my-favorite',
            type:'POST',
            // headers: {'X-CSRF-TOKEN': new_tocken, '_method': 'patch'},
            data: {
              ads_id: item_id,
              _token: $('meta[name="csrf_token"]').attr('content'),
            },
            dataType: "json",
            beforeSend: function(){ 
              $(".favButton").attr("disabled", "disabled");
            },
            complete: function(){
              $(".favButton").removeAttr("disabled");
            },
            success:function(res, textStatus, xhr){
              if(xhr.status == 200 && res.status){
                $(el).find('i').removeClass('bi-heart-fill');
                $(el).find('i').addClass('bi-heart');
                $(el).attr("data-fav","0")
                toastSuccess("Iklan dihapus dari favorit anda.")
              } else {
                toastError(res.message)
              }
            },
            error: function (xhr, ajaxOptions, thrownError) {
              $(".btnLogin").html(`Login`);
              $(".favButton").removeAttr("disabled");
              toastr["error"]("Gagal menghapus dari favorit.");
            }
          });
        // }
      }
    } else {
      openLoginModal()
    }
  });
});


const menuBtn = document.querySelector('.menu-btn');
const navMenu = document.querySelector('.nav-menu');
const body = document.querySelector('body');

if(menuBtn){
  menuBtn.addEventListener('click', () => {
    menuBtn.classList.toggle('open');
    navMenu.classList.toggle('open');
    body.classList.toggle('menu-open');
  });
}

document.getElementById('formAutodealLogin').onsubmit = function() {

// function autodealDoLogin(e){
  if(!$('#formAutodealLogin')[0].checkValidity()) return false
  var data = {
    email: $("#login_email").val(),
    password: $("#login_password").val(),
    remember: $("#login_remember").is(':checked'),
    _token: $('meta[name="csrf_token"]').attr('content'),
  }

  $(".btnLogin").html(`Login...`);
  $(".btnLogin").attr("disabled", true);

  // let new_tocken = refreshTocken();

  // if(new_tocken !== "") {
    $.ajax({
      url: BASE_URL + 'api/auth/login',
      type:'POST',
      // headers: {'X-CSRF-TOKEN': new_tocken, '_method': 'patch'},
      data: data,
      dataType: "json",
      beforeSend: function(){ 
      },
      complete: function(){
      },
      success:function(res, textStatus, xhr){
        if(xhr.status == 200 && res.status){
          // console.log(data.token) // not used
          // localStorage.setItem('token',btoa(res.data.token)) // not used
          // toastr.success(res.message)
          // setTimeout(() => {
            window.location.href = BASE_URL;
          // }, 2500);
        } else {
          toastError(res.message)

          $(".btnLogin").html(`Login`);
          $(".btnLogin").removeAttr("disabled");
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        $(".btnLogin").html(`Login`);
        $(".btnLogin").removeAttr("disabled");
        toastr["error"]("Login gagal.");
      }
    });
  // }
  
  return false
// }
// return isValidForm();
};

document.getElementById('formAutodealRegister').onsubmit = function() {
  if(!$('#formAutodealRegister')[0].checkValidity()) return false
  var data = {
    name: $("#register_name").val(),
    email: $("#register_email").val(),
    password: $("#register_password").val(),
    password_confirm: $("#register_password_confirm").val(),
    _token: $('meta[name="csrf_token"]').attr('content'),
  }

  if(data.password !== data.password_confirm){
    toastError("Password dan konfirmasi password tidak sama.")
    return false
  }

  $(".btnRegisterin").html(`Daftar...`);
  $(".btnRegisterin").attr("disabled", true);

    $.ajax({
      url: BASE_URL + 'api/auth/register',
      type:'POST',
      // headers: {'X-CSRF-TOKEN': new_tocken, '_method': 'patch'},
      data: data,
      dataType: "json",
      beforeSend: function(){ 
      },
      complete: function(){
      },
      success:function(res, textStatus, xhr){
        if(xhr.status == 200 && res.status){
          toastSuccess(res.message)
          setTimeout(() => {
            window.location.href = BASE_URL +"?r=login";
          }, 1500);
        } else {
          toastError(res.message)

          $(".btnRegisterin").html(`Daftar`);
          $(".btnRegisterin").removeAttr("disabled");
        }
      },
      error: function (xhr, ajaxOptions, thrownError) {
        $(".btnRegisterin").html(`Daftar`);
        $(".btnRegisterin").removeAttr("disabled");
        toastr["error"]("Daftar gagal.");
      }
    });
  
  return false
};
  

function autodealDoLogout(){
  // localStorage.removeItem('token')
  window.location.href = BASE_URL + 'logout';
}

function autodealDoSearch(){
  // localStorage.setItem('search',btoa($("#autodealSearch").val()))
  const search = encodeURIComponent($("#autodealSearch").val().trim());
  const sortby = encodeURIComponent($("#autodealSortBy").val() ?? "");
  
  $('.autodealSearchText').html((search ?? "") == "" ? "":search+' -')

  // let current_url = window.location.pathname.split('/')
  const catUrl = window.location.pathname.split('/')[3] ?? ""
  let url = `${BASE_URL}item/search/q-${search}?sort=${sortby}`;
  // cek apakah ada di page category
  // if(catUrl.startsWith('c-')) url = `${BASE_URL}item/search/${catUrl}/q-${search}?sort=${sortby}`;

  window.location.href = url
}

function autodealDoCategoryUrl(e, with_search = false){
  let catUrl= $(e).attr('data-id')
  let search = "";
  if(with_search)
    search = encodeURIComponent($("#autodealSearch").val().trim());
  
  if(catUrl != "") catUrl = `c-${catUrl}/`
  window.location.href = `${BASE_URL}item/search/${catUrl}q-${search}`
}

function autodealGetCategory(parent = ""){
  $.ajax({
    url: BASE_URL + 'api/category/get-category',
    type:'GET',
    data: { parent: parent },
    dataType: "json",
    async: false,
    beforeSend: function(){ 
      $("#loading-new-item").show();
    },
    complete: function(){
      $("#loading-new-item").hide();
    },
    success:function(res, textStatus, xhr){
      if(xhr.status == 200 && res.status){
        $("#autodealCategoryNav").html('');
        jQuery.each(res.data, function(index, row){
          let new_content = `
            <div class="swiper-slide w-auto">
              <a class="d-block card-hover zoom-effect" onClick="autodealDoCategoryUrl(this)" data-id="${row['category_slug']}">
                <img src="${row['category_icon']}" class="iconKategori-menu"/>
                ${row['text']}
              </a>
            </div>
          `;
          $("#autodealCategoryNav").append(new_content);

          let new_content2 = `<li><a onClick="autodealDoCategoryUrl(this)" data-id="${row['category_slug']}"><img src="${row['category_icon']}"/>${row['text']}</a></li>`;
          $("#autodealCategoryMNav").append(new_content2);
          
        });
      }
    }
  });
}


/**
 * Fungsi untuk mengecek status tanggal input
 * @param {string} inputDateString - Tanggal input dalam format 'YYYY-MM-DD'
 * @returns {string} - Hasil pengecekan ("Hari ini", "Kemarin", "Tahun yang sama", "Lainnya")
 */
function myFormatDate(inputDateString) {
  try {
    let inputDate = new Date(inputDateString);
    let today = new Date();
    let yesterday = new Date();
    yesterday.setDate(today.getDate() - 1);

  // let day = inputDate.getDate().toString().padStart(2, '0');
  // let month = (inputDate.getMonth() + 1).toString().padStart(2, '0'); // bulan mulai dari 0
    let day = inputDate.getDate().toString();
    let month = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"][inputDate.getMonth()]
    let year = inputDate.getFullYear();
  
    function isSameDate(date1, date2) {
        return date1.getDate() === date2.getDate() &&
               date1.getMonth() === date2.getMonth() &&
               date1.getFullYear() === date2.getFullYear();
    }
  
    function isSameYear(date1, date2) {
        return date1.getFullYear() === date2.getFullYear();
    }
    
    if (isSameDate(inputDate, today)) {
      return "Hari ini";
    } else if (isSameDate(inputDate, yesterday)) {
      return "Kemarin";
    } else if (isSameYear(inputDate, today)) {
      return `${day} ${month}`;
    } else {
      // return `${day} ${month} ${year}`;
      return `${day} ${month} ${year}`;
    }
  } catch (error) {
    console.log(error)
    return inputDateString;
  }

}

function loadLocation(){
  if(!localStorage.getItem('location')){
    const defloc = 'eyJzZWxlY3RlZCI6ZmFsc2UsImRpc2FibGVkIjpmYWxzZSwidGV4dCI6IkluZG9uZXNpYSIsImlkIjoiMSIsImxvbmdpdHVkZSI6IjExMy45MjEzIiwibGF0aXR1ZGUiOiItMC43ODkzIiwiX3Jlc3VsdElkIjoic2VsZWN0Mi1zdGF0ZS04Ny1yZXN1bHQtaHYzNi0xIiwiZWxlbWVudCI6e319'
    localStorage.setItem('location', defloc)
    const row = JSON.parse(atob(defloc));
    var newOption = new Option(row.text, row.id, true, true);
    $('.locationBox').append(newOption).trigger('change');
    $('.autodealLocationText').html(row.text)
  }
  if(localStorage.getItem('location')){
    const row = JSON.parse(atob(localStorage.getItem('location')));
    var newOption = new Option(row.text, row.id, true, true);
    $('.locationBox').append(newOption).trigger('change');
    $('.autodealLocationText').html(row.text)
  }
}

function openLoginModal(){
  $('#modalLogin').modal('show');
}

// function refreshTocken(){
//   let new_tocken = ""
//   $.ajax({
//     url: BASE_URL + 'refresh-csrf',
//     type:'GET',
//     data: [],
//     dataType: "json",
//     async: false,
//     success: function(res, textStatus, xhr){
//       if(xhr.status == 200) new_tocken = res
//     },
//     error: function (xhr, ajaxOptions, thrownError) {
//       $(".btnLogin").html(`Login`);
//       $(".btnLogin").removeAttr("disabled");
//       toastr["error"]("Login gagal.");
//     }
//   });
//   return new_tocken
// }

function formatCurrency(input, rp = true, year = false) {
  let value = input.val().replace(/\D/g, "");
  // if (blur === "blur") return input.val(`Rp ${value}`);
  
  let [int, dec] = value.split(".") || ["", ""];
  int = int.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

  if (value != ""){
    if(year){
// console.log('year', int)
      input.val(`${value}`);
    }
    else if(rp)
      input.val(`Rp ${int}${dec ? "." + dec : ""}`);
    else
      input.val(`${int}${dec ? "." + dec : ""}`);
  }
  else input.val("");
  input.attr('data-value', value);
}

function toastError(message){
  Swal.fire({
    toast: true,
    position: "top-end",
    icon: "error",
    title: message,
    showConfirmButton: false,
    timer: 4000,
    // imageSize: '100x100'
  });
}

function toastSuccess(message, url = ""){
  Swal.fire({
    toast: true,
    position: "top-end",
    icon: "success",
    title: message,
    showConfirmButton: false,
    timer: 4000,
  });
  
  if(url){
    setTimeout(() => {
      window.location.href = url;
    }, 2000);
  }
}

function toastYesNo(title, message){
  Swal.fire({
    title: title,
    text: message,
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!"
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Deleted!",
        text: "Your file has been deleted.",
        icon: "success"
      });
    }
  });
}

function load_notification(){
  $.ajax({
    url: BASE_URL + 'api/reference/get-notification',
    type:'GET',
    data: {},
    dataType: "json",
    beforeSend: function(){ 
      $("#notif-section").html('');
    },
    // complete: function(){
    //   $("#loading-new-item").hide();
    // },
    success:function(res, textStatus, xhr){
      if(xhr.status == 200 && res.status){
        if(res.data.data.length > 0){
          let last_date = "";
          jQuery.each(res.data.data, function(index, row){
            let new_content = `
              <div class="notif-card ${row['type']} ${row['is_read'] == '0' ? 'new' : ''}">
                <img src="${row['image_cover']}"/>
                <ul>
                  <li>${row['title']}</li>
                  <li>${row['title_item']}</li>
                  <li>${row['created_date']}</li>
                </ul>
              </div>
            `;
  
            let date_check = myFormatDate(row['created_date'])
            // console.log(`${last_date} != ${date_check}`)
            if(last_date != date_check) {
              $("#notif-section").append(`<div class="notif-date">${date_check}</div>`);
              last_date = date_check;
            }
  
            // var new_item = $(new_content).hide();
            $("#notif-section").append(new_content);
            // new_item.fadeIn(500);
          });
        } else {
          $("#notif-section").append('<label class="title-no-notif">Tidak ada notifikasi</label>');
        }

      }
    }
  });
}