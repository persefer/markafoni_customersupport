<?php
ini_set("display_errors",1);
ini_set("error_reporting", 2147483647);
include_once("../../db.php");

if(!isset($_SESSION['tweet_count']) OR $_SESSION['tweet_count'] < 10) $_SESSION['tweet_count'] = 10;

date_default_timezone_set('Europe/Istanbul');


/*
class TwitterSearch2 {
  /* Contains the last HTTP status code returned. 
  public $http_code;
  /* Contains the last API call. 
  public $url;
  /* Set up the API root URL. 
  public $host = "https://api.twitter.com/1/";
  /* Set timeout default. 
  public $timeout = 30;
  /* Set connect timeout. 
  public $connecttimeout = 30; 
  /* Verify SSL Cert. 
  public $ssl_verifypeer = FALSE;
  /* Respons format. 
  public $format = 'json';
  /* Decode returned json data. 
  public $decode_json = TRUE;
  /* Contains the last HTTP headers returned. 
  public $http_info;
  /* Set the useragnet. 
  public $useragent = 'TwitterOAuth v0.2.0-beta2';
  /* Immediately retry the API call if the response was not successful. */
  //public $retry = TRUE;




/*
  function accessTokenURL()  { return 'https://api.twitter.com/oauth/access_token'; }

  function __construct($consumer_key, $consumer_secret, $oauth_token = NULL, $oauth_token_secret = NULL) {
    $this->sha1_method = new OAuthSignatureMethod_HMAC_SHA1();
    $this->consumer = new OAuthConsumer($consumer_key, $consumer_secret);
    if (!empty($oauth_token) && !empty($oauth_token_secret)) {
      $this->token = new OAuthConsumer($oauth_token, $oauth_token_secret);
    } else {
      $this->token = NULL;
    }
  }

  function post($url, $parameters = array()) {
    $response = $this->oAuthRequest($url, 'POST', $parameters);
    if ($this->format === 'json' && $this->decode_json) {
      return json_decode($response);
    }
    return $response;
  }

    function get($url, $parameters = array()) {
    $response = $this->oAuthRequest($url, 'GET', $parameters);
    if ($this->format === 'json' && $this->decode_json) {
      return json_decode($response);
    }
    return $response;
  }


   function http($url, $method, $postfields = NULL) {
    $this->http_info = array();
    $ci = curl_init();
    /* Curl settings 
    curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
    curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ci, CURLOPT_HTTPHEADER, array('Expect:'));
    curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
    curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
    curl_setopt($ci, CURLOPT_HEADER, FALSE);

    switch ($method) {
      case 'POST':
        curl_setopt($ci, CURLOPT_POST, TRUE);
        if (!empty($postfields)) {
          curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
        }
        break;
      case 'DELETE':
        curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
        if (!empty($postfields)) {
          $url = "{$url}?{$postfields}";
        }
    }

    curl_setopt($ci, CURLOPT_URL, $url);
    $response = curl_exec($ci);
    $this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    $this->http_info = array_merge($this->http_info, curl_getinfo($ci));
    $this->url = $url;
    curl_close ($ci);
    return $response;
  } 

  function getHeader($ch, $header) {
    $i = strpos($header, ':');
    if (!empty($i)) {
      $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
      $value = trim(substr($header, $i + 2));
      $this->http_header[$key] = $value;
    }
    return strlen($header);
  }

}
*/

class TwitterSearch {

  private $tweet_count;
  private $geocode;
  public $json;

  public function getTweetCount() {
    return $this->tweet_count;
  }
  public function setTweetCount($tweet_count) {
    $this->tweet_count = $tweet_count;
  }

  private function setLastTweetId($last_tweet_id) {
    $this->last_tweet_id = $last_tweet_id;
  }

  private function getGeoCode() {
    return $this->geocode;
  }

  public function setGeoCode($latitude,$latitude,$radius) {
    $this->geocode = $latitude.",".$latitude.",".$radius;
  }  

  public function getLastTweetId() {
    $query = "SELECT tweet_id FROM cs_tweets WHERE campaign_id = '1' ORDER BY tweet_id DESC LIMIT 1";
    $result = mysql_query($query) or die("Error: 8 - a.php: ".mysql_error());
    $row = mysql_fetch_array($result);
    return $row['tweet_id'];
  }

  public function connect() {

      $temp = array(
                    'q'     =>  'markafoni', // query data. if you want to add more than 1, write as "love OR hate", or only hashtag write "#love". check other options at https://dev.twitter.com/docs/using-search
//                    'lang'  =>  'tr',         // check other language options at http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes  ----> 639-1
                    'result_type' => 'recent',  // other options "popular" and "popular"
                    'since_id'    => $this->getLastTweetId(),  // Tweet returns whose id are bigger than (newer) the given id
                    'rpp'       => $this->getTweetCount(),   // default is 15. If all tweets are new, function will optimize this number. I can be 100 as maximum.
//                    'geocode'     => $this->getGeoCode(),       // "latitude,longitude,radius" example: "37.781157,-122.398720,1km"
                    );  
      $postdata = http_build_query($temp);  
        
      $ch = curl_init();  
      curl_setopt($ch, CURLOPT_POST, true); //POST Metodu kullanarak verileri gönder  
      curl_setopt($ch, CURLOPT_HEADER, false); //Serverdan gelen Header bilgilerini önemseme.  
      curl_setopt($ch, CURLOPT_URL, "https://search.twitter.com/search.json"); //Bağlanacağı URL  
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata); //POST verilerinin querystring hali. Gönderime hazır!  
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //Transfer sonuçlarını return et. Onları kullanacağım!  
      curl_setopt($ch, CURLOPT_TIMEOUT, 20); //20 saniyede işini bitiremezsen timeout ol.  
      $this->json = curl_exec($ch);  
      curl_close($ch);  
       
  }

}


class DB {

  //Daha önceden bu tweet db ye eklenmişmi kontrol ediyoruz
  public function checkTweetAvailable($tweet_id) {
    $query = "SELECT tweet_id FROM cs_tweets WHERE tweet_id = '".$tweet_id."' LIMIT 1";
    $result = mysql_query($query) or die("Error: 8 - a.php: ".mysql_error());
    if(mysql_num_rows($result)) return TRUE;
    else return FALSE;
  }

  public function insertTweet($tweet) {

if (strpos($tweet->text, "RT @") === false) $is_active = 1; else $is_active = 0;


    $query = "INSERT INTO cs_tweets (
                    `tweet_id`,
                    `in_reply_to_status_id`,
                    `campaign_id`,
                    `from_user`,
                    `from_user_name`,
                    `from_user_id`,
                    `profile_image_url`,
                    `text`,
                    `date_orj`,
                    `created_at`,
                    `is_active`) 
              VALUES (
                    '".$tweet->id."',";
                  if(isset($tweet->in_reply_to_status_id) AND $tweet->in_reply_to_status_id != "")
                    $query .= "'".$tweet->in_reply_to_status_id_str."',";
                  else
                    $query .= "0,";
                  $query .= "'1',
                    '".addslashes($tweet->from_user)."',
                    '".addslashes($tweet->from_user_name)."',
                    '".$tweet->from_user_id."',
                    '".$tweet->profile_image_url."',
                    '".addslashes($tweet->text)."',
                    '".$tweet->created_at."',
                    '".date('j/m/Y H:i:s ', strtotime($tweet->created_at))."',
                    '".$is_active."'
                    )";
    $result = mysql_query($query) or die("Error: insertTweet() - class_twittersearch.php: ".mysql_error());
    if($result) return TRUE;
    else return FALSE;
  }

}


$conn = new TwitterSearch;
$db = new DB;
$conn->setGeoCode("39.639538","33.925781","800km");
$conn->setTweetCount(10);
$conn->connect();


echo "<hr>Last Tweet Id: ".$conn->getLastTweetId()."<hr>\n";

//$_SESSION['tweet_count'] = $conn->getTweetCount();



$tweets = json_decode($conn->json);
//echo sizeof($tweets->results)."<br>\n";
if($tweets->results)
{
  foreach ($tweets->results AS $tweet) {
    if(!$db->checkTweetAvailable($tweet->id))
    {
      if($db->insertTweet($tweet))
      {
        echo $tweet->id.$tweet->created_at." - ".date('j/m/Y H:i:s ', strtotime($tweet->created_at))." tweet eklendi<br>\n";     
      }
      else
      {
        echo $tweet->id.$tweet->created_at." - ".date('j/m/Y H:i:s ', strtotime($tweet->created_at))." tweet eklenemedi<br>\n";
      }
    }
    else
    {
      echo $tweet->id.$tweet->created_at." - ".date('j/m/Y H:i:s ', strtotime($tweet->created_at))." bu tweet var<br>\n";
    }
  }
} 

?>

