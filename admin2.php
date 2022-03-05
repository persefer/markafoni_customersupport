<?php
/* Load required lib files. */
include_once("../db.php");
require_once('twitteroauth/twitteroauth.php');
require_once('config.php');

/* If access tokens are not available redirect to connect page. */
if (empty($_SESSION['twitter_oauth_token']) || empty($_SESSION['twitter_oauth_token_secret'])) {
    header('Location: ./kill.php');
//	print_r($_SESSION);
}

// Create a TwitterOauth object with consumer/user tokens. 
$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['twitter_oauth_token'], $_SESSION['twitter_oauth_token_secret']);

// If method is set change API call made. Test is called by default. 
//$content = $connection->get('account/verify_credentials');

//print_r($content);
/* Some example calls */
//$connection->get('users/show', array('screen_name' => 'abraham'));
//$connection->post('statuses/update', array('status' => date(DATE_RFC822)));
//$connection->post('statuses/destroy', array('id' => 5437877770));
//$connection->post('friendships/create', array('id' => 9436992));
//$connection->post('friendships/destroy', array('id' => 9436992));

$connection->get('users/profile_image', array('screen_name' => 'abraham'));



function getAnswerName($answer_type_id)
{
  $sql = "SELECT answer_description,answer_id FROM cs_quick_answers WHERE answer_type_id = '".$answer_type_id."' ";
  $result = mysql_query($sql) or die("Error quick_answer_menu.php".mysql_error());
  if(mysql_num_rows($result))
  {
    echo "<ul>\n";
    while ($row = mysql_fetch_array($result) )
    {
      extract($row);
      echo "<li><a href=\"#\" class=\"quick_answer\" id=\"".$answer_id."\">".$answer_description."</a></li>\n";
    }
    echo "</ul>\n";
  } 
}

function getAnswerList($type)
{
  if($type == "twitter")
    $sql = "SELECT * FROM cs_quick_answer_types";

  $result = mysql_query($sql) or die("Error quick_answer_menu.php".mysql_error());
  if(mysql_num_rows($result))
  {
    echo "<ul>\n";
    while ($row = mysql_fetch_array($result) )
    {
      extract($row);
      echo "<li><a href=\"#\">".$answer_type_description."</a>\n";
      getAnswerName($answer_type_id);
      echo "</li>\n";
    }
    echo "</ul>\n";
  }
  else
    echo "bu id li cevap db de yok";
}

/*
stdClass Object ( [time_zone] => Istanbul [created_at] => Mon Apr 18 10:18:04 +0000 2011 [default_profile_image] => [name] => Ozan Dikerler [profile_background_image_url] => http://a0.twimg.com/profile_background_images/234528508/baska_turlu_bir_sey_by_MiniQ.jpg [favourites_count] => 184 [profile_link_color] => 0084B4 [notifications] => [statuses_count] => 404 [is_translator] => [id] => 283953202 [status] => stdClass Object ( [in_reply_to_status_id] => 331670143220465664 [truncated] => [id_str] => 331671852340621312 [in_reply_to_screen_name] => tugcekrsmnoglu [created_at] => Tue May 07 07:28:26 +0000 2013 [source] => web [in_reply_to_status_id_str] => 331670143220465664 [place] => stdClass Object ( [country] => TÃ¼rkiye [full_name] => TÃ¼rkiye [url] => http://api.twitter.com/1/geo/id/682c5a667856ef42.json [country_code] => TR [id] => 682c5a667856ef42 [bounding_box] => stdClass Object ( [type] => Polygon [coordinates] => Array ( [0] => Array ( [0] => Array ( [0] => 25.663883 [1] => 35.817497 ) [1] => Array ( [0] => 44.822762 [1] => 35.817497 ) [2] => Array ( [0] => 44.822762 [1] => 42.109993 ) [3] => Array ( [0] => 25.663883 [1] => 42.109993 ) ) ) ) [attributes] => stdClass Object ( ) [place_type] => country [name] => TÃ¼rkiye ) [favorited] => [id] => 331671852340621312 [in_reply_to_user_id_str] => 124530842 [contributors] => [in_reply_to_user_id] => 124530842 [geo] => [retweet_count] => 0 [text] => @tugcekrsmnoglu Ã¶zel sektÃ¶rde sosyal medya paylaÅŸÄ±mlarÄ±nÄ±n marka geliÅŸimine etkileri ve seÃ§tiÄŸin bir marka iÃ§in proje Ã§alÄ±ÅŸmasÄ± olabilir [coordinates] => [retweeted] => ) [geo_enabled] => 1 [friends_count] => 393 [screen_name] => ozandikerler [profile_use_background_image] => 1 [followers_count] => 200 [profile_text_color] => 333333 [url] => http://www.persefer.com [lang] => tr [default_profile] => [utc_offset] => 7200 [location] => Ä°stanbul [id_str] => 283953202 [profile_background_image_url_https] => https://si0.twimg.com/profile_background_images/234528508/baska_turlu_bir_sey_by_MiniQ.jpg [profile_sidebar_border_color] => C0DEED [follow_request_sent] => [protected] => [description] => Founder of Persefer Studios, mobile application provider in Turkiye. Teoman, YÃ¼ksek Sadakat, iQuiz, Mutfakta Neler Var [profile_background_tile] => 1 [listed_count] => 4 [following] => [profile_sidebar_fill_color] => DDEEF6 [verified] => [profile_image_url] => http://a0.twimg.com/profile_images/1315769930/IMG_4008_normal.jpg [profile_image_url_https] => https://si0.twimg.com/profile_images/1315769930/IMG_4008_normal.jpg [profile_background_color] => 000000 [contributors_enabled] => ) 
*/

?>
<!DOCTYPE html>
<!--[if lt IE 7]>       <html class="no-js lt-ie9 lt-ie8 lt-ie7">   <![endif]-->
<!--[if IE 7]>          <html class="no-js lt-ie9 lt-ie8">          <![endif]-->
<!--[if IE 8]>          <html class="no-js lt-ie9">                 <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js">                        <!--<![endif]-->
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
  <br>


&nbsp;&nbsp;&nbsp;&nbsp;<a id="hideall" class="btn btn-primary">Bekleyen Tweetler</a>
<a id="answered_tweets" class="btn btn-primary">Cevaplanmış Tweetler</a>
<a id="reports" class="btn btn-primary">Raporlar</a>
<a href="kill.php" class="btn btn-primary">Çıkış</a>


<img src="https://api.twitter.com/1/users/profile_image?screen_name=<?=$_SESSION['twitter_screen_name'];?>&size=normal" style="float:right; margin-right:20px;">

<br><br>


<div id="wait"><img src="images/progress_bar.gif"></div>
<div id="float"></div>
<div id="tweets">
  <div class="tweet" style="background-color: #ffffff;"></div>
</div>


<script type="text/javascript">
console.log('oauth_token: <?php echo $_SESSION['access_token']['oauth_token'].'\noauth_token_secret: '.$_SESSION['access_token']['oauth_token_secret']; ?>');

function relativeTime(timeString) {
        var parsedDate = Date.parse(timeString);
        var delta = (Date.parse(Date()) - parsedDate) / 1000;
        var r = '';
        if  (delta < 60) {
          r = delta + " saniye önce";
        } else if (delta < 120) {
          r = "bir dakika önce";
        } else if (delta < (45 * 60)) {
          r = (parseInt(delta / 60, 10)).toString() + " dakika önce";
        } else if (delta < (90 * 60)) {
          r = "bir saat önce";
        } else if (delta < (24 * 60 * 60)) {
          r = '' + (parseInt(delta / 3600, 10)).toString() + " saat önce";
        } else if (delta < (48 * 60 * 60)) {
          r = "bir gün önce";
        } else {
          r = (parseInt(delta / 86400, 10)).toString() + " gün önce";
        }
        return r;
}





var tweetId_Array = new Array(7);
var from_user = "";

function getTweetReply(id_str, callback) {
  $.getJSON("get_tweet_reply.php", {id_str: id_str}, function(json) {
    var tweet_reply = '<blockquote><img src="https://api.twitter.com/1/users/profile_image?screen_name='+ json.results[0].screen_name+'&size=mini">' + json.results[0].screen_name+ ': ' + json.results[0].text + '</blockquote>';
    callback(tweet_reply);
  });
}

/*
function getTweetReply(id_str) {
    $.getJSON("get_tweet_reply.php", {id_str: id_str}, function(json) {
      tweet_relpy = '<blockquote>' +json.results[0].screen_name+ ': '+json.results[0].text+'</blockquote>';
      return tweet_relpy;
    });
}
*/

function postTweet(tweet_id)
{
    $.getJSON("get_tweet.php", {
                                tweet_id: tweet_id},
                                 function(json) {
                                    alert("ok");
    });
}

$("#hideall").click(function(){
    $("#float").html('');
});

$(document).on("click", "#answered_tweets",function(){
  $.get('answered_tweets.php', function(data) {
    $("#float").html('<div id="replybox">'+data+'</div>');
  });
});

$(document).on("click", "#reports",function(){
  $.get('reports.php', function(data) {
    $("#float").html('<div id="replybox">'+data+'</div>');
  });
});

/*********************************************************************

https://api.twitter.com/1/statuses/show.json?id=332807207936749568&include_entities=true

in_reply_to_status_id 

$connection->post('statuses/update',
array("status" => "Test",
        "in_reply_to_status_id"=>2314302740));
*/

$(document).on("click", ".tweet",function(){
    var id_str = $(this).attr("id");

    $.getJSON("get_tweet_details.php", {id_str: id_str},     function(json) {

      getTweetReply(json.results[0].in_reply_to_status_id, function(reply){
        var tweet = '<img src="'+json.results[0].profile_image_url+'"><br>\
                ' + json.results[0].from_user + '<br>\
                ' + json.results[0].from_user_name + '<br>\
                Cevap: ' + reply + '</b><br>'; 

            tweet += relativeTime(json.results[0].created_at) + '<br>\
                <textarea id="textarea" readonly="true" from_user="@' + json.results[0].from_user + '">@' + json.results[0].from_user + ' </textarea><br>\
        <select name="opt_1">\
          <option value="">Statü Seç</option>\
          <option value="1">Bilgi</option>\
          <option value="2">Öneri</option>\
          <option value="3">Şikayet</option>\
          <option value="4">Teşekkür</option>\
        </select>\
        <select name="opt_2">\
          <option value="">Konu Seç</option>\
          <option value="1">Kampanyalar</option>\
          <option value="2">Kuponlar</option>\
          <option value="3">Müşteri Teşekkürü</option>\
          <option value="4">Ödeme</option>\
          <option value="5">Site Kullanımı</option>\
          <option value="6">Teslimat</option>\
          <option value="7">Ürün İade ve Değişim</option>\
        </select>\
        <select name="opt_3">\
          <option value="" style="font: bold;">Konu Başlığı Seç</option>\
          <option value="1">Alışveriş</option>\
          <option value="2">Değişim Bilgisi</option>\
          <option value="3">Geç Teslimat</option>\
          <option value="4">Hatalı Gönderim</option>\
          <option value="5">Hatalı/Defolu Gönderim</option>\
          <option value="6">HD Talebi</option>\
          <option value="7">İade Bilgisi</option>\
          <option value="8">İade Gecikmesi</option>\
          <option value="9">Kampanya Talebi</option>\
          <option value="10">Kargo Şikayeti</option>\
          <option value="11">Markafoni Kuponları</option>\
          <option value="12">Müşteri Memnuniyeti/ Hızlı Geri Dönüş</option>\
          <option value="13">Ödeme Seçenekleri</option>\
          <option value="14">Pazarlama Kampanyaları</option>\
          <option value="15">Pazarlama Kuponları</option>\
          <option value="16">Tedarik Edilemeyen Ürün</option>\
          <option value="17">Teslimat Bilgisi</option>\
          <option value="18">Ürün Bilgi</option>\
          <option value="19">Ürün Kalitesi</option>\
          <option value="20">Ürün Tanıtımı</option>\
          <option value="21">Üyelik</option>\
        </select>\
        <select name="opt_4">\
          <option value="" style="font: bold;">İlgili Departman Seç</option>\
          <option value="1">Yurtiçi Kargo</option>\
          <option value="2">Aras Kargo</option>\
          <option value="3">IT Departmanı</option>\
          <option value="4">IT Pazarlama</option>\
          <option value="5">IT Yönetim</option>\
          <option value="6">İade Departmanı</option>\
          <option value="7">Lojistik</option>\
          <option value="8">Markayönetim</option>\
          <option value="9">Markayönetim - Kamp. Operasyon</option>\
          <option value="10">Markayönetim - Lojistik</option>\
          <option value="11">Markayönetim - Prodüksiyon</option>\
          <option value="12">Müşteri Hizmetleri</option>\
          <option value="13">Pazarlama</option>\
          <option value="14">Pazarlama - Yönetim</option>\
          <option value="15">Yönetim</option>\
        </select>\
        <input type="hidden" id="submit" tweet_id="'+id_str+'"><br><br><hr><br>';
       $("#float").html('<div id="replybox">'+ tweet +'</div>');
      });
    });
});

$(document).on("click", "button",function () {
    var id_str = $('#submit').attr("tweet_id");
    var button = $(this).attr("id");

    if(!id_str) alert("Önce bir tweet seçmelisiniz!");
    else
      {
        var opt_1 = $('select[name="opt_1"]').val();
        var opt_2 = $('select[name="opt_2"]').val();
        var opt_3 = $('select[name="opt_3"]').val();
        var opt_4 = $('select[name="opt_4"]').val();

        if(!(opt_1 && opt_2 && opt_3 && opt_4))
        {
          alert("Önce tweet ile ilgili tanımlamaları seçmelisin!");
          $('select').css({ 'background-color': '#ffdddd' });
        }
        else
        {
          $('#wait').show();
          $.post("post_tweet.php", { button: button, replyto_id: id_str, tweet_reply: $('#textarea').val(),
            opt_1: opt_1,
            opt_2: opt_2,
            opt_3: opt_3,
            opt_4: opt_4
             },  function(result) {

            switch (result.substring(0,3)) {
              case '200':
              case '304':
                $("#float").html('');
                $('#'+id_str).css( "background-color", "#d9f8d2" );
                $('#'+id_str+' .status').html('Cevaplandı');
                $('#'+id_str).delay(4000).slideToggle(2000);
                break;
              case '400':
              case '401':
              case '403':
              case '404':
              case '406':
                alert("tweet gönderilemedi");
                $("#float").html('');
                $('#'+id_str).css( "background-color", "#ffa8d2" );
                break;
              case '500':
              case '502':
              case '503':
                alert("Tweet gönderilemedi");
                $('#'+id_str).css( "background-color", "#ffa8d2" );
                $("#float").html('');
                break;
              case '600':
                alert("Tweet bilgileri kaydedilemedi");
                $('#'+id_str).css( "background-color", "#ffa8d2" );
                $("#float").html('');
                break;
              case 'sessiontimeout':
                alert("Oturum süresi sona ermiş.");
                self.location="clearsessions.php";
                break;
              default:
            }
          });
          $('#wait').hide();

        }
      }
});


/* statuses/update 
date_default_timezone_set('GMT');
$parameters = array('status' => "@".$_REQUEST['from_user']." deneme");
$status = $connection->post('statuses/update', $parameters);
twitteroauth_row('statuses/update', $status, $connection->http_code, $parameters);
*/






var second = 0;
function display(){ 
    second += 1;
    
    $.getJSON("get_tweet.php", {
                  id_str_1: tweetId_Array[0],
                  id_str_2: tweetId_Array[1],
                  id_str_3: tweetId_Array[2],
                  id_str_4: tweetId_Array[3],
                  id_str_5: tweetId_Array[4],
                  id_str_6: tweetId_Array[5],
                  id_str_7: tweetId_Array[6],
},
                                 function(json) {

        tweetId_Array.push(json.results[0].id_str);
        tweetId_Array.shift();


        tweet = '<div class="tweet" id="' + json.results[0].id_str + '">\
                    <span class="from_user_name"><a href="https://twitter.com/' + json.results[0].from_user + '" target="_blank">' + json.results[0].from_user_name + '</a></span>\
                    <span class="text">' + json.results[0].text + '</span>\
                    <span class="status">Yeni</span>\
                    <span class="time">'+json.results[0].sent_at+'</span>\
                </div>';
    $('#'+json.results[0].id_str).delay(4000).remove();
        $(tweet).animate({height: 'toggle'},2000).insertBefore("#tweets .tweet:first-child");

//                    <span class="time">'+json.results[0].sent_at+' ' + relativeTime(json.results[0].created_at) + '</span>\



    });
    setTimeout("display()",10000);
} 
display();


</script>

        </div>
        <!-- END WRAP -->

        <div class="clearfix"></div>

<div id="quick_answer_bar">
  <button id="save_description" class="btn btn-large btn-primary" type="button">Kaydet</button>
  <button id="send_reply" class="btn btn-large btn-primary" type="button">Gönder</button>

  <a tabindex="0" href="#news-items" class="fg-button fg-button-icon-right ui-widget ui-state-default ui-corner-all" id="hierarchy">
    <span class="ui-icon ui-icon-triangle-1-s"></span>Twitter Hazır Cevapları</a>
  <div id="news-items" class="hidden">
    <?=getAnswerList("twitter");?>
  </div>
  <div class="quick_answer_text">HAZIR CEVAP SEÇ: </div>
</div>
<script type="text/javascript"> 
// Hazır cevap menüsü   
$(function(){     
    $('#hierarchy').menu({
      content: $('#hierarchy').next().html(),
      width: 390,
      crumbDefaultText: 'Geri',
      backLink: true,
      backLinkText: 'Geri'
    });
    
});
/*
function ping(){ $.ajax({ url: 'class/class_twittersearch.php' }); }
var second2 = 0;
function display2(){ 
  second2 += 1;
  setTimeout("display2()",60000);
  ping2();
} 
display2();
*/

</script>
</body>
</html>