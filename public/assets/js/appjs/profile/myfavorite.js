let pagefavoriteItem = 1;

$(document).ready(function () {
  initjs();
  // $("#btn-favorite-item-next").on('click',function (e) { 
  //   // console.log('a')
  //   pagefavoriteItem ++
  //   load_favorite_item()
  // });
});

function initjs() {
  // console.log("init");
  pagefavoriteItem = 1;
  $("#favorite-item").html('');
  load_favorite_item();
}

function load_favorite_item(){
  $.ajax({
    url: BASE_URL + 'api/item/get-my-favorite',
    type:'GET',
    data: {
      page: pagefavoriteItem,
    },
    dataType: "json",
    beforeSend: function(){ 
      // $("#btn-favorite-item-next").html(`Selanjutnya...`);
      // $("#btn-favorite-item-next").attr("disabled", true);
      $("#loading-favorite-item").show();
    },
    complete: function(){
      // $("#btn-favorite-item-next").html(`Selanjutnya`);
      // $("#btn-favorite-item-next").removeAttr("disabled");
      $("#loading-favorite-item").hide();
    },
    success:function(res, textStatus, xhr){
      if(xhr.status == 200 && res.status){
        //set total iklan
        let total_ads = parseFloat(res.data.pagination.total_records).toLocaleString('id-ID', { currency: 'IDR' })
        $('.total_item').html(total_ads);

        jQuery.each(res.data.data, function(index, row){
        // res.data.data.forEach(row => {
        
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

          condition_label = `<span>${row['category_name']}</span>`;
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
            <div class="col pb-2 pb-sm-3">
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
          $("#favorite-item").append(new_item);
          new_item.fadeIn(500);
        });
      }
    }
  });
}

