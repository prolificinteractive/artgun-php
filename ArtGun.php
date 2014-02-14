<?php

namespace artgun;

use artgun\Order;
use artgun\Address;
use artgun\Item;

include_once __DIR__ . '/Order.php';
include_once __DIR__ . '/Address.php';
include_once __DIR__ . '/Item.php';

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

  /**
   * The shipping provider. e.g. UPS, DHL, etc.
   *
   * @var string
   */
  private $shipping_carrier;

  /**
   * The shipping priority. e.g. Express, 2Day, etc.
   *
   * @var string
   */
  private $shipping_priority;

  /**
   * Account number associated with your company's shipping provider.
   *
   * @var string
   */
  private $shipping_account;

  /**
   * Controls if the api is operating in production or debug mode.
   *
   * @var string
   */
  public $mode;

  public function __construct($config) {
    $this->url               = $config['URL'];
    $this->apikey            = $config['APIKEY'];
    $this->secret            = $config['SECRET'];
    $this->shipping_account  = $config['SHIPPING_ACCOUNT'];
    $this->shipping_carrier  = $config['SHIPPING_CARRIER'];
    $this->shipping_priority = $config['SHIPPING_PRIORITY'];
    if ($config['MODE'] == 'auto') $this->mode = $config['MODE'];
    else $this->mode = 'debug';
  }

  public static function Order($xid) {
    return new Order($xid);
  }

  public static function Address($country, $name, $address1, $address2, $city, $state, $zipcode) {
    return new Address($country, $name, $address1, $address2, $city, $state, $zipcode);
  }

  public static function Item($sku, $quantity = 1) {
    return new Item($sku, $quantity);
  }

  public function sendOrder($order) {
    $data = $this->getBaseData($order->xid);
    // status 'debug' or 'in production'
    $data['status']            = 'In Production';
    // 6 for sending order
    $data['status_code']       = '6';
    $data['method']            = 'create';
    // shipping info
    $data['shipping_carrier']  = $this->shipping_carrier;
    $data['shipping_priority'] = $this->shipping_priority;
    $data['shipping_account']  = $this->shipping_account;
    // shipping address info
    if (!empty($order->shipping_address)) {
      $data['shipping_name']     = $order->shipping_address->name;
      $data['shipping_state']    = $order->shipping_address->state;
      $data['shipping_city']     = $order->shipping_address->city;
      $data['shipping_country']  = $order->shipping_address->country;
      $data['shipping_address1'] = $order->shipping_address->address1;
      $data['shipping_address2'] = $order->shipping_address->address2;
      $data['shipping_Zipcode']  = $order->shipping_address->zipcode;
    }
    // billing info
    if (!empty($order->billing_address)) {
      $data['billing_name'] = $order->billing_address->name;
      $data['billing_address1'] = $order->billing_address->address1;
      $data['billing_address2'] = $order->billing_address->address2;
      $data['billing_city'] = $order->billing_address->city;
      $data['billing_state'] = $order->billing_address->state;
      $data['billing_country'] = $order->billing_address->country;
      $data['billing_Zipcode'] = $order->billing_address->zipcode;
    }
    $data['items_quantity']    = $order->items_quantity;
    $data['items']             = $order->items;

    // may be temporary
    $data['shipping_phone'] = '44444444444';
    return $this->call($data);
  }
  
  public function cancelOrder($xid, $notes = null, $incident = null) {
    $data = $this->getBaseData($xid);
    // status 'debug' or 'in production'
    $data['status']      = 'Cancelled';
    // 6 for sending order
    $data['status_code'] = '7';
    $data['method']      = 'update';
    
    $data['notes']       = $notes;
    $data['incident']    = $incident;
    
    return $this->call($data);
  }
  
  protected function getBaseData($xid) {
    $data = array();
    $data['type'] = 'ORDER';
    $data['xid']  = $xid;
    $data['mode'] = $this->mode;
    $data['time'] = date_format(date_create(), DATE_RFC822);
    return $data;
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
