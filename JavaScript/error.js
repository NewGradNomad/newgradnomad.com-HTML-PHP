$(function () {
  $("#navbar").load("./components/navbar.html");
  $("#footer").load("./components/footer.html");
  $("#errorLinks").load("./components/errorLinks.html");
});

var loc = window.location.href;
var dir = loc.substring(loc.lastIndexOf("?") + 1, loc.lastIndexOf("?") + 4);
console.log(dir);
if (dir.includes("400")) {
  $("#errorMessage").html('<h1 class="mt-3">400 Bad Request</h1><h3 class="mt-3">Warning: The client should not repeat this request without modification.</h3>').show();
} else if (dir.includes("401")) {
  $("#errorMessage").html('<h1 class="mt-3">401 Unauthorized</h1><h3 class="mt-3">Request Has Not Been Completed Because It Lacks Valid Authentication Credentials.</h3>').show();
} else if (dir.includes("403")) {
  $("#errorMessage").html('<h1 class="mt-3">403 Forbidden</h1><h3 class="mt-3">You do not have access to this resource.</h3>').show();
} else if (dir.includes("404")) {
  $("#errorMessage").html('<h1 class="mt-3">404 Not Found</h1><h3 class="mt-3">Oops! You seem to be lost.</h3>').show();
} else if (dir.includes("503")) {
  $("#errorMessage").html('<h1 class="mt-3">503 Service Unavailable</h1><h3 class="mt-3">The Server Is Not Ready To Handle the Request, Try Again Later.</h3>').show();
} else {
  $("#errorMessage").html('<h1 class="mt-3">404 Not Found</h1><h3 class="mt-3">Oops! You seem to be lost.</h3>').show();
}
