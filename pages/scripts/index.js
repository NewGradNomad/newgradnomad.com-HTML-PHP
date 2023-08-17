$(function () {
  $("#footer").load("./pages/footer.html");
});
$(document).ready(function () {
  $("#searchQuery").select2({
    theme: "bootstrap-5",
    maximumSelectionLength: 1,
    placeholder: "Categories",
    tags: true,
    closeOnSelect: true,
    allowClear: true,
    width: $(this).data("width")
      ? $(this).data("width")
      : $(this).hasClass("w-100")
      ? "100%"
      : "style",
  });
});

$(function () {
  $("#navbar").load("./navbar.html");
  $("#footer").load("./pages/footer.html");
});