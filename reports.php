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


function getTweets()
{
	$sql = "SELECT * FROM cs_tweets WHERE is_active in (2,3) ORDER BY date_orj ASC";
	$result = mysql_query($sql) or die("Error code 93269591".mysql_error());
	if(mysql_num_rows($result))
	{
		while ($row = mysql_fetch_array($result) )
		{
			extract($row);
			$diff = $reply_text = $reply_date = "";

			if($is_active == 2)
			{
				$reply = getReplyTweet($tweet_id);
				$diff = (int) ((strtotime($reply['created_at'])-strtotime($created_at)) / 60);
				$reply_text = $reply['text'];
				$reply_date = stripslashes($reply['created_at']);
			}

			$option = explode(",", $options);
			echo "<tr>";
			echo "<td>".stripslashes($from_user_name)."</td>";
			echo "<td><a href=\"http://twitter.com/".stripslashes($from_user)."\" target=\"_blank\">@".stripslashes($from_user)."</a></td>";
//			echo "<td>".substr(stripslashes($date_orj), -26, 17)."</td>";
			echo "<td>".stripslashes($created_at)."</td>";
			echo "<td>".$reply_date."</td>";
			echo "<td>".$diff."</td>";
			echo "<td>".opt1($option[0])."</td>";
			echo "<td>".opt2($option[1])."</td>";
			echo "<td>".opt3($option[2])."</td>";
			echo "<td>".opt4($option[3])."</td>";
			echo "<td>".stripslashes($text)."</td>";
			echo "<td><a href=\"http://twitter.com/".stripslashes($from_user)."/status/".$tweet_id."\" target=\"_blank\">Göster</a></td>";
			echo "<td>".$reply_text."</td>";
			echo "</tr>";
		}
	}
	else
		echo "<tr><td colspan=9>Hiç cevaplanmış tweet yok</td></tr>";
}

function getReplyTweet($replyto_id)
{
	$sql = "SELECT text,created_at FROM cs_tweets WHERE replyto_id='".$replyto_id."' LIMIT 1";
	$result = mysql_query($sql) or die("Error code 93269591".mysql_error());
	if(mysql_num_rows($result))
	{
		while ($row = mysql_fetch_array($result) )
		{
			return $row;
		}
	}
	else
		return "tweet yok";
}

function opt1($opt)
{
	if($opt == 1) return "Bilgi";
	elseif($opt == 2) return "Öneri";
	elseif($opt == 3) return "Şikayet";
	elseif($opt == 4) return "Teşekkür";
}
function opt2($opt)
{
	if($opt == 1) return "Kampanyalar";
	elseif($opt == 2) return "Kuponlar";
	elseif($opt == 3) return "Müşteri Teşekkürü";
	elseif($opt == 4) return "Ödeme";
	elseif($opt == 5) return "Site Kullanımı";
	elseif($opt == 6) return "Teslimat";
	elseif($opt == 7) return "Ürün İade ve Değişim";
}
function opt3($opt)
{
	if($opt == 1) return "Alışveriş";
	elseif($opt == 2) return "Değişim Bilgisi";
	elseif($opt == 3) return "Geç Teslimat";
	elseif($opt == 4) return "Hatalı Gönderim";
	elseif($opt == 5) return "Hatalı/Defolu Gönderim";
	elseif($opt == 6) return "HD Talebi";
	elseif($opt == 7) return "İade Bilgisi";
	elseif($opt == 8) return "İade Gecikmesi";
	elseif($opt == 9) return "Kampanya Talebi";
	elseif($opt == 10) return "Kargo Şikayeti";
	elseif($opt == 11) return "Markafoni Kuponları";
	elseif($opt == 12) return "Müşteri Memnuniyeti/ Hızlı Geri Dönüş";
	elseif($opt == 13) return "Ödeme Seçenekleri";
	elseif($opt == 14) return "Pazarlama Kampanyaları";
	elseif($opt == 15) return "Pazarlama Kuponları";
	elseif($opt == 16) return "Tedarik Edilemeyen Ürün";
	elseif($opt == 17) return "Teslimat Bilgisi";
	elseif($opt == 18) return "Ürün Bilgi";
	elseif($opt == 19) return "Ürün Kalitesi";
	elseif($opt == 20) return "Ürün Tanıtımı";
	elseif($opt == 21) return "Üyelik";
}
function opt4($opt)
{
	if($opt == 1) return "Yurtiçi Kargo";
	elseif($opt == 2) return "Aras Kargo";
	elseif($opt == 3) return "IT Departmanı";
	elseif($opt == 4) return "IT Pazarlama";
	elseif($opt == 5) return "IT Yönetim";
	elseif($opt == 6) return "İade Departmanı";
	elseif($opt == 7) return "Lojistik";
	elseif($opt == 8) return "Markayönetim";
	elseif($opt == 9) return "Markayönetim - Kamp. Operasyon";
	elseif($opt == 10) return "Markayönetim - Lojistik";
	elseif($opt == 11) return "Markayönetim - Prodüksiyon";
	elseif($opt == 12) return "Müşteri Hizmetleri";
	elseif($opt == 13) return "Pazarlama";
	elseif($opt == 14) return "Pazarlama - Yönetim";
	elseif($opt == 15) return "Yönetim";
}


?>

<table id="report_table">
	<tr style="background-color: #dddddd; width:100%;">
		<td>Müşteri İsmi</td>
		<td>Mail/Sipariş No</td>
		<td>Geliş Zamanı</td>
		<td>Cevaplanma Zamanı</td>
		<td>Fark<br>(dakika)</td>
		<td>Statü</td>
		<td>Konu</td>
		<td>Konu Başlığı</td>
		<td>İlgili Departman</td>
		<td>Müşteri Tweeti</td>
		<td>Göster</td>
		<td>Cevap</td>
	</tr>
<?=getTweets();?>
</tabel>