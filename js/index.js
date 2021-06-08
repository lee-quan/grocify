$(document).ready(function(){
  $(window).scroll(function(){
    if(this.scrollY > 20) 
      $(".navigationbar").addClass("sticky");
    else
      $(".navigationbar").removeClass("sticky");
  });

  $('.menu-toggler').click(function(){
    $(this).toggleClass("active");
    $(".navigationbar-menu").toggleClass("active");
    $(".nav-icons").toggleClass("active");
    $("body").toggleClass("active");
    $(".navigationbar").toggleClass("active");
  });
});


// PopUp
// const popup = document.querySelector(".popup");
// const closePopup = document.querySelector(".popup-close");

// closePopup.addEventListener("click", () => {
//   popup.classList.remove("show");
// });

// window.addEventListener("load", () => {
//   setTimeout(() => {
//     popup.classList.add("show");
//   }, 5000);
// });

