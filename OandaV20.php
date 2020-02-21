<?php 

/**
 * PHP Wrapper for Oanda v20 REST API  
 * 
 * More details: https://developer.oanda.com/rest-live-v20/development-guide/
 * 
 * @author Themis Dimitriou (https://github.com/thdim)
 */

class OandaV20 {
  // Set properties
  private $base_url;
  private $access_token;
  private $accountID; 
  private $headers = [
    "Accept-Datetime-Format: RFC3339",   // Replace "RFC3339" with "UNIX" for unix timestamps
  ];

  // Constructor
  public function __construct($is_production, $access_token, $accountID = '') {
    try {
      $this->base_url = ($is_production == true) ? 'https://api-fxtrade.oanda.com' : 'https://api-fxpractice.oanda.com'; 
      $this->access_token = $access_token;
      $this->accountID = $accountID;
    } catch (Exception $e) {
      print $e->getMessage() . "\n";
    }

    $this->headers[] = "Authorization: Bearer " . $this->access_token; // Authentication header
  }

  // Methods
  public function setAccountID($accountID) {
    $this->accountID = $accountID;
  }

  /**
     * Connect and make a call using Curl
     *
     * @param string $method "GET", "POST" or "PUT"
     * @param array $headers Headers to tack on for the call, including Auth
     * @param string $url Full constructed URL
     * @param string $post optional data to post
     *
     * @return JSON decoded API response as an array
     */

  public function makeCall($method, $headers, $url, $post = "") {
    // Init Curl
    $ch = curl_init();

    // Set options
    curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_HTTPHEADER => $headers,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_CONNECTTIMEOUT => 5,
      CURLOPT_TIMEOUT => 10,
    ));

    // Switch method and set more options
    switch ($method) {
      case "GET":
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
          curl_setopt($ch, CURLOPT_POST, false);
          break;
      case "POST":

          break;
      case "PUT":

          break;
    }

    $ce = curl_exec($ch);
    $result = json_decode($ce, true); // array

    return $result;
  } 
  

  /* ###### Account Endpoints ###### 
   * https://developer.oanda.com/rest-live-v20/account-ep/ */

  public function getAccounts() {
    // Set endpoint
    $endPoint = "/v3/accounts";
    // Construct Url
    $fullUrl = $this->base_url . $endPoint;
    // Call
    $result = $this->makeCall("GET", $this->headers, $fullUrl);
      
    return $result;
  }

  public function getAccount() {
    $endPoint = "/v3/accounts/".$this->accountID;
    $fullUrl = $this->base_url . $endPoint;
    $result = $this->makeCall("GET", $this->headers, $fullUrl);
    
    return $result;
  }

  public function getAccountSummary() {
    $endPoint = "/v3/accounts/".$this->accountID."/summary";
    $fullUrl = $this->base_url . $endPoint;
    $result = $this->makeCall("GET", $this->headers, $fullUrl);
    
    return $result;
  }

  public function getAccountInstruments() {
    $endPoint = "/v3/accounts/".$this->accountID."/instruments";
    $fullUrl = $this->base_url . $endPoint;
    $result = $this->makeCall("GET", $this->headers, $fullUrl);
    
    return $result;
  }

  /* ###### Instrument Endpoints ###### 
   * https://developer.oanda.com/rest-live-v20/instrument-ep/ */
  
   public function getInstrumentCandles($instrument, $queryArr) {
    // String to hold the extra queries data
    $queryUrl = '';

    if (!empty($queryArr)) {
      // Loop in Array
      foreach ($queryArr as $name => $value) {
        // array_key_first needs PHP >= 7.3.0
        if ($name === array_key_first($queryArr))
          $queryUrl .= '?'.$name.'='.$value;
        else
          $queryUrl .= '&'.$name."=".$value;
      }
    }

    $endPoint = "/v3/instruments/".$instrument."/candles".$queryUrl;
    $fullUrl = $this->base_url . $endPoint;
    $result = $this->makeCall("GET", $this->headers, $fullUrl);
    
    return $result;
  }


}
