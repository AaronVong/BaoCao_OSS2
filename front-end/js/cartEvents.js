function removeCartItem(id, dosth = () => {}) {
  $.post("order.php", { removeId: id }, function (data, status) {
    dosth();
  });
  return false;
}

function AddCartItem(id, dosth = () => {}) {
  $.post("order.php", { pid: id }, function (data, status) {
    dosth();
  });
}

$(document).ready(() => {
  // bắt sự kiện thêm sản phẩm vào giỏ hàng
  $(".cart-btn").click(function (e) {
    const id = e.target.getAttribute("pid");
    AddCartItem(id, () => {
      alert("Thêm vào giỏ hàng thành công");
    });
  });

  // bắt sự kiện xóa sản phẩm trong trang order.php
  $(".btn--rmorder").click((e) => {
    const id = e.target.value;
    removeCartItem(id, () => {
      window.location.reload();
    });
  });

  // bắt sự kiện tăng số lượng sản phẩm trong trang order.php
  $(".increment").click((e) => {
    const target = e.target;
    const input = $(target).next();
    const id = input.attr("forpid");
    input.val(function (index, val) {
      // nếu số lượng hiện tại < 4, thì vẫn thêm bình thường
      if (val < 4) {
        $.post(
          "order.php",
          { pid: id, action: "incre" },
          function (data, status) {
            window.location.reload();
          }
        );
      } else return val;
    });
  });

  // bắt sự kiện giảm số lượng sản phẩm trong trang order.php
  $(".decrement").click((e) => {
    const target = e.target;
    const input = $(target).prev();
    const id = input.attr("forpid");
    input.val(function (index, val) {
      // nếu số lượng > 1 thì vẫn giảm bình thường, nhưng khi số lượng = 1 thì remove nó khỏi cart
      if (val > 1) {
        $.post(
          "order.php",
          { pid: id, action: "decre" },
          function (data, status) {
            window.location.reload();
          }
        );
      } else {
        removeCartItem(id, () => {
          window.location.reload();
        });
      }
    });
  });

  // bắt sự kiện button mua ngay, sau khi nhấn chuyển hướng thẳng đến giỏ hàng
  $(".pay-btn").click((event) => {
    const id = event.target.getAttribute("pid");
    AddCartItem(id, () => {
      window.location.assign("order.php");
    });
  });

  // bắt sự kiện thay đổi trạng thái đơn hạng của khách hàng
  $(".user-action").click((event) => {
    const target = event.target;
    const value = target.value;
    console.log(value);
    $.post(
      "order.php?fnc=myorders",
      { oid: target.getAttribute("oid"), userAction: value },
      function (data, status) {
        window.location.reload();
      }
    );
  });
});
