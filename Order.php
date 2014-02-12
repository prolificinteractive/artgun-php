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
  public $address;

  public function setAddress($shipping_country, $shipping_name, $shipping_address1,
                             $shipping_address2, $shipping_city, $shipping_state, $shipping_Zipcode) {

    $this->address = new Address($shipping_country, $shipping_name, $shipping_address1,
      $shipping_address2, $shipping_city, $shipping_state, $shipping_Zipcode);
  }

  public function addItem($sku, $thumbnail_url, $preview_url, $print_url, $quantity) {
    $this->items[] = array(
      "sku"        => $sku,
      "attributes" => array(
        array(
          "file_extension" => "png",
          "file_url"       => $print_url,
          "preview_url"    => $preview_url,
          // File_hash is optional and may be used at some point
          // the required hashing algorithm is still unknown presently
          // if used the print file name will probably change
          // from "mongoId".png to "file_hash".png
          //"file_hash" => "9AF7DF930C28074C28883E2C1B435C42",
          "thumbnail_url"  => $thumbnail_url,
          "location"       => "CF"
        ),
      ),
      "quantity"   => $quantity
    );
    $this->items_quantity += $quantity;
  }
}
