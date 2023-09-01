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
    allowClear: true,
    width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
    data: keywordsData,
  });
});

$(document).ready(function () {
  $("#positionType").select2({
    theme: "bootstrap-5",
    placeholder: "Position Type...",
    closeOnSelect: true,
    allowClear: true,
    width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
    data: positionTypesData,
  });
});

$(document).ready(function () {
  $("#primaryTag").select2({
    theme: "bootstrap-5",
    placeholder: "Select...",
    closeOnSelect: true,
    allowClear: true,
    width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
    data: primaryTagsData,
  });
});

$(document).ready(function () {
  $("#salaryRangeMin").select2({
    theme: "bootstrap-5",
    placeholder: "Minimum per year",
    closeOnSelect: true,
    allowClear: true,
    width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
    data: salaryRangesData,
  });
});

$(document).ready(function () {
  $("#salaryRangeMax").select2({
    theme: "bootstrap-5",
    placeholder: "Maximum per year",
    closeOnSelect: true,
    allowClear: true,
    width: $(this).data("width") ? $(this).data("width") : $(this).hasClass("w-100") ? "100%" : "style",
    data: salaryRangesData,
  });
});

function checkCheckboxStatus(chk) {
  var boxNames = ["pinPost24hr", "pinPost1wk", "pinPost1mth"];
  var chkID = document.getElementById(chk.id);
  if (chkID.checked) {
    for (var i = 0; i < boxNames.length; i++) {
      if (!document.getElementById(boxNames[i]).checked) {
        document.getElementById(boxNames[i]).setAttribute("disabled", "");
      } else {
        document.getElementById(boxNames[i]).removeAttribute("disabled");
      }
    }
  } else {
    for (var i = 0; i < boxNames.length; i++) {
      document.getElementById(boxNames[i]).removeAttribute("disabled");
    }
  }
  updateTotal(chk);
}

function updateTotal(chk) {
  var chkID = document.getElementById(chk.id);
  if (chkID.checked) {
    var newTotal = parseFloat(total.getAttribute("value")) + parseFloat(chkID.getAttribute("value"));
    document.getElementById("total").setAttribute("value", newTotal);
  } else {
    var newTotal = parseFloat(total.getAttribute("value")) - parseFloat(chkID.getAttribute("value"));
    document.getElementById("total").setAttribute("value", newTotal);
  }
  document.getElementById("total").textContent = "Checkout Job Posting $" + newTotal;
  document.getElementById("totalCost").setAttribute("value", newTotal);
}

function checkEmailOrURL() {
  if (document.forms["jobForm"]["appURL"].value != null && document.forms["jobForm"]["appURL"].value != "") {
    appEmail.disabled = true;
    document.getElementById("EmailURLRequiredMessage").setAttribute("hidden", "");
    if (document.forms["jobForm"]["appURL"].value.includes("https://")) {
      document.getElementById("URLFormatMessage").setAttribute("hidden", "");
    } else {
      document.getElementById("URLFormatMessage").removeAttribute("hidden");
    }
  } else if (document.forms["jobForm"]["appEmail"].value != null && document.forms["jobForm"]["appEmail"].value != "") {
    appURL.disabled = true;
    document.getElementById("EmailURLRequiredMessage").setAttribute("hidden", "");
    if (RegExp(/^\w+([\.-]?(?=(\w+))\1)*@\w+([\.-]?(?=(\w+))\1)*(\.\w{2,3})+$/).test(document.forms["jobForm"]["appEmail"].value)) {
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
  if (document.forms["jobForm"][currentField.id].value != null && document.forms["jobForm"][currentField.id].value != "") {
    document.getElementById(currentFieldMessage).setAttribute("hidden", "");
  } else {
    document.getElementById(currentFieldMessage).removeAttribute("hidden");
  }
  checkEnableCheckoutButton();
}

function checkEnableCheckoutButton() {
  var salaryMinValue = document.forms["jobForm"][salaryRangeMin.id].value;
  var salaryMaxValue = document.forms["jobForm"][salaryRangeMax.id].value;
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
    parseInt(salaryMinValue.replace("$", "").replace("k", "")) <= parseInt(salaryMaxValue.replace("$", "").replace("k", ""))
  ) {
    if (appURL.disabled == true && RegExp(/^\w+([\.-]?(?=(\w+))\1)*@\w+([\.-]?(?=(\w+))\1)*(\.\w{2,3})+$/).test(document.forms["jobForm"]["appEmail"].value)) {
      checkoutButton.disabled = false;
    } else if (appEmail.disabled == true && document.forms["jobForm"]["appURL"].value.includes("https://")) {
      checkoutButton.disabled = false;
    } else {
      checkoutButton.disabled = true;
    }
  } else {
    checkoutButton.disabled = true;
  }
}

function checkSalaryRange() {
  var currentFieldMessage = "salaryRangeRequiredMessage";
  var salarySwappedMessage = "salaryRangeSwappedMessage";
  var salaryMinValue = document.forms["jobForm"][salaryRangeMin.id].value;
  var salaryMaxValue = document.forms["jobForm"][salaryRangeMax.id].value;
  if (salaryMinValue != null && salaryMinValue != "" && salaryMaxValue != null && salaryMaxValue != "") {
    document.getElementById(currentFieldMessage).setAttribute("hidden", "");
  } else {
    document.getElementById(currentFieldMessage).removeAttribute("hidden");
  }
  if (parseInt(salaryMinValue.replace("$", "").replace("k", "")) > parseInt(salaryMaxValue.replace("$", "").replace("k", ""))) {
    document.getElementById(salarySwappedMessage).removeAttribute("hidden");
    console.log(parseInt(salaryMinValue.replace("$", "").replace("k", "")));
  }
  checkEnableCheckoutButton();
}
