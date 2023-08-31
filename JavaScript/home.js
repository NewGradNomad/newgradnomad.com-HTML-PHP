$(document).ready(function () {
  $("#searchQuery").select2({
    theme: "bootstrap-5",
    maximumSelectionLength: 1,
    placeholder: "Categories",
    tags: true,
    closeOnSelect: true,
    allowClear: true,
    width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
  });
});

$(function () {
  $("#navbar").load("./components/navbar.html");
  $("#footer").load("./components/footer.html");
});

function checkApplyStatus(chk) {
  var chkID = document.getElementById(chk.id);
  var listingID = chk.id.substring(0, chk.id.indexOf("A"));
  var applyButton = document.getElementById(listingID + "ApplyButton");
  var toolTip = document.getElementById("ToolTip" + listingID);
  var classData = applyButton.getAttribute("class").toLowerCase();
  if (chkID.checked) {
    applyButton.setAttribute("class", classData.replace("disabled", ""));
    bootstrap.Tooltip.getInstance(toolTip).disable();
  } else {
    applyButton.setAttribute("class", classData.concat("disabled"));
    bootstrap.Tooltip.getInstance(toolTip).enable();
  }
}

function updateDescriptionButton(btn) {
  var btnID = document.getElementById(btn.id);
  var buttonText = btnID.textContent;
  if (buttonText.toLowerCase().includes("show")) {
    btnID.textContent = buttonText.replace("Show", "Hide");
  } else {
    btnID.textContent = buttonText.replace("Hide", "Show");
  }
}
