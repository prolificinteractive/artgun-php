<?php

namespace artgun;

class Item {

  /**
   * ArtGuns UID for the item
   *
   * @var string
   */
  public $sku;

  /**
   * Number of items to be ordered
   *
   * @var int
   */
  public $quantity;

  /**
   * Attributes of the item.  Usually refering to a location and image to be
   * printed there.
   *
   * @var array
   */
  public $attributes;

  function __construct($sku, $quantity = 1) {
    $this->sku = $sku;
    $this->quantity = $quantity;
  }


  public function addAttribute($thumbnail_url, $preview_url, $file_url,
                               $file_extension, $location = 'CF', $type = 'DigitalPrint') {
    $this->attributes[] = array(
      "type"           => $type,
      "location"       => $location,
      "file_url"       => $file_url,
      "file_extension" => $file_extension,
      "preview"        => $preview_url,
      "thumbnail"      => $thumbnail_url,
      // File_hash is optional and may be used at some point
      // the required hashing algorithm is still unknown presently
      // if used the print file name will probably change
      // from "mongoId".png to "file_hash".png
      //"file_hash" => "9AF7DF930C28074C28883E2C1B435C42",
    );
  }
}
