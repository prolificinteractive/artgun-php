<?php

namespace artgun;

class Address {

  /**
   * Country of the address
   *
   * @var string
   */
  public $shipping_country;


  /**
   * Shipping name
   *
   * @var string
   */
  public $shipping_name;

  /**
   * Street Address of the address
   *
   * @var string
   */
  public $shipping_address1;

  /**
   * Second line of street Address of the address
   *
   * @var string
   */
  public $shipping_address2;

  /**
   * City of the address
   *
   * @var string
   */
  public $shipping_city;

  /**
   * State or Province of the address
   *
   * @var string
   */
  public $shipping_state;

  /**
   * Zip code of the address
   */
  public $shipping_Zipcode;

  public function __construct($shipping_country, $shipping_name, $shipping_address1,
                              $shipping_address2, $shipping_city, $shipping_state, $shipping_Zipcode) {

    $this->shipping_address1 = $shipping_address1;
    $this->shipping_address2 = $shipping_address2;
    $this->shipping_city     = $shipping_city;
    $this->shipping_country  = $shipping_country;
    $this->shipping_name     = $shipping_name;
    $this->shipping_state    = $shipping_state;
    $this->shipping_Zipcode  = $shipping_Zipcode;
  }
}
