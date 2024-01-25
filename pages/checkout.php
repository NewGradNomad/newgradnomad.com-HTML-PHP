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
  <meta charset="utf-8" />
  <title>Accept a payment</title>
  <meta name="description" content="Payment on Stripe" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- <link rel="stylesheet" href="style.css" /> -->
  <script src="https://js.stripe.com/v3/"></script>
  <script src="../JavaScript/checkout.js" defer></script>
</head>

<body>
  <!-- Display a payment form -->
  <div id="checkout">
    <!-- Checkout will insert the payment form here -->
  </div>
</body>

</html>