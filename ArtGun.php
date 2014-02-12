<?php

namespace artgun;

use artgun\Order;

include_once __DIR__ . '/Order.php';

class ArtGun {

  /**
   * Endpoint for the ArtGun api
   *
   * @var string
   */
  private $url;

  /**
   * Apikey for the ArtGun api
   *
   * @var string
   */
  private $apikey;

  /**
   * Secret for the ArtGun api
   *
   * @var string
   */
  private $secret;

  public function __construct($config) {
    $this->url    = $config['URL'];
    $this->apikey = $config['APIKEY'];
    $this->secret = $config['SECRET'];
  }

  public function sendOrder(Order $order, $xid, $environment, $shipping_carrier_or_account, $shipping_priority = NULL) {
    $data = array(
      'time'              => date_format(date_create(), DATE_RFC822),
      // status 'debug' or 'in production'
      "status"            => $environment,
      // shipping info
      "shipping_name"     => $order->address->shipping_name,
      "shipping_state"    => $order->address->shipping_state,
      "shipping_city"     => $order->address->shipping_city,
      "shipping_country"  => $order->address->shipping_country,
      "shipping_address1" => $order->address->shipping_address1,
      "shipping_address2" => $order->address->shipping_address2,
      "shipping_Zipcode"  => $order->address->shipping_Zipcode,
      "shipping_phone"    => '4159999999', // TODO:: find out if needed
      // 6 for sending order
      "status_code"       => "6",
      "items_quantity"    => $order->items_quantity,
      "items"             => $order->items,
      // must be unique
      "xid"               => $xid,
      "mode"              => "auto",
      "type"              => "ORDER",
      "method"            => "create"
    );

    if ($shipping_priority) {
      $data["shipping_carrier"]  = $shipping_carrier_or_account;
      $data["shipping_priority"] = $shipping_priority;
    }
    else {
      $data["shipping_account"] = $shipping_carrier_or_account;
    }

    return $this->call($data);
  }

  public function call($data) {

    $jsonData = json_encode($data);

    $fields = array(
      'key'       => $this->apikey,
      'data'      => $jsonData,
      'signature' => $this->getSignature($jsonData)
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->url);
    curl_setopt($ch, CURLOPT_POST, count($fields));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);

    return json_decode($response);
  }

  public function getSignature($jsonData) {
    return sha1($this->secret . $this->apikey . $jsonData);
  }

  public function keyMatches($key) {
    return $key == $this->apikey;
  }
}
