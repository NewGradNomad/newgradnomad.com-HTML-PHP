$(function () {
  $("#footer").load("./pages/footer.html");
});
$(document).ready(function () {
  $("#positionType").select2({
    theme: "bootstrap-5",
    placeholder: "Categories",
    closeOnSelect: true,
    allowClear: true,
    width: $(this).data("width")
      ? $(this).data("width")
      : $(this).hasClass("w-100")
      ? "100%"
      : "style",
  });
});
