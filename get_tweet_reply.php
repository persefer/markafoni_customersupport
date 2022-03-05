<?php
include_once("../db.php");
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

$tweet_array["results"]=array();

function getTweetReply($id_str,$tweet_array) {

	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['twitter_oauth_token'], $_SESSION['twitter_oauth_token_secret']);
	$json = $connection->get('statuses/show', array('id' => $id_str));

	array_push($tweet_array["results"],
		array(
			"id_str" => $json->id_str,
			"text" => stripslashes($json->text),
			"screen_name" => stripslashes($json->user->screen_name),
			"in_reply_to_status_id_str" => $json->in_reply_to_status_id_str,
			"code" => $connection->http_code
		)
	);

	if($in_reply_to_status_id_str) getTweetReply($in_reply_to_status_id_str,$tweet_array); // recursive
	else return $tweet_array;
}


if(isset($_REQUEST['id_str']) AND $_REQUEST['id_str'] != "" AND $_REQUEST['id_str'] != 0)
{
	echo json_encode(getTweetReply($_REQUEST['id_str'],$tweet_array));
}
else echo "cevap yok";




/*
"created_at":"Sun May 12 10:38:37 +0000 2013",
"id":333531654188580865,
"id_str":"333531654188580865",
"text":"B\u00fcy\u00fck derbi bu ak\u015fam! Peki ",
"source":"web",
"truncated":false,
"in_reply_to_status_id":null,
"in_reply_to_status_id_str":null,
"in_reply_to_user_id":null,
"in_reply_to_user_id_str":null,
"in_reply_to_screen_name":null,
"user":{
	"id":19768665,
	"id_str":"19768665",
	"name":"Markafoni",
	"screen_name":"markafoni",
	"location":"Turkey",
	"url":"http:\/\/www.markafoni.com",
	"description":"T\u00fcrkiye'nin lider \u00f6zel al\u0131\u015fveri\u015f",
	"protected":false,
	"followers_count":51441,
	"friends_count":15058,
	"listed_count":154,
	"created_at":"Fri Jan 30 14:17:54 +0000 2009",
	"favourites_count":298,
	"utc_offset":7200,
	"time_zone":"Istanbul",
	"geo_enabled":true,
	"verified":true,
	"statuses_count":18076,
	"lang":"en",
	"contributors_enabled":false,
	"is_translator":false,
	"profile_background_color":"FFFFFF",
	"profile_background_image_url":"http:\/\/a0.twimg.com\/profile_backgro36.png",
	"profile_background_image_url_https":"https:\/\/si0.twimg.comeef5044b336.png",
	"profile_background_tile":false,"profile_image_url":"http:\/\/a0.twimg.com\/profile_images\/2424790586\/kqrn7dsmk2ww6pne2kah_normal.png","profile_image_url_https":"https:\/\/si0.twimg.com\/profile_images\/2424790586\/kqrn7dsmk2ww6pne2kah_normal.png","profile_banner_url":"https:\/\/pbs.twimg.com\/profile_banners\/19768665\/1367573370","profile_link_color":"E2007A","profile_sidebar_border_color":"FFFFFF","profile_sidebar_fill_color":"F7EDF7","profile_text_color":"333333","profile_use_background_image":true,"default_profile":false,"default_profile_image":false,"following":false,"follow_request_sent":false,"notifications":false},"geo":null,"coordinates":null,"place":null,"contributors":null,"retweet_count":1,"favorite_count":0,"favorited":false,"retweeted":false,"possibly_sensitive":false,"lang":"tr"
*/



