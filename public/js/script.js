document.addEventListener("DOMContentLoaded", function () {
    const menuBars = document.getElementById('menu-bars');
    const navbar = document.querySelector('.navbar');

    menuBars.addEventListener('click', function () {
        navbar.classList.toggle('active');
    });
});

window.onscroll = () =>{
    menubar.classList.remove('fa-times');
    navbar.classList.remove('active');
}

document.querySelector('#search-icon').onclick = () =>{
    document.querySelector('#search-form').classList.toggle('active');
}

document.querySelector('#close').onclick = () =>{
    document.querySelector('#search-form').classList.remove('active');
}

//carrossel
var swiper = new Swiper(".home-slider", {
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: {
    delay: 7500,
    disableOnInteraction: false,
    },
    pagination: {
    el: ".swiper-pagination",
    clickable: true,
    },
    loop:true,
});

document.addEventListener("DOMContentLoaded", function () {
    var swiper = new Swiper(".food-slider", {
        grabCursor: true,
        loop: true,
        centeredSlides: true,
        spaceBetween: 20,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            700: {
                slidesPerView: 2,
            },
            1000: {
                slidesPerView: 3,
            },
        },
    });
});










