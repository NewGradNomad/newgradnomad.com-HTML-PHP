<?php
//includes database connection
require_once '../db_connect.php';
//get session variables
session_start();
?>
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

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <script src="./scripts/PostAJob.js"></script>
</head>

<body>
  <div class="container" style="color: red;"><h1><b>DO NOT use real cards at checkout, against stripe TOS in test mode.<br> Use stripe test card: 4242424242424242 04/24 024</b></h1></div>
  <div id="navbar"></div>
  <?php
  if (!empty($_SESSION['missingInput']) && $_SESSION['missingInput']) {
    echo '
    <div class="alert alert-danger alert-dismissible fade show mt-1 text-center" role="alert">
    <strong>An Error Occurred, Please Try Again.</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    $_SESSION['missingInput'] = '';
  } else if (!empty($_SESSION['listingError']) && $_SESSION['listingError']) {
    echo '
      <div class="alert alert-danger alert-dismissible fade show mt-1 text-center" role="alert">
      <strong>Unknown Error Occurred, Please Try Again Later.</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    $_SESSION['listingError'] = '';
  } else if (!empty($_SESSION['contactSupport']) && $_SESSION['contactSupport']) {
    echo '
      <div class="alert alert-danger alert-dismissible fade show mt-1 text-center" role="alert">
      <strong>Unknown Error Occurred, Please Contact Support. Reference ID: '; echo $_SESSION['listingID']; echo'</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    $_SESSION['contactSupport'] = '';
  } else if (!empty($_SESSION['cancelSuccess']) && $_SESSION['cancelSuccess']) {
    echo '
      <div class="alert alert-success alert-dismissible fade show mt-1 text-center" role="alert">
      <strong>Listing was Successfully Canceled.</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    $_SESSION['cancelSuccess'] = '';
  }
  ?>

  <div class="container-fluid">
    <div class="mt-4 text-center container">
      <h2>Hire New Grads Naturally.</h2>
      <p class="lead"><b>We aggregate job listings from all around the web, but posting your job directly to our site gives top priority to your job posting.</b> </p>
    </div>

    <div class="gray-form mt-4 container">
      <form name="jobForm" method="POST" action="./scripts/processPostAJob">
        <label class="section-title mt-3 form-label"><b>Getting Started</b></label>

        <div class="mb-3">
          <label class="form-label" for="companyName"><b>Company Name</b></label>
          <small class="form-text" id="companyNameRequiredMessage" style="color: red !important;">* Required: Please fill out.</small>
          <input autofocus required maxlength="200" placeholder="Enter Company Name" name="companyName" type="text" id="companyName" class="form-control" onkeyup="checkInputField(this)" />
          <div class="container"><small class="form-text">- Your company's brand name without business entities</small></div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="positionName"><b>Position</b></label>
          <small class="form-text" id="positionNameRequiredMessage" style="color: red !important;">* Required: Please fill out.</small>
          <input required maxlength="200" placeholder="Enter Position Name" name="positionName" type="text" id="positionName" class="form-control" onkeyup="checkInputField(this)" />
          <div class="container"><small class="form-text">- Write terms like "Associate Software Engineer" or "Social Media Manager" or "Business Analyst"</small></div>
        </div>

        <div class="mb-3">
          <small class="form-text" id="positionTypeRequiredMessage" style="color: red !important;">* Required: Please fill out.</small>
          <select required class="form-select form-control" name="positionType" id="positionType" onchange="checkInputField(this)">
            <option value=""></option>
            <option value="Full Time">Full Time</option>
            <option value="Part Time">Part Time</option>
            <option value="Contract">Contract</option>
          </select>
          <div class="container"><small class="form-text">- Specify full-time, part-time, etc...</small></div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="primaryTag"><b>Primary Tag</b></label>
          <small class="form-text" id="primaryTagRequiredMessage" style="color: red !important;">* Required: Please fill out.</small>
          <select required class="form-select form-control" name="primaryTag" id="primaryTag" onchange="checkInputField(this)">
            <option value=""></option>
            <option value="Software Development">Software Development</option>
            <option value="Customer Support">Customer Support</option>
            <option value="Sales">Sales</option>
            <option value="IT">IT</option>
            <option value="Writing">Writing</option>
            <option value="Human Resource">Human Resource</option>
            <option value="Design">Design</option>
            <option value="Recruiter">Recruiter</option>
          </select>
          <div class="container"><small class="form-text">- Main function of specified job</small></div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="keywords"><b>Keywords</b></label>
          <small class="form-text" id="keywordsRequiredMessage" style="color: red !important;">* Required: Max of 3.</small>
          <select required class="form-select form-control" multiple="multiple" name="keywords[]" id="keywords" onchange="checkInputField(this)">
            <option value="Developer">Developer</option>
            <option value="Engineer">Engineer</option>
            <option value="Full Stack">Full Stack</option>
            <option value="Finance">Finance</option>
            <option value="Accounting">Accounting</option>
            <option value="UX/UI">UX/UI</option>
            <option value="Technical">Technical</option>
            <option value="Non Technical">Non Technical</option>
            <option value="Manager">Manager</option>
            <option value="Crypto">Crypto</option>
            <option value="Testing">Testing</option>
          </select>
          <div class="container"><small class="form-text">- Add keywords that pertain to the jobs purpose</small></div>
        </div>

        <label class="mt-3 section-title form-label"><b>Job Post Perks</b></label>

        <div class="mb-3">
          <div class="form-check">
            <input value="150" required name="basicPosting" type="checkbox" id="basicPosting" class="form-check-input" checked onclick="return false;" />
            <label title="" for="basicPosting" class="form-check-label">Basic Job Posting ($150)</label>
          </div>
        </div>

        <div class="mb-3">
          <div class="form-check">
            <input value="79" name="support" type="checkbox" id="support" class="form-check-input" onclick="updateTotal(this)" />
            <label title="" for="support" class="form-check-label">Receive 24-hour support for your job posting (+$79)</label>
          </div>
        </div>

        <div class="mb-3">
          <div class="form-check">
            <input value="39" name="highlightPost" type="checkbox" id="highlightPost" class="form-check-input" onclick="updateTotal(this)" />
            <label title="" for="highlightPost" class="form-check-label">Highlight your job post in orange 🍊 to gain more views (+$39)</label>
          </div>
        </div>

        <div class="mb-3">
          <div class="form-check">
            <input value="99" name="pinAddons" type="checkbox" id="pinPost24hr" class="form-check-input" onclick="checkCheckboxStatus(this)" />
            <label title="" for="pinPost24hr" class="form-check-label">Pin post on front page for 24 hours (+$99)</label>
          </div>
        </div>

        <div class="mb-3">
          <div class="form-check">
            <input value="199" name="pinAddons" type="checkbox" id="pinPost1wk" class="form-check-input" onclick="checkCheckboxStatus(this)" />
            <label title="" for="pinPost1wk" class="form-check-label">Pin post on front page for 1 week (+$199)</label>
          </div>
        </div>

        <div class="mb-3">
          <div class="form-check">
            <input value="349" name="pinAddons" type="checkbox" id="pinPost1mth" class="form-check-input" onclick="checkCheckboxStatus(this)" />
            <label title="" for="pinPost1mth" class="form-check-label">Pin post on front page for 1 month (+$349)</label>
          </div>
        </div>

        <label class="section-title form-label"><b>Job Details</b></label>
        <small class="form-text" id="EmailURLRequiredMessage" style="color: red !important;">* Required: Please choose either email or URL.</small>
        <div class="mb-3">
          <label class="form-label" for="appURL"><b>Application URL</b></label>
          <input required maxlength="200" placeholder="https://" name="appURL" type="url" id="appURL" class="form-control" onkeyup="checkEmailOrURL()" />
          <div class="container"><small class="form-text">- This is the job link applicants will be forwarded to in order to apply top your job</small></div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="appEmail"><b>Gateway Email Address</b></label>
          <small class="form-text" id="EmailFormatMessage" style="color: red !important;" hidden>* This email is invalid.</small>
          <input required maxlength="200" placeholder="name@example.com" name="appEmail" type="email" id="appEmail" class="form-control" onkeyup="checkEmailOrURL()" />
          <div class="container"><small class="form-text">- Applicant is routed to this email if no application url is provided!</small></div>
        </div>

        <label class="form-label"><b>Job Description</b></label>
        <small class="form-text" id="jobDescRequiredMessage" style="color: red !important;">* Required: Please fill out.</small>
        <div>
          <textarea required maxlength="1000" placeholder="" name="jobDesc" id="jobDesc" class="form-control" style="height: 150px;" onkeyup="checkInputField(this)"></textarea>
        </div>

        <div class="mb-3">
          <div class="">
            <input value="150" required hidden="" onclick="return false;" name="totalCost" type="checkbox" id="totalCost" class="form-check-input" checked="" />
          </div>
        </div>
        <button id="checkoutButton" type="submit" class="checkout-Button mt-4 mb-4 form-control btn btn-primary" disabled>
          <b>
            <div value="150" id="total">Checkout Job Posting $150</div>
          </b>
        </button>
      </form>
    </div>
  </div>
</body>

<footer id="footer"></footer>

</html>