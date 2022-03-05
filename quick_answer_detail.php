<?php
include_once("../db.php");

$sql = "SELECT answer FROM cs_quick_answers WHERE answer_id = '".$_REQUEST['answer_id']."'";
$result = mysql_query($sql) or die("Error code get_tweet_details.php".mysql_error());
	//	if($result) echo "---------0------";

if(mysql_num_rows($result))
{
	while ($row = mysql_fetch_array($result) )
	{
		extract($row);
		echo $answer;
	}
}
else
	echo "bu id li cevap db de yok";
?>
