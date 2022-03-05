<?php

include_once("../db.php");

if(isset($_REQUEST['id_str_1']) AND $_REQUEST['id_str_1'] != "") $id_str_1 = $_REQUEST['id_str_1']; else $id_str_1 = 0;
if(isset($_REQUEST['campaign_id']) AND $_REQUEST['campaign_id'] != "") $campaign_id = $_REQUEST['campaign_id'];

// Get tweet only sent in last 2 days
$days_before = $date = date('Y-m-d H:i:s', time() - 2*24*60*60);

$sql = "SELECT * FROM cs_tweets WHERE tweet_id > '".$id_str_1."' AND is_active = '1' AND created_at > '".$days_before ."'  ORDER BY tweet_id ASC LIMIT 1";
$result = mysql_query($sql) or die("Error code 93269591".mysql_error());
	//	if($result) echo "---------0------";

if(mysql_num_rows($result))
{

$JSON["results"]=array();
while ($row = mysql_fetch_array($result) )
{
	extract($row);

	// Diziye veriyi diziler halinde  girelim
	array_push($JSON["results"],
		array(
			"id_str" => $tweet_id,
			"from_user" => stripslashes($from_user),
			"from_user_name" => stripslashes($from_user_name),
			"profile_image_url" => stripslashes($profile_image_url),
			"sent_at" =>   date('j/m/Y H:i:s ', strtotime($created_at)),
			"text" => stripslashes($text),
			"is_active" => stripslashes($is_active),
			"in_reply_to_status_id" => $in_reply_to_status_id,
		)
	);
	
//	$query2 = "UPDATE tweets SET is_active = ($is_active + 1) WHERE tweet_id = '".$tweet_id."'";
//	$result2 = mysql_query($query2) or die ("Error code 1702 mr_request.php");

}
		++$view_count;
		$query = "UPDATE cs_tweets SET view_count = '".$view_count."' WHERE tweet_id = '".$tweet_id."'";
		$result = mysql_query($query) or die (mysql_error()."Error code 1702 mr_request.php");

	// İstemciye json_encode fonksiyonu ile JSON'a çevirip yollayalım
	echo json_encode($JSON);
}
else
	echo "tweet yok";
?>

