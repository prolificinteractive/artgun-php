<?php

namespace artgun;

use artgun\Address;

include_once __DIR__ . '/Address.php';

class Order {

  /**
   * Array of tee shirts to be ordered.
   *
   * @var array
   */
  public $items;

  /**
   * Number of items being ordered.
   *
   * @var int
   */
  public $items_quantity;

  /**
   * Address the order is to be shipped to.
   *
   * @var Address;
   */
  public $shipping_address;

  /**
   * Address the order is to be billed to.
   *
   * @var Address;
   */
  public $billing_address;

  /**
   * UID for the order.
   *
   * @var string
   */
  public $xid;


  public function __construct($xid) {
    $this->xid = $xid;
  }


  public function setShippingAddress($address) {
    $this->shipping_address = $address;
  }

  public function setBillingAddress($address) {
    $this->billing_address = $address;
  }

  public function addItem($item) {
    $this->items[] = array(
      "sku"        => $item->sku,
      "attributes" => $item->attributes,
      "quantity"   => $item->quantity
    );
    $this->items_quantity += $item->quantity;
  }
}
