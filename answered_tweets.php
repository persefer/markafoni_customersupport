<?php

include_once("../db.php");

header("Expires: Sunday June 10th 2011");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


function getAnswerTweet($tweet_id)
{
	$sql = "SELECT * FROM cs_tweets WHERE replyto_id = ".$tweet_id." ORDER BY date ASC";
	$result = mysql_query($sql) or die("Error code 93269591".mysql_error());
	if(mysql_num_rows($result))
	{
		$row = mysql_fetch_array($result);
		extract($row);
		echo "<blockquote>Cevap: ".stripslashes($text);
//		if($replyto_id) getAnswerTweet($replyto_id);
		echo "</blockquote>";
	}
	else
		echo "Cevap yok?";
}

$sql = "SELECT * FROM cs_tweets WHERE is_active = 2 ORDER BY date ASC";
$result = mysql_query($sql) or die("Error code 93269591".mysql_error());
if(mysql_num_rows($result))
{

	while ($row = mysql_fetch_array($result) )
	{
		extract($row);
		echo stripslashes($from_user_name)." - <a href=\"http://twitter.com/".stripslashes($from_user)."\" target=\"_blank\">".stripslashes($from_user)."</a><br>";
		echo stripslashes($text)." <a href=\"http://twitter.com/".stripslashes($from_user)."/status/".$tweet_id."\" target=\"_blank\">Göster</a><br>";
		getAnswerTweet($tweet_id);
		echo "<hr>";
				// "id_str" => $tweet_id,
				// "from_user" => stripslashes($from_user),
				// "from_user_name" => stripslashes($from_user_name),
				// "profile_image_url" => stripslashes($profile_image_url),
				// "created_at" => stripslashes($date_orj),
				// "text" => stripslashes($text),
				// "is_active" => stripslashes($is_active)
	}
}
else
	echo "Hiç cevaplanmış tweet yok";
?>

