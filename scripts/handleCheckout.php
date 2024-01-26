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

$YOUR_DOMAIN = $domain;
$checkout_session = $stripe->checkout->sessions->create([
  'ui_mode' => 'embedded',
  'line_items' => [[
    'price_data' => [
      'currency' => 'usd',
      'product_data' => [
        'name' => 'Job Listing',
        'description' => 'Listing ID: ' . $_SESSION['listingNumber'],
      ],
      'unit_amount' => intval($_SESSION['orderTotal']),
    ],
    'quantity' => 1,
  ]],
  'mode' => 'payment',
  'return_url' => $YOUR_DOMAIN . '/pages/success?session_id={CHECKOUT_SESSION_ID}',
]);

echo json_encode(array('clientSecret' => $checkout_session->client_secret));
