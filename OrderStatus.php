<?php

namespace artgun;

class OrderStatus {

  /**
   * @var string
   */
  public $type; //"ORDER",

  /**
   * @var \DateTime
   */
  public $time; //"time": "Fri, 09 Dec 2011 11:48:13 -0800"

  /**
   * @var string
   */
  public $method; //"method": "update",

  /**
   * @var string
   */
  public $xid; //"xid": "12345678",

  /**
   * @var string
   */
  public $status; //"status": "Shipped",

  /**
   * @var int
   */
  public $status_code; //"status_code": "4",

  /**
   * @var string
   */
  public $mode; //"mode": "auto",

  /**
   * @var string
   */
  public $tracking_number; //"tracking_number": "555555555",

  /**
   * @var string
   */
  public $bol; //"bol": "AG_987654321"

  function __construct($type, $time, $method, $xid, $status, $statusCode, $mode, $trackingNumber, $bol) {
    $this->type            = $type;
    $this->time            = $time;
    $this->method          = $method;
    $this->xid             = $xid;
    $this->status          = $status;
    $this->status_code     = $statusCode;
    $this->mode            = $mode;
    $this->tracking_number = $trackingNumber;
    $this->bol             = $bol;
  }

  public function success($receipt_id, $time = NULL) {
    if (empty($time)) {
      $time = date_format(date_create(), DATE_RFC822);
    }
    $successResp = array(
      "res"        => "success",
      "time"       => $time,
      "xid"        => $this->xid,
      "receipt_id" => $receipt_id
    );
    return json_encode($successResp);
  }

  public static function error($error, $code, $message) {
    $errorResp = array(
      "error"   => $error,
      "code"    => $code,
      "message" => $message
    );
    return json_encode($errorResp);
  }
}
