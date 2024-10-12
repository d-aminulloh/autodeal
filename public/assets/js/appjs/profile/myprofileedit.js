$(document).ready(function () {
  initjs()
  $('#province_id').change(function(){
    $("#city_id").empty();
    $("#district_id").empty();
    get_address('city', $("#province_id").val(), true);
    get_address('district', $("#city_id").val(), true);
  });
  $('#city_id').change(function(){
    $("#district_id").empty();
    get_address('district', $("#city_id").val(), true);
  });
})

function initjs() {
  get_address();
  get_address('city', $("#province_id").val());
  get_address('district', $("#city_id").val());
}

function get_address(type = "", parent = "", with_placeholder=false){
  let el = "#province_id" 
  let typeval = 1 
  let parentval = parent
  let with_placeholderval = with_placeholder;
  if(type == "city"){
    el = "#city_id"
    typeval = 2
    if(with_placeholderval) $(el).append($('<option></option>').val("").html("Pilih Kota"))
    if(!parent) return
  } else if(type == "district"){
    el = "#district_id"
    typeval = 3
    if(with_placeholderval) $(el).append($('<option></option>').val("").html("Pilih Kecamatan"))
    if(!parent) return
  }

  $.ajax({
    url: BASE_URL + 'api/location/get-location-reference',
    type:'GET',
    data: {
      type: typeval,
      parent: parentval
    },
    dataType: "json",
    beforeSend: function(){ 
      // $("#loading-favorite-item").show();
    },
    complete: function(){
      // $("#loading-favorite-item").hide();
    },
    success:function(res, textStatus, xhr){
      if(xhr.status == 200 && res.status){
        $.each(res.data, function (i, r) { 
          $(el).append($('<option></option>').val(r.id).html(r.text))
        });
      }
    }
  });
}

