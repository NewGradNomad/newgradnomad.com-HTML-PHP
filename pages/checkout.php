<?php
//includes database connection
require_once '../components/db_connect.php';
//includes session info
session_start();

if (empty($_SESSION['orderTotal']) && empty($_SESSION['listingNumber'])) header('Location: ./PostAJob');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <link rel="icon" href="../style/icon.png" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="../style/NavBar.css" rel="stylesheet">
  <link href="../style/Footer.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
  <title>Accept a payment</title>
  <meta name="description" content="Payment on Stripe" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- <link rel="stylesheet" href="style.css" /> -->
  <script src="https://js.stripe.com/v3/"></script>
  <script src="../JavaScript/checkout.js" defer></script>
</head>

<body>
  <div id="navbar"></div>

  <!-- Display a payment form -->
  <div class="my-5" id="checkout">
    <!-- Checkout will insert the payment form here -->
  </div>
</body>
<footer id="footer"></footer>

</html>