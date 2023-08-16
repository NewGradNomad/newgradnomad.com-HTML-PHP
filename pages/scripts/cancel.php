<?php
require_once '../../db_connect.php';

//includes session info
session_start();

$listingID = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);

$query = $db->prepare("DELETE FROM jobListings WHERE listingID = :listingID AND paymentStatus = 0");
$query->bindParam(':listingID', $listingID);
if ($query->execute()) {
  $_SESSION['cancelSuccess'] = true;
  header('Location: ../PostAJob');
} else {
  $_SESSION['contactSupport'] = true;
  $_SESSION['listingID'] = $listingID;
  header('Location: ../PostAJob');
}
//closes database connection
$db = null;
exit();

