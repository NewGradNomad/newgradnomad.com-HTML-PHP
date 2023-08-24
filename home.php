<?php
//includes database connection
require_once './components/db_connect.php';
require_once './components/prices.php';
//get session data
session_start();

$searchReq = filter_input(INPUT_GET, 'searchQuery');

//prepare query based on input received
if ($searchReq != NULL || $searchReq != FALSE) {
  $query = $db->prepare("SELECT * FROM jobListings WHERE paymentStatus = 1 AND primaryTag like :search OR keywords like :search OR positionType like :search OR positionName like :search OR companyName like :search ORDER BY `jobListings`.`postedDate` DESC");
  $query->bindValue(':search', "%" . $searchReq . "%");
} else {
  $query = $db->prepare("SELECT * FROM jobListings WHERE paymentStatus = 1 ORDER BY `jobListings`.`postedDate` DESC");
}

//query database
$query->execute();
$listings = $query->fetchAll();
$query->closeCursor();

$sortedListings = array();
$pinListings = array();
$noPinListings = array();
date_default_timezone_set("America/New_York");
$date = date("Y/m/d H:i:s");
$secondsPerDay = 86400;
$secondsPerWeek = 604800;
$secondsPerMonth = 2629800;
foreach ($listings as $listing) :
  $timeSincePost = strtotime($date) - strtotime($listing['postedDate']);
  if (($listing['pin'] == $pinPost24hrPrice && $timeSincePost <= $secondsPerDay) || ($listing['pin'] == $pinPost1wkPrice && $timeSincePost <= $secondsPerWeek) || ($listing['pin'] == $pinPost1mthPrice && $timeSincePost <= $secondsPerMonth)) {
    array_push($pinListings, $listing);
  } else {
    array_push($noPinListings, $listing);
  }
endforeach;
$sortedListings = array_merge($pinListings, $noPinListings)
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>NewGradNomad</title>
  <meta charset="utf-8">
  <link rel="icon" href="./style/icon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="./style/NavBar.css" rel="stylesheet">
  <link href="./style/Index.css" rel="stylesheet">
  <link href="./style/HeroSection.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="./JavaScript/home.js"></script>
</head>

<body>
  <?php
  if (!empty($_SESSION['listingSuccess']) && $_SESSION['listingSuccess']) {
    echo '
    <div class="alert alert-success alert-dismissible fade show my-0 text-center" role="alert">
    <strong>Listing was successfully posted!</strong>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    $_SESSION['listingSuccess'] = '';
  }
  ?>

  <div id="navbar"></div>

  <div class="text-center hero-container container-fluid">
    <h1 class="fs-1 text-center">Find Remote New Grad Jobs</h1>
    <p class="fs-4 lead text-center">The best place for new graduates &amp; entry-level talent to find remote work.</p>
    <a role="button" href="./pages/PostAJob" class=" btn btn-lg mx-1 mb-3 btn btn-light">Post a Job</a>
    <!--     <a role="button" href="./NewGradPrograms" class=" btn btn-lg mx-1 mb-3 btn btn-light">New Grad Programs</a>     -->
  </div>
  <form class="container" role="search" method="get" action="./">
    <label for="searchQuery" class="text-center mt-4 form-label" style="width: 100%;">
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
    if (empty($listings)) {
      echo '<div class="alert alert-warning text-center mt-4" role="alert">No results found for ';
      echo strtolower($searchReq) . '.</div>';
    }
    ?>
    <?php foreach ($sortedListings as $listing) : ?>
      <?php
      $tags = explode(";", $listing['keywords']);
      $pin = false;
      $timeSincePost = strtotime($date) - strtotime($listing['postedDate']);
      if ($listing['pin'] == $pinPost24hrPrice && $timeSincePost <= $secondsPerDay) {
        $pin = true;
      } else if ($listing['pin'] == $pinPost1wkPrice && $timeSincePost <= $secondsPerWeek) {
        $pin = true;
      } else if ($listing['pin'] == $pinPost1mthPrice && $timeSincePost <= $secondsPerMonth) {
        $pin = true;
      }
      echo '
      <div class="mt-4 card">
        <div class="card-body">
          <div class="container-fluid px-0">
            <div class="row">
              <div class="col">
                <div class="card-title h5">' . $listing['positionName'] . ': ' . $listing['positionType'] . '</div>
              </div>
              <div class="col-auto">
                <a role="button" href="' . $listing['url'] . '" class="button btn btn-primary"><strong>Apply</strong></a>
              </div>
              <div class="col-auto">
              ';
      if ($pin) {
        echo '<p class="" style="font-size: 16px;">📌</p>';
      }
      echo '
              </div>
            </div>
          </div>
          <div class="text-muted card-subtitle h6">' . $listing['companyName'] . '</div>
          <p class="mt-3">
            <button class="btn btn-primary button-green" type="button" data-bs-toggle="collapse" data-bs-target="#' . $listing['listingID'] . '" aria-expanded="false" aria-controls="' . $listing['listingID'] . '" style="background-color: #449175 !important;">
              Toggle Job Description
            </button>
          </p>
          <div class="collapse" id="' . $listing['listingID'] . '">
            <div class="card card-body">
            ' . $listing['jobDescription'] . '
            </div>
          </div>
          <div class="tag-wrap mt-3">
            <a class="card-link ms-0 me-2"><button type="button" class="my-2 card-link button btn btn-primary"><strong>' . $listing['primaryTag'] . '</strong></button></a>';
      for ($i = 0; $i < sizeof($tags) - 1; $i++) {
        echo '<a class="card-link ms-0 me-2"><button type="button" class="my-2 card-link button-tag btn btn-secondary btn-sm">' . $tags[$i] . '</button></a>';
      }
      echo '
          </div>
        </div>
      </div>
      ';
      ?>
    <?php endforeach; ?>
  </div>
</body>

<footer id="footer"></footer>

</html>