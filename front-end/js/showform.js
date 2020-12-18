$(document).ready(() => {
  // hiệu ứng xuất hiện form điện thông tin khách hàng
  $(".btn--showform").click(() => {
    $(".order__form").slideDown();
  });

  // sự kiện thay đổi radio button trong form thông tin khách hàng
  $("input[name='location[]']").change((event) => {
    const location = event.target.value;
    if (location === "other") {
      $("#address").slideDown();
    }
    if (location != "other") {
      $("#address").slideUp();
    }
  });
});
