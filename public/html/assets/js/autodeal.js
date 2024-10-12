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
    $('.locationBox').select2();

    // slider iklan terbaru
    var swiper = new Swiper(".swiperTerbaru", {
        slidesPerView: 2,
        spaceBetween: 15,
        autoplay: {
        delay: 2500,
        disableOnInteraction: false,
        },
        pagination: {
        el: ".swiper-pagination",
        clickable: true,
        dynamicBullets: true,
        },
        breakpoints: {
            // when window width is <= 640px
            640: {
                slidesPerView: 2,
                spaceBetween: 15
            },
            // when window width is <= 768px
            768: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            // when window width is <= 1024px
            1024: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            // when window width is > 1024px
            1025: {
                slidesPerView: 4,
                spaceBetween: 30
            }
        }
    });

    // Select the slider element
    var swiperElement = document.querySelector('.swiperTerbaru');

    // Stop autoplay on mouseenter
    swiperElement.addEventListener('mouseenter', function() {
        swiper.autoplay.stop();
    });

    // Start autoplay on mouseleave
    swiperElement.addEventListener('mouseleave', function() {
        swiper.autoplay.start();
    });
});



const menuBtn = document.querySelector('.menu-btn');
const navMenu = document.querySelector('.nav-menu');
const body = document.querySelector('body');

menuBtn.addEventListener('click', () => {
    menuBtn.classList.toggle('open');
    navMenu.classList.toggle('open');
    body.classList.toggle('menu-open');
});

// Jquery Dependency

$("input[data-type='currency']").on({
    keyup: function() {
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
});


function formatCurrency(input, blur) {
  let value = input.val().replace(/\D/g, "");
  if (blur === "blur") return input.val(`Rp ${value}`);
  
  let [int, dec] = value.split(".") || ["", ""];
  int = int.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  input.val(`Rp ${int}${dec ? "." + dec : ""}`);
}
// function formatNumber(n) {
//   // format number 1000000 to 1,234,567
//   return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
// }


// function formatCurrency(input, blur) {
//   // appends $ to value, validates decimal side
//   // and puts cursor back in right position.
  
//   // get input value
//   var input_val = input.val();
  
//   // don't validate empty input
//   if (input_val === "") { return; }
  
//   // original length
//   var original_len = input_val.length;

//   // initial caret position 
//   var caret_pos = input.prop("selectionStart");
    
//   // check for decimal
//   if (input_val.indexOf(".") >= 0) {

//     // get position of first decimal
//     // this prevents multiple decimals from
//     // being entered
//     var decimal_pos = input_val.indexOf(".");

//     // split number by decimal point
//     var left_side = input_val.substring(0, decimal_pos);
//     var right_side = input_val.substring(decimal_pos);

//     // add commas to left side of number
//     left_side = formatNumber(left_side);

//     // validate right side
//     right_side = formatNumber(right_side);
    
//     // On blur remove decimal part
//     if (blur === "blur") {
//       right_side = "";
//     }
    
//     // join number by .
//     input_val = "Rp " + left_side;

//   } else {
//     // no decimal entered
//     // add commas to number
//     // remove all non-digits
//     input_val = formatNumber(input_val);
//     input_val = "Rp " + input_val;
//   }
  
//   // send updated string to input
//   input.val(input_val);

//   // put caret back in the right position
//   var updated_len = input_val.length;
//   caret_pos = updated_len - original_len + caret_pos;
//   input[0].setSelectionRange(caret_pos, caret_pos);
// }

// Toggle button Favourite
document.addEventListener('DOMContentLoaded', function() {
  const favoriteButtons = document.querySelectorAll('.favButton');

  favoriteButtons.forEach(button => {
      button.addEventListener('click', function() {
          const heartIcon = button.querySelector('i.bi');

          if (heartIcon.classList.contains('bi-heart')) {
              heartIcon.classList.remove('bi-heart');
              heartIcon.classList.add('bi-heart-fill');
          } else {
              heartIcon.classList.remove('bi-heart-fill');
              heartIcon.classList.add('bi-heart');
          }
      });
  });
});

// Toggle show hide pusat bantuan
document.querySelectorAll('.pusBan_link').forEach(function(link) {
  link.addEventListener('click', function(event) {
      event.preventDefault();
      var targetId = this.getAttribute('href').substring(1);
      document.querySelectorAll('.pusBan_detail').forEach(function(collapse) {
          if (collapse.id === targetId) {
              collapse.classList.add('show');
          } else {
              collapse.classList.remove('show');
          }
      });
      document.querySelectorAll('.pusBan_link').forEach(function(link) {
          link.classList.remove('active');
      });
      this.classList.add('active');
  });
});

// input nomor telepon
function formatPhoneNumber(input) {
  var input_val = input.val();

  // Remove all non-digits except space
  input_val = input_val.replace(/[^\d\s]/g, "");

  // Ensure it starts with +62 followed by a space
  if (!input_val.startsWith("62 ")) {
      input_val = "62 " + input_val.replace(/^62\s?/, "");
  }

  // Limit to a maximum of 13 digits after +62 and a space
  if (input_val.length > 16) {  // 3 characters for "62 ", plus 13 digits
      input_val = input_val.substring(0, 16);
  }

  // Format the phone number
  input_val = "+" + input_val;

  // Set the formatted value back to the input
  input.val(input_val);
}

$(document).ready(function() {
  // Event listener for input event to allow only digits and limit length
  $("input[data-type='phone']").on("input", function() {
      var input = $(this);
      var input_val = input.val();

      // Remove all non-digits except space
      input_val = input_val.replace(/[^\d\s]/g, "");

      // Ensure it starts with +62 followed by a space
      if (!input_val.startsWith("+62 ")) {
          input_val = "+62 " + input_val.replace(/^\+?62\s?/, "");
      }

      // Limit to a maximum of 13 digits after +62 and a space
      if (input_val.length > 16) {  // 3 characters for "+62 ", plus 13 digits
          input_val = input_val.substring(0, 16);
      }

      input.val(input_val);
  });

  // Event listener for blur event to format phone number
  $("input[data-type='phone']").on("blur", function() {
      formatPhoneNumber($(this));
  });
});

// input email
$(document).ready(function() {
  // Event listener untuk input event pada field email
  $("input[name='email']").on("input", function() {
      var input = $(this);
      var email = input.val();
      var isValid = isValidEmail(email);

      if (!isValid) {
          input.css("border-color", "red");
      } else {
          input.css("border-color", ""); // Reset border color
      }
  });

  // Fungsi untuk validasi email menggunakan regular expression
  function isValidEmail(email) {
      // Pola regular expression untuk validasi email
      var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailPattern.test(email);
  }
});


function toastError(message){
    Swal.fire({
      toast: true,
      position: "top-end",
      icon: "error",
      title: message,
      showConfirmButton: false,
      timer: 2500,
      // imageSize: '100x100'
    });
  }
  
  function toastSuccess(message){
    Swal.fire({
      position: "top-end",
      toast: true,
      icon: "success",
      title: message,
      showConfirmButton: false,
      timer: 2500,
    });

    // const Toast = Swal.mixin({
    //   toast: true,
    //   position: 'top-end',
    //   showConfirmButton: false,
    //   timer: 3000
    // });

    // Toast.fire({ icon: 'success', title: ' &nbsp; success' })

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

  // image upload
  