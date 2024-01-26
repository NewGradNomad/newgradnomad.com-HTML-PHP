<?php
//includes database connection
require_once '../components/db_connect.php';
require_once '../vendor/autoload.php';
require_once '../components/secrets.php';
require_once '../components/prices.php';
require_once '../components/domain.php';

//includes session info
session_start();

//create listing number and get date+time
$listingNumber = mt_rand(1000000000, 9999999999);
date_default_timezone_set("America/New_York");
$date = date("Y/m/d H:i:s");

//takes form input and assigns them to variables
$companyName = trim($_POST['companyName']);
$positionName = trim($_POST['positionName']);
$positionType = trim($_POST['positionType']);
$primaryTag = trim($_POST['primaryTag']);
$keywords = $_POST['keywords'];
$basicPosting = trim($_POST['basicPosting']);
$support = trim($_POST['support']) ?? 0 ?: -1;
$pinPost24hr = trim($_POST['pinPost24hr']) ?? 0 ?: -1;
$pinPost1wk = trim($_POST['pinPost1wk']) ?? 0 ?: -1;
$pinPost1mth = trim($_POST['pinPost1mth']) ?? 0 ?: -1;
$pin = -1;
$appEmail = trim($_POST['appEmail']) ?? 0 ?: -1;;
$appURL = trim($_POST['appURL']) ?? 0 ?: "mailto:" . $appEmail;
$salaryRangeMin = trim($_POST['salaryRangeMin']);
$salaryRangeMax = trim($_POST['salaryRangeMax']);
$jobDesc = trim($_POST['jobDesc']);
$totalCost = trim($_POST['totalCost']);

$pinCount = 0;
$calculatedTotal = $standardListingPrice;
$combinedSalaryRange = $salaryRangeMin . ' - ' . $salaryRangeMax;

if ($pinPost24hr == $pinPost24hrPrice) {
  $pin = $pinPost24hrPrice;
  $pinCount++;
  $calculatedTotal += $pinPost24hrPrice;
} else if ($pinPost1wk == $pinPost1wkPrice) {
  $pin = $pinPost1wkPrice;
  $pinCount++;
  $calculatedTotal += $pinPost1wkPrice;
} else if ($pinPost1mth == $pinPost1mthPrice) {
  $pin = $pinPost1mthPrice;
  $pinCount++;
  $calculatedTotal += $pinPost1mthPrice;
}
if ($support != -1) {
  $calculatedTotal += $supportPrice;
}

//checks if all required values are not empty
if (empty($companyName) || empty($positionName) || empty($positionType) || empty($primaryTag) || empty($keywords) || empty($basicPosting) || ($appURL == "mailto:-1" && $appEmail == -1) || empty($jobDesc) || empty($totalCost) || $totalCost < $standardListingPrice || $pinCount > 1 || $calculatedTotal != $totalCost || empty($salaryRangeMax) || empty($salaryRangeMin)) {

  $_SESSION['missingInput'] = true;
  header('Location: ../pages/PostAJob');

  //closes database connection
  $db = null;
  exit();
}

//if generated account number is taken, make a new one
do {
  $listingNumber = mt_rand(1000000000, 9999999999);
  $query = $db->prepare("SELECT * FROM jobListings WHERE listingID = :listingNumber");
  $query->bindParam(':listingNumber', $listingNumber);
  $query->execute();
  $result = $query->fetchAll();
} while ($result);

$allKeywords = '';
for ($i = 0; $i < sizeof($keywords); $i++) {
  $allKeywords .= $keywords[$i] . ";";
}

//checks if insert was successful
$stripe = new \Stripe\StripeClient($stripeSecretKey);
header('Content-Type: application/json');
$price = $calculatedTotal * 100;
$paymentStatus = 1;
$_SESSION['orderTotal'] = $price;
$_SESSION['listingNumber'] = $listingNumber;
$_SESSION['listingData'] = array($listingNumber, $companyName, $positionName, $positionType, $primaryTag, $allKeywords, $support, $pin, $appURL, $appEmail, $combinedSalaryRange, $jobDesc, $date, $paymentStatus);
echo $_SESSION['listingData'][0];
header('Location: ../pages/checkout');
