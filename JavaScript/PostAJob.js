window.addEventListener("pageshow", function (event) {
  var historyTraversal = event.persisted || (typeof window.performance != "undefined" && window.performance.navigation.type === 2);
  if (historyTraversal) {
    // Handle page restore.
    window.location.reload();
  }
});

$(function () {
  $("#navbar").load("../components/navbar.html");
  $("#footer").load("../components/footer.html");
});
$(document).ready(function () {
  $("#keywords").select2({
    theme: "bootstrap-5",
    maximumSelectionLength: 3,
    placeholder: "Select...",
    closeOnSelect: true,
    tags: true,
    allowClear: false,
    width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
    data: keywordsData,
  });
});

$(document).ready(function () {
  $("#positionType").select2({
    theme: "bootstrap-5",
    placeholder: "Position Type...",
    closeOnSelect: true,
    allowClear: false,
    width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
    data: positionTypesData,
  });
});

$(document).ready(function () {
  $("#primaryTag").select2({
    theme: "bootstrap-5",
    placeholder: "Select...",
    closeOnSelect: true,
    allowClear: false,
    width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
    data: primaryTagsData,
  });
});

$(document).ready(function () {
  $("#salaryRangeMin").select2({
    theme: "bootstrap-5",
    placeholder: "Minimum per year",
    closeOnSelect: true,
    allowClear: false,
    width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
    data: salaryRangesData,
  });
});

$(document).ready(function () {
  $("#salaryRangeMax").select2({
    theme: "bootstrap-5",
    placeholder: "Maximum per year",
    closeOnSelect: true,
    allowClear: false,
    width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
    data: salaryRangesData,
  });
});

function checkCheckboxStatus(chk) {
  var pinNames = ["pinPost24hr", "pinPost1wk", "pinPost1mth"];
  var chkID = document.getElementById(chk.id);
  if (chkID.checked) {
    for (var i = 0; i < pinNames.length; i++) {
      if (!document.getElementById(pinNames[i]).checked) {
        document.getElementById(pinNames[i]).setAttribute("disabled", "");
      } else {
        document.getElementById(pinNames[i]).removeAttribute("disabled");
      }
    }
  } else {
    for (var i = 0; i < pinNames.length; i++) {
      document.getElementById(pinNames[i]).removeAttribute("disabled");
    }
  }
  updateTotal(chk);
}

function updateTotal(chk) {
  var chkID = document.getElementById(chk.id);
  var currentTotal = parseFloat(total.getAttribute("value"));
  var checkboxValue = parseFloat(chkID.getAttribute("value"));
  if (chkID.checked) {
    var newTotal = currentTotal + checkboxValue;
    document.getElementById("total").setAttribute("value", newTotal);
  } else {
    var newTotal = currentTotal - checkboxValue;
    document.getElementById("total").setAttribute("value", newTotal);
  }
  document.getElementById("total").textContent = "Checkout Job Posting $" + newTotal;
  document.getElementById("totalCost").setAttribute("value", newTotal);
}

function checkEmailOrURL() {
  var emailPassRegex = RegExp(/^\w+([\.-]?(?=(\w+))\1)*@\w+([\.-]?(?=(\w+))\1)*(\.\w{2,3})+$/).test(document.forms["jobForm"]["appEmail"].value);
  var urlValue = document.forms["jobForm"]["appURL"].value;
  var emailValue = document.forms["jobForm"]["appEmail"].value;

  if (urlValue != null && urlValue != "") {
    appEmail.disabled = true;
    document.getElementById("EmailURLRequiredMessage").setAttribute("hidden", "");
    if (document.forms["jobForm"]["appURL"].value.includes("https://")) {
      document.getElementById("URLFormatMessage").setAttribute("hidden", "");
    } else {
      document.getElementById("URLFormatMessage").removeAttribute("hidden");
    }
  } else if (emailValue != null && emailValue != "") {
    appURL.disabled = true;
    document.getElementById("EmailURLRequiredMessage").setAttribute("hidden", "");
    if (emailPassRegex) {
      document.getElementById("EmailFormatMessage").setAttribute("hidden", "");
    } else {
      document.getElementById("EmailFormatMessage").removeAttribute("hidden");
    }
  } else {
    appEmail.disabled = false;
    appURL.disabled = false;
    document.getElementById("EmailURLRequiredMessage").removeAttribute("hidden");
    document.getElementById("EmailFormatMessage").setAttribute("hidden", "");
    document.getElementById("URLFormatMessage").setAttribute("hidden", "");
  }
  checkEnableCheckoutButton();
}

function checkInputField(currentField) {
  var currentFieldMessage = currentField.id + "RequiredMessage";
  var messageValue = document.forms["jobForm"][currentField.id].value;
  if (messageValue != null && messageValue != "") {
    document.getElementById(currentFieldMessage).setAttribute("hidden", "");
  } else {
    document.getElementById(currentFieldMessage).removeAttribute("hidden");
  }
  checkEnableCheckoutButton();
}

function checkEnableCheckoutButton() {
  var salaryMin = document.forms["jobForm"][salaryRangeMin.id].value;
  var salaryMax = document.forms["jobForm"][salaryRangeMax.id].value;
  var salaryMinInt = parseInt(salaryMin.replaceAll("$", "").replaceAll("k", ""));
  var salaryMaxInt = parseInt(salaryMax.replaceAll("$", "").replaceAll("k", ""));
  var emailPassRegex = RegExp(/^\w+([\.-]?(?=(\w+))\1)*@\w+([\.-]?(?=(\w+))\1)*(\.\w{2,3})+$/).test(document.forms["jobForm"]["appEmail"].value);
  var toolTip = document.getElementById("ToolTipCheckout");

  if (
    companyName.checkValidity() &&
    positionName.checkValidity() &&
    positionType.checkValidity() &&
    primaryTag.checkValidity() &&
    keywords.checkValidity() &&
    jobDesc.checkValidity() &&
    (appEmail.checkValidity() || appURL.checkValidity()) &&
    salaryRangeMin.checkValidity() &&
    salaryRangeMax.checkValidity() &&
    salaryMinInt <= salaryMaxInt
  ) {
    if (appURL.disabled == true && emailPassRegex) {
      checkoutButton.disabled = false;
      bootstrap.Tooltip.getInstance(toolTip).disable();
    } else if (appEmail.disabled == true && document.forms["jobForm"]["appURL"].value.includes("https://")) {
      checkoutButton.disabled = false;
      bootstrap.Tooltip.getInstance(toolTip).disable();
    } else {
      checkoutButton.disabled = true;
      bootstrap.Tooltip.getInstance(toolTip).enable();
    }
  } else {
    checkoutButton.disabled = true;
    bootstrap.Tooltip.getInstance(toolTip).enable();
  }
}

function checkSalaryRange() {
  var currentFieldMessage = "salaryRangeRequiredMessage";
  var salarySwappedMessage = "salaryRangeSwappedMessage";
  var salaryMin = document.forms["jobForm"][salaryRangeMin.id].value;
  var salaryMax = document.forms["jobForm"][salaryRangeMax.id].value;
  var salaryMinInt = parseInt(salaryMin.replaceAll("$", "").replaceAll("k", ""));
  var salaryMaxInt = parseInt(salaryMax.replaceAll("$", "").replaceAll("k", ""));

  if (salaryMin != null && salaryMin != "" && salaryMax != null && salaryMax != "") {
    document.getElementById(currentFieldMessage).setAttribute("hidden", "");
  } else {
    document.getElementById(currentFieldMessage).removeAttribute("hidden");
  }

  if (salaryMinInt > salaryMaxInt) {
    document.getElementById(salarySwappedMessage).removeAttribute("hidden");
  } else {
    document.getElementById(salarySwappedMessage).setAttribute("hidden", "");
  }
  checkEnableCheckoutButton();
}

$(document).ready(function () {
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
  const tooltipList = [...tooltipTriggerList].map((tooltipTriggerEl) => new bootstrap.Tooltip(tooltipTriggerEl));
});
