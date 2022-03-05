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
	echo "Oturum süresi sona ermiş.<br><a href=\"index.php\" class=\"btn btn-primary\">Anasayfaya geri dön</a>";
	die();
}

echo "<a href=\"admin.php\" class=\"btn btn-primary\">Anasayfa</a><br><br>";


function setAnswerType($answer_type_description) {
	    $query = "INSERT INTO cs_quick_answer_types ( `answer_type_description` ) 
              VALUES ( '".addslashes($_REQUEST['answer_type_description'])."' )";
    $result = mysql_query($query) or die("Error: quick_answer.php: ".mysql_error());
}

function getAnswerTypes() {
    $sql = "SELECT * FROM cs_quick_answer_types ORDER BY answer_type_description";
	$result = mysql_query($sql) or die("Error quick_answer.php".mysql_error());
	if(mysql_num_rows($result))
	{
		echo "<table>";
		while ($row = mysql_fetch_array($result) )
		{
			extract($row);
			echo "<tr><td style=\"padding:4px; border:1px solid #aaaaaa;\"><a href=\"quick_answers.php?answer_type_id=".$answer_type_id."\">".$answer_type_description."</a></td>
					<td style=\"padding:4px;\"><a href=\"quick_answers.php?delete_answer_type_id=".$answer_type_id."\" class=\"btn btn-mini btn-danger\">SİL</a></td>
					</tr>";
		}
		echo "</table>"; ?>
		<hr>
		<form action="quick_answers.php" method="post">
		<input type="text" name="answer_type_description">
		<input type="submit" value="Ekle">
		</form>
		<?php
		}
}

function deleteAnswerTypes($delete_answer_type_id) {
    $query = "DELETE FROM cs_quick_answer_types WHERE answer_type_id = '".$delete_answer_type_id."' LIMIT 1";
    $result = mysql_query($query) or die("Error: quick_answer.php: ".mysql_error());
}

function getQuickAnswers($answer_type_id) {
    $sql = "SELECT * FROM cs_quick_answers WHERE answer_type_id = ".$answer_type_id." ORDER BY answer_description";
	$result = mysql_query($sql) or die("Error quick_answer.php".mysql_error());
	if(mysql_num_rows($result))
	{	echo "<a href=\"quick_answers.php\" class=\"btn btn-inverse\">Geri</a><br><br>";
		echo "<table>";
		while ($row = mysql_fetch_array($result) )
		{
			extract($row);
			echo "<tr>\n
					<td style=\"padding:4px; border:1px solid #aaaaaa;\">".$answer_description."</a></td>\n
					<td style=\"padding:4px; border:1px solid #aaaaaa;\">".$answer."</a></td>\n
					<td style=\"padding:4px;\"><a href=\"quick_answers.php?delete_answer=".$answer_id."&answer_type_id=".$answer_type_id."\" class=\"btn btn-mini btn-danger\">SİL</a></td>\n
					</tr>";
		}
		echo "</table>"; 
	} ?>
	<br><form action="quick_answers.php" method="post">
	<input type="text" name="answer_description" maxlength="100">
	<input type="text" name="answer" maxlength="130">
	<input type="hidden" name="answer_type_id" value="<?=$answer_type_id;?>">
	<input type="submit" value="Ekle">
	</form>
	<hr>İlk alana kısa cevabı tanımlayan kısa bir bilgi yazın. İkinci alana ise kısa cevabın kendisini.
	<?php
}

function setQuickAnswer($answer_type_id,$answer_description,$answer) {
	$query = "INSERT INTO cs_quick_answers (
					`answer_type_id`,
					`answer_description`,
					`answer` ) 
				VALUES (
					'".addslashes($answer_type_id)."',
					'".addslashes($answer_description)."',
					'".addslashes($answer)."' ) ";
	$result = mysql_query($query) or die("Error: quick_answer.php: ".mysql_error());
}

function deleteQuickAnswer($delete_answer) {
    $query = "DELETE FROM cs_quick_answers WHERE answer_id = '".$delete_answer."' LIMIT 1";
    $result = mysql_query($query) or die("Error: quick_answer.php: ".mysql_error());
}

if(isset($_REQUEST['answer_description']) AND $_REQUEST['answer_description'] != "") setQuickAnswer($answer_type_id,$answer_description,$answer);
if(isset($_REQUEST['delete_answer']) AND $_REQUEST['delete_answer'] != "") deleteQuickAnswer($delete_answer);
if(isset($_REQUEST['answer_type_description']) AND $_REQUEST['answer_type_description'] != "") setAnswerType($answer_type_description);
if(isset($_REQUEST['delete_answer_type_id']) AND $_REQUEST['delete_answer_type_id'] != "") deleteAnswerTypes($delete_answer_type_id);



if(isset($_REQUEST['answer_type_id']) AND $_REQUEST['answer_type_id'] != "") getQuickAnswers($answer_type_id);
else getAnswerTypes();

?>

SİL butonuna basmayın, çünkü direk siler!
</blockquote>

</body>
</html>


