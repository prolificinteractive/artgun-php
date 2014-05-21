<?php

include_once __DIR__ . '/../ArtGun.php';
include_once __DIR__ . '/config.php';

use artgun\ArtGun;

$xid = "123456789V";

$artGun = new ArtGun($artGunConfig);
$response = $artGun->cancelOrder($xid);

echo json_encode($response);


