$(document).ready(() => {
  $(".searchbar__input").keypress((e) => {
    if (e.which == 13) {
      window.location.assign("search.php?search=" + e.target.value);
    }
  });
});
