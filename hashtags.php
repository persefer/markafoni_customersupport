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
<blockquote>


<?php

include_once("../db.php");
if($_SESSION['twitter_oauth_token'] == "") {
	echo "Oturum süresi sona ermiş.<br><a href=\"index.php\">Anasayfaya geri dön</a>";
	die();
}



function deleteHashtag($hashtag_id) {
    $query = "DELETE FROM cs_hashtags WHERE hashtag_id = '".$hashtag_id."' LIMIT 1";
    $result = mysql_query($query) or die("Error: hashtags.php: ".mysql_error());
}

function getHashtags($campaign_id) {
    $sql = "SELECT * FROM cs_hashtags WHERE campaign_id = 1 ORDER BY hashtag";
	$result = mysql_query($sql) or die("Error hashtags.php".mysql_error());
	if(mysql_num_rows($result))
	{	
		echo "<table>";
		while ($row = mysql_fetch_array($result) )
		{
			extract($row);
			echo "<tr>\n
					<td style=\"padding:4px; border:1px solid #aaaaaa;\">".$hashtag."</a></td>\n
					<td style=\"padding:4px;\"><a href=\"hashtags.php?delete_hashtag=".$hashtag_id."\" class=\"btn btn-mini btn-danger\">SİL</a></td>\n
					</tr>";
		}
		echo "</table>"; 
	} ?>
	<hr>
	<form action="hashtags.php" method="post">
	<input type="text" name="hashtag">
	<input type="submit" value="Ekle">
	</form>
	<hr>DİKKAT sil butonu anahtar kelimeleri direk siler!<br><br>Eklemek istediğiniz anahtar kelimeyi yazıp ekleye basın.<br>Birbirini kapsayan kelimeleri girmeyin!<br>Örneğin hem markafoni hem markafonidunyasi. sadece markafoniyi gizmeniz yeter. @markafoni veya #markafoni yi de girmenize gerek yok. markafoni yi girmeniz yeterli.<br>Bir anahtar kelimeyi silince onunla ilgili geçmişte yapılanlar işlemlere zarar gelmez.
	<?php
}

function setHashtag($hashtag) {
	$query = "INSERT INTO cs_hashtags (
					`campaign_id`,`hashtag` ) 
				VALUES ( '1','".addslashes($hashtag)."' ) ";
	$result = mysql_query($query) or die("Error: hashtags.php: ".mysql_error());
}

if(isset($_REQUEST['hashtag']) AND $_REQUEST['hashtag'] != "") setHashtag($hashtag);
if(isset($_REQUEST['delete_hashtag']) AND $_REQUEST['delete_hashtag'] != "") deleteHashtag($delete_hashtag);

echo "<a href=\"admin.php\" class=\"btn btn-primary\">Anasayfa</a><br><br>";

getHashtags(1);

?>

<hr>
SİL butonuna basmayın, çünkü direk siler!
</blockquote>

</body>
</html>


