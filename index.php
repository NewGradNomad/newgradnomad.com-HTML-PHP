<?php
//includes database connection
require_once './db_connect.php';
//get session data
session_start();

$searchReq = filter_input(INPUT_GET, 'searchQuery');

//prepare query based on input received
if ($searchReq != NULL || $searchReq != FALSE) {
  $query = $db->prepare("SELECT * FROM jobListings WHERE paymentStatus = 1 AND primaryTag like :search OR keywords like :search OR positionType like :search OR positionName like :search OR companyName like :search ORDER BY `jobListings`.`pin` DESC");
  $query->bindValue(':search', "%" . $searchReq . "%");
} else {
  $query = $db->prepare("SELECT * FROM jobListings WHERE paymentStatus = 1 ORDER BY `jobListings`.`pin` DESC");
}

//query database
$query->execute();
$listings = $query->fetchAll();
$query->closeCursor();

date_default_timezone_set("America/New_York");
$date = date("Y/m/d H:i:s");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>NewGradNomad</title>
  <meta charset="utf-8">
  <link rel="icon" href="./icon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="./style/NavBar.css" rel="stylesheet">
  <link href="./style/Index.css" rel="stylesheet">
  <link href="./style/HeroSection.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
  <script src="./pages/scripts/index.js"></script>
</head>

<body>
  <nav class="green-nav navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid"><a href="./index" class="navbar-brand">newgradnomad.com</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <div class="ms-auto navbar-nav">
            <a class="nav-links nav-link" href="./pages/PostAJob">
              <button type="button" class="button btn btn-primary"><strong>Post a Job</strong></button>
            </a>
            <a class="nav-links nav-link" href="./index">
              <button type="button" class="button-hide btn btn-primary"><strong>Home</strong></button>
            </a>
            <!-- <div class="button-hide nav-links mt-auto mb-auto show dropdown">
              <button data-bs-toggle="dropdown" type="button" aria-expanded="false" class="dropdown-toggle btn btn-button-hide"><strong>Community</strong></button>
              <div aria-labelledby="dropdown" data-bs-popper="static" class="dropdown-menu">
                <a target="_blank" href="https://discord.gg/khfQcbtHw8" class="nav-links dropdown-item"><button type="button" class="button-hide btn btn-primary"><strong>Discord</strong></button></a>
                <a data-bs-toggle="modal" data-bs-target="#newsletterModal" class="nav-links dropdown-item"><button type="button" class="button-hide btn btn-primary"><strong>Newsletter</strong></button></a>
              </div>
            </div> -->
            <a class="nav-links nav-link" href="./pages/about">
              <button type="button" class="button-hide btn btn-primary"><strong>About</strong></button>
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <?php
  if (!empty($_SESSION['listingSuccess']) && $_SESSION['listingSuccess']) {
    echo '
    <div class="alert alert-success alert-dismissible fade show mt-1" role="alert">
    <strong>Listing was successfully posted!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    $_SESSION['listingSuccess'] = '';
  }
  ?>

  <div class="text-center hero-container container-fluid">
    <h1 class="fs-1 text-center">Find Remote New Grad Jobs</h1>
    <p class="fs-4 lead text-center">The best place for new graduates &amp; entry-level talent to find remote work.</p>
    <a role="button" href="./pages/PostAJob" class=" btn btn-lg mx-1 mb-3 btn btn-light">Post a Job</a>
    <!--     <a role="button" href="./NewGradPrograms" class=" btn btn-lg mx-1 mb-3 btn btn-light">New Grad Programs</a>     -->
  </div>
  <form class="container" role="search" method="get" action="./index">
    <label class="text-center mt-4 form-label" style="width: 100%;">
      <h4>Search Remote Jobs</h4>
    </label>
    <div class="mt-2 d-flex align-items-center justify-content-center">
      <Select id="searchQuery" name="searchQuery" class="form-select" style="width:300px;" multiple="single">
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
      <button type="submit" class="ms-4 button btn btn-primary"><strong>Submit</strong></button>
    </div>
  </form>

  <div class="container">
    <?php 
      if (empty($listings)){
        echo '<div class="alert alert-warning text-center mt-4" role="alert">No results found for '; echo strtolower($searchReq). '.</div>';
      }
    ?>
    <?php foreach ($listings as $listing) : ?>
      <?php
      $timeSincePost = strtotime($date) - strtotime($listing['postedDate']);
      $pin = false;
      $secondsPerDay = 86400;
      $secondsPerWeek = 604800;
      $secondsPerMonth = 2629800;
      if ($listing['pin'] == 99 && $timeSincePost <= $secondsPerDay){
        $pin = true;
      } else if ($listing['pin'] == 199 && $timeSincePost <= $secondsPerWeek){
        $pin = true;
      } else if ($listing['pin'] == 349 && $timeSincePost <= $secondsPerMonth){
        $pin = true;
      }
      echo  '<div class="mt-4 card'; if ($listing['highlightOrange'] == 39) {echo ' orange-Card';} echo'">
              <div class="card-body">
                <div class="container-fluid px-0">
                  <div class="row">
                    <div class="col">
                      <div class="card-title h5'; if ($listing['highlightOrange'] == 39) {echo ' orange-Post-Font';} echo'">'.$listing['positionName'].': '.$listing['positionType'].'</div>
                    </div>
                    <div class="col-auto">
                      <a role="button" href="'.$listing['url'].'" class="'; if ($listing['highlightOrange'] == 39) {echo 'btn-dark ';} else{echo 'button btn-primary ';} echo'btn"><strong>Apply</strong></a>
                    </div>
                    <div class="col-auto">
                    '; if ($pin) {echo '<p class="" style="font-size: 16px; '; if ($listing['highlightOrange'] == 39) {echo 'background-color:gray;';} echo'">📌</p>';} echo'
                      
                    </div>
                  </div>
                </div>
                <div class="'; if ($listing['highlightOrange'] == 39) {echo 'orange-Post-Font';} echo' h6">'.$listing['companyName'].'</div>

                <p class="mt-3">
                  <button class="btn btn-primary button-green" type="button" data-bs-toggle="collapse" data-bs-target="#'.$listing['listingID'].'" aria-expanded="false" aria-controls="'.$listing['listingID'].'" style="background-color: #449175 !important;">
                    Toggle Job Description
                  </button>
                </p>
                <div class="collapse" id="'.$listing['listingID'].'">
                  <div class="card card-body mb-2">
                  '.$listing['jobDescription'].'
                  </div>
                </div>
                <div class="tag-wrap">';
                    echo '<a class="card-link ms-0 me-2"><button type="button" class="my-2 card-link btn '; if ($listing['highlightOrange'] == 39) {echo 'btn-dark ';} else{echo 'button btn-primary ';} echo'"><strong>' . $listing['primaryTag'] . '</strong></button></a>';
                    $tags = explode(";", $listing['keywords']);
                    for ($i = 0; $i < sizeof($tags) - 1; $i++) {
                      echo '<a class="card-link ms-0 me-2"><button type="button" class="my-2 card-link button-tag btn btn-secondary btn-sm">' . $tags[$i] . '</button></a>';
                    }
                echo' 
                </div>
              </div>
            </div>
        ';
      ?>
    <?php endforeach; ?>
  </div name="put job cards above this">

  <div class="modal fade" id="newsletterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <div class="modal-title h4">Newsletter Signup</div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Signing up for the newsletter will enable you to get notified via email when a new job listing is posted.</p>
          <form novalidate="">
            <div class="mb-3"><label class="form-label">Email address</label>
              <div class="input-group">
                <input required="" placeholder="name@example.com" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" type="email" class="form-control">
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Sign up</button>
        </div>
      </div>
    </div>
  </div>

</body>

<footer id="footer"></footer>

</html>