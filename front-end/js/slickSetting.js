$(document).ready(function () {
  $("#main #banner .banner__carousel .slick-carousel").slick({
    autoplay: true,
    dots: true,
    nextArrow: `<button type="button" class="slick-next"><i class="fas fa-angle-right fa-icon"></i></button>`,
    prevArrow: `<button type="button" class="slick-prev"><i class="fas fa-angle-left fa-icon"></i></button>`,
    dragable: false,
    zIndex: 1,
    appendArrows: ".slick-carousel",
    appendDots: ".slick-carousel",
    adaptiveHeight: true,
    swipe: true,
  });

  $(".products-carousel").slick({
    dots: false,
    infinite: true,
    speed: 300,
    slidesToShow: 4,
    slidesToScroll: 4,
    accessibility: false,
    autoplay: true,
    autoplaySpeed: 1000,
    arrows: true,
    appendArrows: ".products-carousel",
    nextArrow: `<button type="button" class="slick-next slick-next--product"><i class="fas fa-angle-right fa-icon"></i></button>`,
    prevArrow: `<button type="button" class="slick-prev slick-prev--product"><i class="fas fa-angle-left fa-icon"></i></button>`,
    centerMode: true,
    zIndex: 1,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });

  $(".producers-carousel").slick({
    dots: false,
    infinite: true,
    speed: 400,
    slidesToShow: 3,
    slidesToScroll: 3,
    accessibility: false,
    autoplay: false,
    autoplaySpeed: 1000,
    arrows: true,
    appendArrows: ".producers-carousel",
    nextArrow: `<button type="button" class="slick-next slick-next--producer"><i class="fas fa-chevron-circle-right fa-icon"></i></button>`,
    prevArrow: `<button type="button" class="slick-prev slick-prev--producer"><i class="fas fa-chevron-circle-left fa-icon"></i></button>`,
    centerMode: true,
    zIndex: 1,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 3,
          infinite: true,
          dots: true,
        },
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
        },
      },
    ],
  });
});
