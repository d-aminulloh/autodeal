let swiperElement;
$(document).ready(function () {
  initjs();
});

function initjs() {
  // console.log("init");
  pageOtherItem = 1;
  $("#other-item").html('');
  // load_other_item();

  load_category()
  $('#category').change(function () { 
    load_category($(this).val())
  });

  $('#category_id').change(function () { 
    cid = $(this).val();
    $("#category_content").load(`${BASE_URL}api/item/create/${cid}`, function (response, status, request) {
      this; // dom element
    });
    if(cid == 1101 || cid == 1102) {
      $(".f_ads_type_id").hide();
      $("#ads_type_id").removeAttr('required');
      if ($("#condition_id").length) $("#condition_id").removeAttr('required');
      if ($("#duration_id").length) $("#duration_id").removeAttr('required');
      $(".f_price").hide(); $("#price").removeAttr('required');
      if(!$("#price").val())$("#price").val(0) // fix validation
    } else {
      $(".f_ads_type_id").show();
      $("#ads_type_id").attr('required','required');
      if ($("#condition_id").length) $("#condition_id").attr('required','required');
      if ($("#duration_id").length) $("#duration_id").attr('required','required');
      $(".f_price").show(); $("#price").attr('required','required');
    }
  });

  load_dropdown('#ads_type_id', 'Tipe Iklan', '/reference/get-ads-type')
  load_dropdown('#duration_id', 'Durasi', '/reference/get-duration')
  load_dropdown('#condition_id', 'Kondisi', '/reference/get-condition')
  $('#ads_type_id').change(function () { 
    if($(this).val() == '2') {
      $("#condition_id").removeAttr('required');
      $("#f_condition_id").hide()
      $("#duration_id").attr('required','required');
      $("#f_duration_id").show()
    } else {
      $("#duration_id").removeAttr('required');
      $("#f_duration_id").hide()
      $("#condition_id").attr('required','required');
      $("#f_condition_id").show()
    }
    $("#condition_id").val('');
    $("#duration_id").val('');
  });

  // $("#price").on({
  //   keyup: function() {
  //     formatCurrency($(this));
  //   },
  //   blur: function() { 
  //     formatCurrency($(this));
  //   }
  // });

  $("#form_create")
    .on("keyup", ".currency-input", function (e) {
      formatCurrency($(this));
    })
    .on("blur", ".currency-input", function (e) {
      formatCurrency($(this));
    })
    .on("keyup", ".number-input", function (e) {
      formatCurrency($(this), false);
    })
    .on("blur", ".number-input", function (e) {
      formatCurrency($(this), false);
    })
    .on("keyup", ".year-input", function (e) {
      formatCurrency($(this), false, true);
    })
    .on("blur", ".year-input", function (e) {
      formatCurrency($(this), false, true);
    })

  load_dropdown('#province_id', 'Provinsi', '/location/get-location-reference')

  $('#province_id').change(function () { 
    load_dropdown('#city_id', 'Kabupaten / Kota', '/location/get-location-reference', { parent: $(this).val(), type: 2 })
    $("#address_id").empty()
    $("#address_id").append('<option value="" selected disabled>Kecamatan</option>')
    $("#address_id").append('<option value="" disabled>-- pilih Kabupaten / Kota dahulu --</option>')
  });

  $('#city_id').change(function () { 
    load_dropdown('#address_id', 'Kecamatan', '/location/get-location-reference', { parent: $(this).val(), type: 3 })
  });

  // form validate
	$('#form_create').validate({
    errorElement: 'span',
    invalidHandler: function(form, validator) {
      if (!validator.numberOfInvalids()) return;
      $('html, body').animate({
          scrollTop: $(validator.errorList[0].element).offset().top - 70
      }, 700);
      $(validator.errorList[0].element).focus()
    },
    errorPlacement: function (error, element) {
      // error.addClass('invalid-feedback');
      // element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      // if ($(element).is(':radio')) {
      //   $(element).closest('.form-radio').addClass('is-invalid');
      // } else {
        $(element).addClass('is-invalid');
      // }
    },
    unhighlight: function (element, errorClass, validClass) {
      // if ($(element).is(':radio')) {
      //   $(element).closest('.form-radio').removeClass('is-invalid');
      // } else {
        $(element).removeClass('is-invalid');
      // }
    }
	});

  // form leave
  $('#form_create').data('serialize',$('#form_create').serialize());
  let form_submited = false;
  $(window).bind('beforeunload', function(e){
      if($('#form_create').serialize()!=$('#form_create').data('serialize') && !form_submited)return true;
      else e=null; // i.e; if form state change show warning box, else don't show it.
  });

	$('#btn_submit').click(function (e) { 
		if ($('#form_create').valid()) {
      let data = $('#form_create').serializeArray();
      for (let i = 0; i < data.length; i++) {
        const item = data[i];
        if ($(`input[name="${item.name}"]`).hasClass('currency-input') || $(`input[name="${item.name}"]`).hasClass('number-input')) {
          item.value = item.value.replace('Rp ', '').replaceAll(',','');
        }
      }

      $('.image-preview-item img').each(function(){
        if($(this).attr('src') != '/assets/icons/add-img.svg')
          data.push({name: 'imgUpload[]', value:$(this).attr('src')});
      });
 
      let btn_submit = $("#btn_submit").html();
      $.ajax({
        url: BASE_URL + 'api/item/create',
        type:'POST',
        data: data,
        dataType: "json",
        beforeSend: function() {
          $('#btn_submit').html(btn_submit+'... <i class="fa fa-spinner fa-pulse fa-fw"></i>');
          $('#btn_submit').attr('disabled', 'disabled');
        },
        success:function(res, textStatus, xhr){
          if(xhr.status == 200 && res.status){
            form_submited = true
            toastSuccess(res.message, BASE_URL + 'item/i-' + res.data.id)
          } else {

            let errorMessage = '';
            if(res.status == false) {
              for(const key in res.data) {
                if(res.data.hasOwnProperty(key)) {
                  const errors = res.data[key];
                  errors.forEach((error) => {
                    errorMessage += error + '\n';
                  });
                }
             }
            }

            if(errorMessage) toastError(errorMessage)
            else toastError(res.message)
            
            $('#btn_submit').html(btn_submit);
            $('#btn_submit').removeAttr('disabled');
          }
        },
        error:function(res, textStatus, xhr){
          toastError('Gagal menyimpan iklan.')
          console.log(res)
          $('#btn_submit').html(btn_submit);
          $('#btn_submit').removeAttr('disabled');
        }

      });
    }
  });


  // $(function() {
  //   $("#imagePreviewContainer").sortable({
  //       itemSelector: '.image-preview-item',
  //       containerSelector: '#imagePreviewContainer',
  //   });
  // });

  // // $('div.list-group').sortable({
  // //   itemSelector: '.list-group-item',
  // //   containerSelector: '.list-group'
  // // });
  // $('#tes1').sortable();
  // $('#tes2').sortable({
  //   itemSelector: '.list-group-item',
  //   containerSelector: '#tes2'
  // });

}


function load_category( parent =''){
  if(parent) {
    $('#category_id').empty();
    $('#category_id').append($('<option disabled selected></option>').val('').html('Sub-kategori'));
  }
  else {
    $('#category').empty();
    $('#category').append($('<option disabled selected></option>').val('').html('Kategori'));
  }
  $.ajax({
    url: BASE_URL + 'api/category/get-category',
    type:'GET',
    data: { parent: parent },
    dataType: "json",
    success:function(res, textStatus, xhr){
      // console.log(res)
      if(xhr.status == 200 && res.status){
        jQuery.each(res.data, function(index, row){
          if(parent) $('#category_id').append($('<option></option>').val(row['id']).html(row['text']));
          else $('#category').append($('<option></option>').val(row['id']).html(row['text']));
        });
      }
    },
  });
}

function load_dropdown(el, placeholder, url, data = {}) {
  $(el).empty();
  $(el).append($('<option disabled selected></option>').val('').html(placeholder));
  $.ajax({
    url: BASE_URL + 'api' + url,
    type:'GET',
    data: data,
    dataType: "json",
    success:function(res, textStatus, xhr){
      // console.log(res)
      if(xhr.status == 200 && res.status){
        jQuery.each(res.data, function(index, row){
          $(el).append($('<option></option>').val(row['id']).html(row['text']));
        });
      }
    }
  });
}

document.addEventListener('DOMContentLoaded', () => {
  const imageUploadInput = document.getElementById('imageUpload');
  const imagePreviewContainer = document.getElementById('imagePreviewContainer');
  const uploadLabel = document.getElementById('uploadLabel');
  const maxImages = 15;

  imageUploadInput.addEventListener('change', handleImageUpload);

  async function handleImageUpload(event) {
    const files = event.target.files;
    const currentImages = imagePreviewContainer.getElementsByClassName('image-preview-item').length - 1; // exclude the upload button
    const newImagesCount = Math.min(files.length, maxImages - currentImages);

    if (newImagesCount <= 0) {
      alert(`Anda hanya dapat mengunggah maksimal ${maxImages} foto.`);
      return;
    }

    for (let i = 0; i < newImagesCount; i++) {
      const file = files[i];
      const formData = new FormData();
      formData.append('file', file);
      
      try {
        const response = await fetch('/api/item/upload', {
          method: 'POST',
          body: formData,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
          }
        });

        if (!response.ok) {
          toastError('Gagal mengunggah gambar.')
          return false
        }

        const result = await response.json();

        if (result.status == false) {
          const data = result.data || {};
          const fileErrors = data.file || [];
          let errorMessage = '';
          fileErrors.forEach((error) => {
            errorMessage += error + '\n';
          });
          toastError(errorMessage)
          return false
        }

        // Add the image preview
        const imgElement = document.createElement('div');
        imgElement.classList.add('image-preview-item');
        imgElement.innerHTML = `
          <label class="title-cover">COVER</label>
          <img src="${result.data.fileUrl}" alt="Image Preview">
          <button class="remove-btn" aria-label="Remove Image">×</button>
        `;
        imagePreviewContainer.insertBefore(imgElement, uploadLabel);
        imgElement.querySelector('.remove-btn').addEventListener('click', () => removeImage(imgElement));
        checkImageCount();

      } catch (error) {
        console.error('Error uploading file:', error);
      }
    }
  }

  function removeImage(imageItem) {
    imageItem.remove();
    checkImageCount();
  }

  function checkImageCount() {
    const currentImages = imagePreviewContainer.getElementsByClassName('image-preview-item').length - 1; // exclude the upload button
    uploadLabel.style.display = currentImages >= maxImages ? 'none' : 'inline-block';
    if(currentImages > 0) {
     $("#uploadLabeltitleCover").hide(); 
    } else {
      $("#uploadLabeltitleCover").show(); 
    }
  }
});
