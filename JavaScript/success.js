initialize();

async function initialize() {
  const queryString = window.location.search;
  const urlParams = new URLSearchParams(queryString);
  const sessionId = urlParams.get("session_id");
  const response = await fetch("../scripts/handleSuccess.php", {
    headers: {
      Accept: "application/json",
      "Content-Type": "application/json",
    },
    method: "POST",
    body: JSON.stringify({ session_id: sessionId }),
  });
  const session = await response.json();

  if (session.status == "open") {
    //window.replace("./handleCheckout.php");
  } else if (session.status == "complete") {
    document.getElementById("success").classList.remove("hidden");
    document.getElementById("customer-email").textContent = session.customer_email;
  }
}

$(function () {
  $("#navbar").load("../components/navbar.html");
  $("#footer").load("../components/footer.html");
});
