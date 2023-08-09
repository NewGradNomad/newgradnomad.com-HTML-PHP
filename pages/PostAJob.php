<!DOCTYPE html>
<html lang="en">

<head>
  <title>NewGradNomad</title>
  <meta charset="utf-8">
  <link rel="icon" href="../icon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../style/NavBar.css" rel="stylesheet">
  <link href="../style/PostAJob.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <script>
    $(function() {
      $("#navbar").load("./navbar.html");
      $("#footer").load("./footer.html");
    });
  </script>
</head>

<body>
  <div id="navbar"></div>
  <div class="mt-4 px-3 text-center container">
    <h2>Hire New Grads Naturally.</h2>
    <p class="lead"><b> We aggregate job listings from all around the web, but posting your job directly to our site gives top priority to your job posting.</b> </p>
  </div>

  <div class="gray-form mt-4 px-3 container">
    <form>
      <label class="section-title mt-3 form-label"><b>Getting Started</b></label>

      <div class="mb-3">
        <label class="form-label" for="companyName"><b>Company Name</b></label>
        <input required placeholder="Enter Company Name" name="companyName" type="text" id="companyName" class="form-control" value="">
      </div>

      <div class="mb-3">
        <label class="form-label" for="positionName"><b>Position</b></label>
        <input required placeholder="Enter Position Name" name="positionName" type="text" id="positionName" class="form-control" value="">
      </div>

      <label class="section-title form-label"><b>Job Post Perks</b></label>

      <div class="mb-3">
        <div class="form-check">
          <input value="150" required name="basicPosting" type="checkbox" id="basicPosting" class="form-check-input" checked onclick="return false;">
          <label title="" for="basicPosting" class="form-check-label">Basic Job Posting ($150)</label>
        </div>
      </div>

      <div class="mb-3">
        <div class="form-check">
          <input value="79" name="support" type="checkbox" id="support" class="form-check-input" onclick="updateTotal(this)">
          <label title="" for="support" class="form-check-label">Receive 24-hour support for your job posting (+$79)</label>
        </div>
      </div>

      <script>
        function checkCheckboxStatus(chk) {
          var chkName = document.getElementsByName(chk.name);
          var chkID = document.getElementById(chk.id);
          if (chkID.checked) {
            for (var i = 0; i < chkName.length; i++) {
              if (!chkName[i].checked) {
                chkName[i].disabled = true;
              } else {
                chkName[i].disabled = false;
              }
            }
          } else {
            for (var i = 0; i < chkName.length; i++) {
              chkName[i].disabled = false;
            }
          }
          updateTotal(chk)
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
      </script>

      <div class="mb-3">
        <div class="form-check">
          <input value="99" name="pinAddons" type="checkbox" id="pinPost24hr" class="form-check-input" onclick="checkCheckboxStatus(this)">
          <label title="" for="pinPost24hr" class="form-check-label">Pin post on front page for 24 hours (+$99)</label>
        </div>
      </div>

      <div class="mb-3">
        <div class="form-check">
          <input value="199" name="pinAddons" type="checkbox" id="pinPost1wk" class="form-check-input" onclick="checkCheckboxStatus(this)">
          <label title="" for="pinPost1wk" class="form-check-label">Pin post on front page for 1 week (+$199)</label>
        </div>
      </div>

      <div class="mb-3">
        <div class="form-check">
          <input value="349" name="pinAddons" type="checkbox" id="pinPost1mth" class="form-check-input" onclick="checkCheckboxStatus(this)">
          <label title="" for="pinPost1mth" class="form-check-label">Pin post on front page for 1 month (+$349)</label>
        </div>
      </div>

      <label class="section-title form-label"><b>Job Details</b></label>
      <div class="mb-3">
        <label class="form-label" for="appURL"><b>Application URL</b></label>
        <input required placeholder="https://" name="appURL" type="text" id="appURL" class="form-control" value="">
      </div>

      <div class="mb-3">
        <label class="form-label" for="appEmail"><b>Gateway Email Address</b></label>
        <input required placeholder="name@example.com" name="appEmail" type="email" id="appEmail" class="form-control" value="">
      </div>

      <label class="form-label"><b>Job Description</b></label>
      <div>
        <textarea placeholder="" name="jobDesc" id="jobDesc" class="form-control" style="height: 150px;"></textarea>
      </div>

      <div class="mb-3">
        <div class="">
          <input value="150" required hidden="" onclick="return false;" name="totalCost" type="checkbox" id="totalCost" class="form-check-input" checked="">
        </div>
      </div>
      <button type="submit" class="checkout-Button mt-4 mb-4 form-control btn btn-primary"><b>
          <div value="150" id="total">Checkout Job Posting $150</div>
        </b></button>
    </form>
  </div>

</body>

<footer id="footer"></footer>

</html>