
    document.addEventListener("DOMContentLoaded", function() {
  var swiper = new Swiper('.swiper-container', {
    direction: 'horizontal',
    slidesPerView: 1,
    spaceBetween: 10, 
    loop: true,
    autoplay: {
      delay: 4500, 
      disableOnInteraction: false, 
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    simulateTouch: false,
    speed: 800,
  });

      
      // Agregar evento de clic a las imágenes del slider para redireccionar a la página correspondiente
      var swiperSlides = document.querySelectorAll('.swiper-slide');
      swiperSlides.forEach(function(slide) {
        slide.addEventListener('click', function() {
          var link = this.querySelector('a').getAttribute('href');
          window.location.href = link;
        });
      });

  
    });
   
  document.addEventListener("DOMContentLoaded", function() {
  var swiper = new Swiper('.testimonial-container', {
    direction: 'horizontal',
    slidesPerView: 1,
    spaceBetween: 330, 
    loop: true,
    autoplay: {
      delay: 4500, 
      disableOnInteraction: false, 
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    simulateTouch: false,
    speed:700,
  });
});

  // Agregar evento de clic a las imágenes del slider para redireccionar a la página correspondiente
  var swiperSlides = document.querySelectorAll('.testimonial-container .swiper-slide');
  swiperSlides.forEach(function(slide) {
    slide.addEventListener('click', function() {
      var link = this.querySelector('a').getAttribute('href');
      window.location.href = link;
    });
  });

  function validarFormulario(event) {
        var name = document.getElementById('name').value;
        var email = document.getElementById('email').value;
        var privacy = document.getElementById('privacy').checked;

        if (name.trim() == '' || email.trim() == '' || !privacy) {
            document.getElementById('message').innerHTML = "Por favor, complete todos los campos y acepte las políticas de privacidad.";
            return false; 
        }

        return true;
    }

   
