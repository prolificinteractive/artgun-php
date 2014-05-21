<?php

include_once __DIR__ . '/../ArtGun.php';
include_once __DIR__ . '/../Order.php';
include_once __DIR__ . '/config.php';

use artgun\ArtGun;

$artGunConfig['URL'] = ''; // URL you want to post your shipping notification, simulates POST hook

$data = array(
    "type" => "ORDER",
    "time" => "Apr 10 2014  2:06:30:783PM",
    "method" => "update",
    "xid" => "7BLNEHGA6J",
    "status" => "Shipped",
    "status_code" => "4",
    "mode" => "auto",
    "tracking_number" => "01335036",
    "bol" => "E0000002"
);

$artGun = new ArtGun($artGunConfig);
$response = $artGun->call($data);

echo json_encode($response);


