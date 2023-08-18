<?php
//includes database connection
require_once '../../components/db_connect.php';
require_once '../../vendor/autoload.php';
require_once '../../components/secrets.php';
require_once '../../components/prices.php';
require_once '../../components/domain.php';

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
$highlightPost = trim($_POST['highlightPost']) ?? 0 ?: -1;
$pinPost24hr = trim($_POST['pinPost24hr']) ?? 0 ?: -1;
$pinPost1wk = trim($_POST['pinPost1wk']) ?? 0 ?: -1;
$pinPost1mth = trim($_POST['pinPost1mth']) ?? 0 ?: -1;
$pin = -1;
$appEmail = trim($_POST['appEmail']) ?? 0 ?: -1;;
$appURL = trim($_POST['appURL']) ?? 0 ?: "mailto:" . $appEmail;
$jobDesc = trim($_POST['jobDesc']);
$totalCost = trim($_POST['totalCost']);

$pinCount = 0;
$calculatedTotal = $standardListingPrice;

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

if ($highlightPost != -1) {
  $calculatedTotal += $highlightPostPrice;
}
if ($support != -1) {
  $calculatedTotal += $supportPrice;
}

//checks if all required values are not empty
if (empty($companyName) || empty($positionName) || empty($positionType) || empty($primaryTag) || empty($keywords) || empty($basicPosting) || ($appURL == "mailto:-1" && $appEmail == -1) || empty($jobDesc) || empty($totalCost) || $totalCost < $standardListingPrice || $pinCount > 1 || $calculatedTotal != $totalCost) {

  $_SESSION['missingInput'] = true;
  header('Location: ../PostAJob');

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
//prepares insert statement
$query = $db->prepare("INSERT INTO jobListings VALUES (:listingNumber, :companyName, :positionName, :positionType, :primaryTag, :keywords, :support, :highlightPost, :pin, :appURL, :appEmail, :jobDesc, :date, :paymentStatus)");
$query->bindParam(':listingNumber', $listingNumber);
$query->bindParam(':companyName', $companyName);
$query->bindParam(':positionName', $positionName);
$query->bindParam(':positionType', $positionType);
$query->bindParam(':primaryTag', $primaryTag);
$query->bindParam(':keywords', $allKeywords);
$query->bindParam(':support', $support);
$query->bindParam(':highlightPost', $highlightPost);
$query->bindParam(':pin', $pin);
$query->bindParam(':appURL', $appURL);
$query->bindParam(':appEmail', $appEmail);
$query->bindParam(':jobDesc', $jobDesc);
$query->bindParam(':date', $date);
$paymentStatus = 0;
$query->bindParam(':paymentStatus', $paymentStatus);

//checks if insert was successful
if ($query->execute()) {
  $_SESSION['addedToDataBase'] = true;
  \Stripe\Stripe::setApiKey($stripeSecretKey);
  header('Content-Type: application/json');
  $price = $calculatedTotal * 100;

  $YOUR_DOMAIN = $domain;

  $checkout_session = \Stripe\Checkout\Session::create([
    'line_items' => [[
      'price_data' => [
        'currency' => 'usd',
        'product_data' => [
          'name' => 'Job Listing',
          'description' => 'Listing ID: ' . $listingNumber,
        ],
        'unit_amount' => intval($price),
      ],
      'quantity' => 1,
    ]],
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . '/pages/scripts/success?' . $listingNumber,
    'cancel_url' => $YOUR_DOMAIN . '/pages/scripts/cancel?' . $listingNumber,
  ]);

  header("HTTP/1.1 303 See Other");
  header("Location: " . $checkout_session->url);
} else {
  $_SESSION['listingError'] = true;
  header('Location: ../PostAJob');
}
//closes database connection
$db = null;
exit();
