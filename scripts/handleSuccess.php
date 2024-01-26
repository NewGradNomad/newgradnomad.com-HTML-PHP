<?php
//includes database connection
require_once '../components/db_connect.php';
require_once '../vendor/autoload.php';
require_once '../components/secrets.php';
require_once '../components/domain.php';
//includes session info
session_start();

$stripe = new \Stripe\StripeClient($stripeSecretKey);
header('Content-Type: application/json');

try {
  // retrieve JSON from POST body
  $jsonStr = file_get_contents('php://input');
  $jsonObj = json_decode($jsonStr);

  $session = $stripe->checkout->sessions->retrieve($jsonObj->session_id);

  if (!empty($_SESSION['listingData'])) {
    $query = $db->prepare("INSERT INTO jobListings VALUES (:listingNumber, :companyName, :positionName, :positionType, :primaryTag, :keywords, :support, :pin, :appURL, :appEmail, :combinedSalaryRange, :jobDesc, :date, :paymentStatus)");
    $query->bindParam(':listingNumber', $_SESSION['listingData'][0]);
    $query->bindParam(':companyName', $_SESSION['listingData'][1]);
    $query->bindParam(':positionName', $_SESSION['listingData'][2]);
    $query->bindParam(':positionType', $_SESSION['listingData'][3]);
    $query->bindParam(':primaryTag', $_SESSION['listingData'][4]);
    $query->bindParam(':keywords', $_SESSION['listingData'][5]);
    $query->bindParam(':support', $_SESSION['listingData'][6]);
    $query->bindParam(':pin', $_SESSION['listingData'][7]);
    $query->bindParam(':appURL', $_SESSION['listingData'][8]);
    $query->bindParam(':appEmail', $_SESSION['listingData'][9]);
    $query->bindParam(':combinedSalaryRange', $_SESSION['listingData'][10]);
    $query->bindParam(':jobDesc', $_SESSION['listingData'][11]);
    $query->bindParam(':date', $_SESSION['listingData'][12]);
    $query->bindParam(':paymentStatus', $_SESSION['listingData'][13]);
    $query->execute();
  }
  //closes database connection
  $db = null;
  $query = null;
  $_SESSION['listingNumber'] = null;
  $_SESSION['orderTotal'] = null;
  $_SESSION['listingData'] = null;
  //exit();


  echo json_encode(['status' => $session->status, 'customer_email' => $session->customer_details->email]);
  http_response_code(200);
} catch (Error $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}
