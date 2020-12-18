$(document).ready(() => {
  // hiệu ứng thanh navbar trang web
  const $hamburger = $(".hamburger");
  $hamburger.click(function () {
    $("#navbar--sfloor").toggleClass("toggleNav");
  });

  // hiệu ứng menu user (sau khi đăng nhập)
  $(".btn--user").click(() => {
    $(".user__menu").slideToggle();
  });

  // khi nhấn đăng xuất
  $(".btn--signout").click((e) => {
    $.post(
      "index.php",
      {
        signout: true,
      },
      function (data, status) {
        window.location.assign("index.php");
      }
    );
  });

  // khi user nhấn xem đơn hàng (xem đơn hàng của)
  $(".btn--myorders").click((event) => {
    $.get("order.php", function (data, status) {
      window.location.assign("order.php?action=myorders");
    });
  });
});
