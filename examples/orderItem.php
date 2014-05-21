<?php

include_once __DIR__ . '/../ArtGun.php';
include_once __DIR__ . '/config.php';

use artgun\ArtGun;

// Generates a random xid of 10 characters
$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$xid = '';
for ($p = 0; $p < 10; $p++) {
  $xid .= $characters[mt_rand(0, strlen($characters)-1)];
} 

$order = ArtGun::Order($xid);

$shippingAddress = ArtGun::Address(
  'DK',
  'TEST DO NOT PRINT',
  "Lystgaardsparken 78",
  '',
  'Odder',
  0,
  '8300'
);
$order->setShippingAddress($shippingAddress);

// Initialize item with sku
$shirt = ArtGun::Item('10042602');
$shirt->addAttribute(
  'http://www.officialpsds.com/images/thumbs/tyrone-biggumsdave-chapelle-psd31751.png',
  'http://www.officialpsds.com/images/thumbs/tyrone-biggumsdave-chapelle-psd31751.png',
  'http://www.officialpsds.com/images/thumbs/tyrone-biggumsdave-chapelle-psd31751.png',
  'png'
);
$shirt->addAttribute(
  'http://www.officialpsds.com/images/thumbs/tyrone-biggumsdave-chapelle-psd31751.png',
  'http://www.officialpsds.com/images/thumbs/tyrone-biggumsdave-chapelle-psd31751.png',
  'http://www.officialpsds.com/images/thumbs/tyrone-biggumsdave-chapelle-psd31751.png',
  'png',    // Image file type
  'FN',     // Image location
  'HangTag' // Image type
);
$order->addItem($shirt);

$artGun = new ArtGun($artGunConfig);
$response = $artGun->sendOrder($order, '1234567', '');

echo json_encode($response);

