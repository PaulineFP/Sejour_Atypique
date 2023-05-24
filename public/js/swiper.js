
if(window.innerWidth > 768 ) { // Détection
  // Il y a de la place
 var swiper = new Swiper(".slide-content", {
  slidesPerView: 4 ,
  spaceBetween: 30,
  loop: true,
  centerSlide: 'true',
  fade: 'true',
  grabCursor: 'true',
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
    dynamicBullets: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  }    
});
}

if(window.innerWidth > 430) {
  var swiper = new Swiper(".slide-content", {
    slidesPerView: 2 ,
    spaceBetween: 30,
    loop: true,
    centerSlide: 'true',
    fade: 'true',
    grabCursor: 'true',
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    } 
  })
}
 
  else {
  // Il y en a moins...
  var swiper = new Swiper(".slide-content", {
    slidesPerView: 1 ,
    spaceBetween: 30,
    loop: true,
    centerSlide: 'true',
    fade: 'true',
    grabCursor: 'true',
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    }    
  });
}






 