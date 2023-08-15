<?php
//includes database connection
require_once '../../db_connect.php';
require_once '../../vendor/autoload.php';
require_once '../../secrets.php';
require_once '../../domain.php';

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
// $basicPosting = trim($_POST['basicPosting']);
// $support = trim($_POST['support']);
// $highlightPost = trim($_POST['highlightPost']);
// $pinPost24hr = trim($_POST['pinPost24hr']);
// $pinPost1wk = trim($_POST['pinPost1wk']);
// $pinPost1mth = trim($_POST['pinPost1mth']);
// $appURL = trim($_POST['appURL']);
// $appEmail = trim($_POST['appEmail']);
$jobDesc = trim($_POST['jobDesc']);
$totalCost = trim($_POST['totalCost']);

if (!isset($_POST['basicPosting'])) {
  //redirects to registration page if all values are not input
  $_SESSION['missingInput'] = true;
  header('Location: ../PostAJob.php');

  //closes database connection
  $db = null;
  exit();
} else {
  $basicPosting = trim($_POST['basicPosting']);
}
if (!isset($_POST['support'])) {
  $support = "-1";
} else {
  $support = trim($_POST['support']);
}
if (!isset($_POST['highlightPost'])) {
  $highlightPost = "-1";
} else {
  $highlightPost = trim($_POST['highlightPost']);
}
if (!isset($_POST['pinAddons'])) {
  $pin = "-1";
} else {
  $pin = trim($_POST['pinAddons']);
}

if (!isset($_POST['appURL'])) {
  $appURL = "-1";
} else {
  $appURL = trim($_POST['appURL']);
}
if (!isset($_POST['appEmail'])) {
  $appEmail = "-1";
} else {
  $appEmail = trim($_POST['appEmail']);
  $appURL = "mailto:" . $appEmail;
}

//checks if all required values are not empty
if (empty($companyName) || empty($positionName) || empty($positionType) || empty($primaryTag) || empty($keywords) || empty($basicPosting) || ($appURL == "mailto:" && empty($appEmail)) || empty($jobDesc) || empty($totalCost)) {

  //redirects to registration page if all values are not input
  $_SESSION['missingInput'] = true;
  header('Location: ../PostAJob.php');

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
  $_SESSION['listingSuccess'] = true;
  \Stripe\Stripe::setApiKey($stripeSecretKey);
  header('Content-Type: application/json');
  $price = $totalCost * 100;

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
    'success_url' => $YOUR_DOMAIN . '/pages/scripts/success.php?' . $listingNumber,
    'cancel_url' => $YOUR_DOMAIN . '/pages/PostAJob.php',
  ]);

  header("HTTP/1.1 303 See Other");
  header("Location: " . $checkout_session->url);
} else {
  //redirects to registration page if failed
  $_SESSION['listingError'] = true;
  header('Location: ../PostAJob.php');
}
//closes database connection
$db = null;
exit();
