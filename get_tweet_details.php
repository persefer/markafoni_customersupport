<?php

include_once("../db.php");

if(isset($_REQUEST['id_str']) AND $_REQUEST['id_str'] != "") $id_str = $_REQUEST['id_str'];

$sql = "SELECT * FROM cs_tweets WHERE tweet_id = '".$id_str."' LIMIT 1";
$result = mysql_query($sql) or die("Error code get_tweet_details.php".mysql_error());
	//	if($result) echo "---------0------";

if(mysql_num_rows($result))
{
	$JSON["results"]=array();
	while ($row = mysql_fetch_array($result) )
	{
		extract($row);
	//	echo "<br>is_active".$is_active."<br>";
		// Diziye veriyi diziler halinde  girelim
		array_push($JSON["results"],
			array(
				"id_str" => $tweet_id,
				"from_user" => stripslashes($from_user),
				"from_user_name" => stripslashes($from_user_name),
				"profile_image_url" => stripslashes($profile_image_url),
				"created_at" => stripslashes($date_orj),
				"text" => stripslashes($text),
				"in_reply_to_status_id" => $in_reply_to_status_id,
			)
		);
		
	}
	// İstemciye json_encode fonksiyonu ile JSON'a çevirip yollayalım
	echo json_encode($JSON);
}
else
	echo "tweet yok";
?>

