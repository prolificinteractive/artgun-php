<?php

namespace artgun;

class Address {

  /**
   * Country of the address
   *
   * @var string
   */
  public $country;


  /**
   * Shipping name
   *
   * @var string
   */
  public $name;

  /**
   * Street Address of the address
   *
   * @var string
   */
  public $address1;

  /**
   * Second line of street Address of the address
   *
   * @var string
   */
  public $address2;

  /**
   * City of the address
   *
   * @var string
   */
  public $city;

  /**
   * State or Province of the address
   *
   * @var string
   */
  public $state;

  /**
   * Zip code of the address
   */
  public $zipcode;

  public function __construct($country, $name, $address1,
                              $address2, $city, $state, $zipcode) {

    $this->address1 = $this->sanitize($address1);
    $this->address2 = $this->sanitize($address2);
    $this->city     = $this->sanitize($city);
    $this->country  = $this->sanitize($country);
    $this->name     = $this->sanitize($name);
    $this->state    = $this->sanitize($state);
    $this->zipcode  = $this->sanitize($zipcode);
  }
  
  protected function sanitize($str) {
    return strtoupper(preg_replace("/[^a-z0-9.]+/i", "", $str));
  }
}
