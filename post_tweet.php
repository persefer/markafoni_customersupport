<?php
include_once("../db.php");


date_default_timezone_set('Europe/Istanbul');
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');


if (empty($_SESSION['twitter_oauth_token']) || empty($_SESSION['twitter_oauth_token_secret'])) {
    die("sessiontimeout");
}



/* Create a TwitterOauth object with consumer/user tokens. */
if($_REQUEST['button'] == "send_reply")
{

//$twitter_oauth_token = "283953202-sh8yAhh6SBsVQz5FEJIhp33DlJS6TjjS4msJKHhL";
//$twitter_oauth_token_secret = "cEwW8SK6ImS3ZHlPjNWRgMllC3pF090bTbhAvcKbJOc";

// $twitter_oauth_token = "283953202-FwgtKxYa9rkbC7u2PNLMQ2RWl7TmFjencj4bY6tonE";
// $twitter_oauth_token_secret = "7c0GdCLhbw2m1bJb0yFAXVt10HRVDnOfomgjux8wmWI";

//    [oauth_token] => 390099177-vWVyCqsyOK6zeucIWGWpmtbX2PlirzvPVyvzSbw
 //   [oauth_token_secret] => LfKppjbQbjk7WT3P56lY2WUnCjitwvF7DTvvM8T9Rm0
/*
    [oauth_token] => 390099177-vWVyCqsyOK6zeucIWGWpmtbX2PlirzvPVyvzSbw
    [oauth_token_secret] => LfKppjbQbjk7WT3P56lY2WUnCjitwvF7DTvvM8T9Rm0
    [user_id] => 390099177
    [screen_name] => Unutmayalim
*/

  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['twitter_oauth_token'], $_SESSION['twitter_oauth_token_secret']);
//  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $twitter_oauth_token, $twitter_oauth_token_secret);

/* Request access tokens from twitter */
//$access_token = $connection->getAccessToken($_SESSION['twitter_oauth_verifier']);

/* Save the access tokens. Normally these would be saved in a database for future use. */
//$_SESSION['twitter_oauth_token'] = $access_token['oauth_token'];
//$_SESSION['twitter_oauth_token_secret'] = $access_token['oauth_token_secret'];

//print_r($_SESSION);



  $connection->post('statuses/update', array('status' => $_REQUEST['tweet_reply']));

  if($connection->http_code == 200 OR $connection->http_code == 304)
  {
    // Insert the reply tweet text to db
    $query = "INSERT INTO cs_tweets (
                    `replyto_id`,
                    `campaign_id`,
                    `from_user`,
                    `from_user_name`,
                    `profile_image_url`,
                    `text`,
                    `is_active`,
                    `created_at`
                    ) 
              VALUES (
                    '".addslashes($_REQUEST['replyto_id'])."',
                    '1',
                    'Markafoni',
                    'Markafoni',
                    'http://a0.twimg.com/profile_images/2424790586/kqrn7dsmk2ww6pne2kah_normal.png',
                    '".addslashes($_REQUEST['tweet_reply'])."',
                    '0',
                    '".date("Y-m-j H:i:s")."'
                    )";
    $result = mysql_query($query) or die("Error: 49 - a.php: ".mysql_error());
    if($result)
    {
      // Update the status of replied tweet to 2
      $query2 = "UPDATE cs_tweets SET is_active = 2,
                  options = '".addslashes($_REQUEST['opt_1']).",".addslashes($_REQUEST['opt_2']).",".addslashes($_REQUEST['opt_3']).",".addslashes($_REQUEST['opt_4'])."'
                 WHERE tweet_id = '".addslashes($_REQUEST['replyto_id'])."' ";
      $result2 = mysql_query($query2) or die ("Error code 1702 mr_request.php");
      if($result2)
      {
        echo $connection->http_code." - Tweet Başarıyla Gönderildi";
       // print_r($connection->http_info);
      }
      else
        echo $connection->http_code." - Reply kaydedildi ama orjinal tweet cevaplandı olarak set edilmedi".mysql_error();
    }
    else
      echo $connection->http_code." - Cevap gönderildi ama gönderilen cevap kaydedilemedi ve orjinal tweet cevaplandı olarak set edilmedi".mysql_error();
  }
  else
  {
    echo $connection->http_code." - Tweet Gönderilemedi.<hr>";
 //   print_r($connection->http_info);
 //   print_r($_SESSION);
  }
}
elseif ($_REQUEST['button'] == "save_description") {
    $query2 = "UPDATE cs_tweets SET is_active = 3,
                options = '".addslashes($_REQUEST['opt_1']).",".addslashes($_REQUEST['opt_2']).",".addslashes($_REQUEST['opt_3']).",".addslashes($_REQUEST['opt_4'])."'
               WHERE tweet_id = '".addslashes($_REQUEST['replyto_id'])."' ";
    $result2 = mysql_query($query2) or die ("Error code 1702 mr_request.php");
    if($result2) echo "200 - Bilgileri Guncellendi";
    else echo "600 - Hata: ".mysql_error();
}
elseif ($_REQUEST['button'] == "delete") {
    $query2 = "UPDATE cs_tweets SET is_active = 0 WHERE tweet_id = '".addslashes($_REQUEST['replyto_id'])."' ";
    $result2 = mysql_query($query2) or die ("Error code 1702 mr_request.php");
    if($result2) echo "200 - Bilgileri Guncellendi";
    else echo "600 - Hata: ".mysql_error();
}

?>