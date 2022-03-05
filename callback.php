<?php
/**
 * @file
 * Take the user when they return from Twitter. Get access tokens.
 * Verify credentials and redirect to based on response from Twitter.
 */

/* Start session and load lib */
include_once("../db.php");

require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

/* If the oauth_token is old redirect to the connect page. */
if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
  $_SESSION['oauth_status'] = 'oldtoken';
  die("sorun burada".print_r($_SESSION));
//  header('Location: ./clearsessions.php');
}

/* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

/* Request access tokens from twitter */
$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

/* Save the access tokens. Normally these would be saved in a database for future use. */

$_SESSION['twitter_oauth_token'] = $access_token['oauth_token'];
$_SESSION['twitter_oauth_token_secret'] = $access_token['oauth_token_secret'];
$_SESSION['twitter_oauth_verifier'] = $_REQUEST['oauth_verifier'];
$_SESSION['twitter_screen_name'] = $access_token['screen_name'];

$query = "UPDATE cs_users SET
            twitter_oauth_token = '".$access_token['oauth_token']."',
            twitter_oauth_token_secret = '".$access_token['oauth_token_secret']."',
            twitter_oauth_verifier = '".$_REQUEST['oauth_verifier']."',
            twitter_user_id = '".$access_token['user_id']."',
            twitter_screen_name = '".$access_token['screen_name']."'
      WHERE user_id = '".$_SESSION['user_id']."'";
$result = mysql_query($query) or die (mysql_error()."Error code 1702 mr_request.php");
if(!$result) die("oauth_verifier PATLADI");

/* Remove no longer needed request tokens */
unset($_SESSION['oauth_token']);
unset($_SESSION['oauth_token_secret']);

/* If HTTP response is 200 continue otherwise send to connect page to retry */
if (200 == $connection->http_code) {
  /* The user has been verified and the access tokens can be saved for future use */
  $_SESSION['status'] = 'verified';
  header('Location: ./admin.php');
} else {
  /* Save HTTP status for error dialog on connnect page.*/
echo $connection->http_code;
//  header('Location: ./clearsessions.php');
}
