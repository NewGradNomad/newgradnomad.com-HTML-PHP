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


  $query = $db->prepare("UPDATE jobListings SET paymentStatus = 1 WHERE listingID = :listingID");
  $query->bindParam(':listingID', $_SESSION['listingNumber']);
  if ($query->execute()) {
    $_SESSION['listingSuccess'] = true;
  } else {
    $_SESSION['contactSupport'] = true;
    $_SESSION['listingID'] = $_SESSION['listingNumber'];
  }
  //closes database connection
  $db = null;
  $_SESSION['listingNumber'] = null;
  $_SESSION['orderTotal'] = null;
  //exit();


  echo json_encode(['status' => $session->status, 'customer_email' => $session->customer_details->email]);
  http_response_code(200);
} catch (Error $e) {
  http_response_code(500);
  echo json_encode(['error' => $e->getMessage()]);
}
