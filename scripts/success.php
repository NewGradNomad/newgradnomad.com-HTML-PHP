<?php
require_once '../components/db_connect.php';

//includes session info
session_start();

$listingID = parse_url($_SERVER["REQUEST_URI"], PHP_URL_QUERY);

$query = $db->prepare("UPDATE jobListings SET paymentStatus = 1 WHERE listingID = :listingID");
$query->bindParam(':listingID', $listingID);
if ($query->execute()) {
  $_SESSION['listingSuccess'] = true;
  header('Location: ../');
} else {
  $_SESSION['contactSupport'] = true;
  $_SESSION['listingID'] = $listingID;
  header('Location: ../pages/PostAJob');
}
//closes database connection
$db = null;
exit();
