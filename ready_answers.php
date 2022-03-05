<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<META HTTP-EQUIV="Expires" CONTENT="-1">
  <title>TweetDuvar.im - Markafoni</title>
      <link rel="apple-touch-icon" href="images/Apple-Touch-Icon.png"/>

<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

<link href="css/style.css" rel="stylesheet" type="text/css" />

  <script type="text/javascript" src="js/fg.menu.js"></script>
  
  <link type="text/css" href="css/fg.menu.css" media="screen" rel="stylesheet" />
  <link type="text/css" href="css/theme/ui.all.css" media="screen" rel="stylesheet" />
  <link type="text/css" href="css/bootstrap.css" media="screen" rel="stylesheet" />

</head>
<body>




<?php

include_once("../db.php");
require_once('config.php');

if($_SESSION['twitter_oauth_token'] == "") die("token boş");


function getQuickAnswerTypes() {
$sql = "SELECT * FROM cs_tweets WHERE is_active = 2 ORDER BY date ASC";
$result = mysql_query($sql) or die("Error code 93269591".mysql_error());
if(mysql_num_rows($result))
{

	while ($row = mysql_fetch_array($result) )
	{
		extract($row);
}





function formatUserInformation($user_id,$next_cursor)
{

	$json = getTweetReply($screen_name,$next_cursor,"true","false");

	if($json->next_cursor == 0) echo "Son sayfa";
	else echo "<a href=\"get_follower_list.php?next_cursor=".$json->next_cursor."\">Sonraki Sayfa</a>";
	

	foreach ($json->users as $user) { ?>
	<div class="tweet_user">
		<div class="tweet_user_image"><img src="<?=$user->profile_image_url;?>"></div>
		<div class="tweet_user_name"><a href="http://www.twitter.com/<?=$user->screen_name;?>" target="_blank">@<?=$user->screen_name;?></a></div>
		<div class="tweet_user_name"><?=$user->name;?></div>
		<div class="follow_button"><button>Follow<?=$user->following;?><?=$user->follow_request_sent;?></button></div>
		<div class="tweet_user_description"><?=$user->description;?></div>
		<div class="tweet_user_box"><?=$user->followers_count;?></div>
		<div class="tweet_user_box"><?=$user->friends_count;?></div>
		<div class="tweet_user_box"><?=$user->statuses_count;?></div>
	</div>
<?php
	}
}


formatUserInformation($_SESSION['twitter_user_id'],$next_cursor);



/*
https://dev.twitter.com/docs/api/1.1

{
	"next_cursor": 1425847792138991796.0,
	"next_cursor_str": "1425847792138991796",
	"previous_cursor": 0,
	"previous_cursor_str": "0",
	"users": [
		{
			"contributors_enabled": false,
			"created_at": "Fri Mar 04 15:50:58 +0000 2011",
			"default_profile": false,
			"default_profile_image": false,
			"description": "Asla hayallerinden vazgeçme. Ve eğer bir sorunun varsa, halledemeyeceğini düşünme. Sadece gözlerini kapat ve dua et.
- Justin Bieber ♥",
			"favourites_count": 7,
			"follow_request_sent": false,
			"followers_count": 54,
			"following": false,
			"friends_count": 293,
			"geo_enabled": true,
			"id": 260780531,
			"id_str": "260780531",
			"is_translator": false,
			"lang": "tr",
			"listed_count": 0,
			"location": "Türkiye",
			"name": "ipekdikerler",
			"notifications": false,
			"profile_background_color": "ACDED6",
			"profile_background_image_url": "http://a0.twimg.com/profile_background_images/613066491/w2843i3phv8vhypl2aln.jpeg",
			"profile_background_image_url_https": "https://si0.twimg.com/profile_background_images/613066491/w2843i3phv8vhypl2aln.jpeg",
			"profile_background_tile": true,
			"profile_image_url": "http://a0.twimg.com/profile_images/2292818262/pte25er41salurnfifsl_normal.jpeg",
			"profile_image_url_https": "https://si0.twimg.com/profile_images/2292818262/pte25er41salurnfifsl_normal.jpeg",
			"profile_link_color": "038543",
			"profile_sidebar_border_color": "86A4A6",
			"profile_sidebar_fill_color": "A0C5C7",
			"profile_text_color": "333333",
			"profile_use_background_image": true,
			"protected": false,
			"screen_name": "ipekkkbieber",
			"statuses_count": 250,
			"time_zone": "Greenland", -------> bu şey bana ileride sorun çıkartabilir
			"url": <null>,
			"utc_offset": -10800,
			"verified": false
		},

*/
?>
</body>
</html>


